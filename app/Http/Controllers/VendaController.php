<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ItemVenda;
use App\Models\ParcelaVenda;
use App\Models\Produto;
use App\Models\Venda;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendas = Venda::all();

        return view("sistema.venda.index", compact("vendas"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $clientes = Cliente::where('status', 1)->get();

        $produtos = Produto::where('status', 1)->get();

        return view("sistema.venda.create", compact("clientes", "produtos"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $regras = [
            'cliente_id' => 'nullable|exists:clientes,id',
            'produtos.*.id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
            'produtos.*.valor_unitario' => 'required|numeric|min:0',
            'produtos.*.valor_total' => 'required|numeric|min:0',
            'forma_pagamento' => 'nullable|string|in:Cartão de Crédito,Cartão de Débito,Pix,Dinheiro,Outros',
            'tipo_pagamento' => 'required|string|in:avista,Parcelado',
            'qtd_parcelas' => 'numeric|max:12',
            'parcelas' => 'required_if:tipo_pagamento,Parcelado|array|min:1',
            'parcelas.*.valor' => 'required|numeric|min:0.01',
            'parcelas.*.data' => 'required|date|after_or_equal:today',
            'parcelas.*.observacao' => 'nullable|string|max:255',
        ];

        $feedback = [
            'cliente_id.exists' => 'Cliente selecionado não encontrado.',
            'produtos.required' => 'Você deve adicionar ao menos um produto.',
            'produtos.*.id.required' => 'O produto é obrigatório.',
            'produtos.*.id.exists' => 'O produto selecionado é inválido.',
            'produtos.*.quantidade.required' => 'A quantidade é obrigatória.',
            'produtos.*.quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'produtos.*.quantidade.min' => 'A quantidade deve ser no mínimo 1.',
            'produtos.*.valor_unitario.required' => 'O valor unitário é obrigatório.',
            'produtos.*.valor_unitario.numeric' => 'O valor unitário deve ser um número.',
            'produtos.*.valor_total.required' => 'O valor total é obrigatório.',
            'produtos.*.valor_total.numeric' => 'O valor total deve ser um número.',
            'forma_pagamento.in' => 'A forma de pagamento selecionada é inválida.',
            'tipo_pagamento.required' => 'O tipo de pagamento é obrigatório.',
            'tipo_pagamento.in' => 'O tipo de pagamento selecionado é inválido.',
            'qtd_parcelas.numeric' => 'A quantidade de parcelas deve ser um número.',
            'qtd_parcelas.max' => 'A quantidade máxima de parcelas é de 12.',
            'parcelas.required_if' => 'As parcelas são obrigatórias para pagamento parcelado.',
            'parcelas.*.valor.required' => 'O valor da parcela é obrigatório.',
            'parcelas.*.valor.numeric' => 'O valor da parcela deve ser numérico.',
            'parcelas.*.valor.min' => 'O valor da parcela deve ser maior que zero.',
            'parcelas.*.data.required' => 'A data de vencimento é obrigatória.',
            'parcelas.*.data.date' => 'A data de vencimento deve ser uma data válida.',
            'parcelas.*.data.after_or_equal' => 'A data de vencimento deve ser hoje ou futura.',
            'parcelas.*.observacao.max' => 'A observação pode ter no máximo 255 caracteres.',
        ];

        $request->validate($regras, $feedback);


        $valorConta = $request->input('valor_total');
        $produtos = $request->input('produtos', []);
        $parcelas = $request->input('parcelas', []);
        $somaParcelas = collect($parcelas)->sum('valor');

        if($request['tipo_pagamento'] == 'Parcelado'){
            if ($somaParcelas < $valorConta) {
                return redirect()->back()->withErrors(['parcelas' => 'A soma dos valores das parcelas não pode ser menor que o valor total da venda.'])->withInput();
            }
            if ($somaParcelas > $valorConta) {
                return redirect()->back()->withErrors(['parcelas' => 'A soma dos valores das parcelas não pode ser maiores que o valor total da venda.'])->withInput();
            }
        }

        try {
            $venda = Venda::create([
                'cliente_id' => $request['cliente_id'] ?? null,
                'user_id' => Auth::user()->id,
                'valor_total' => $request['valor_total'],
                'tipo_pagamento' => $request['tipo_pagamento'],
                'forma_pagamento'=> $request['forma_pagamento'],
            ]);

            foreach ($produtos as $index => $produto) {

                ItemVenda::create([
                    'venda_id' => $venda->id,
                    'produto_id' => $produto['id'],
                    'quantidade' => $produto['quantidade'],
                    'preco_unitario' => $produto['valor_unitario'],
                    'total' => $produto['valor_total'],
                ]);
            }

            if($request['tipo_pagamento'] == 'Parcelado'){
                foreach ($parcelas as $index => $parcela) {
                    ParcelaVenda::create([
                        'venda_id' => $venda->id,
                        'numero' => $index + 1 ,
                        'valor' => $parcela['valor'],
                        'data' => $parcela['data'],
                        'observacao' => $parcela['observacao'],
                    ]);
                }
            }

            return redirect()->route('venda.index')->with('success','Venda Realizada com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Não foi possível registrar a venda. Tente novamente. ' . $e->getMessage())->withInput();;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Venda $venda)
    {
        //MODAL
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venda $venda)
    {
        $clientes = Cliente::where('status', 1)->get();

        $produtos = Produto::where('status', 1)->get();

        $isEdit = true;

        return view('sistema.venda.edit', compact("venda", "produtos", "clientes", 'isEdit',));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venda $venda)
    {

        $regras = [
            'cliente_id' => 'nullable|exists:clientes,id',
            'produtos.*.id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|min:1',
            'produtos.*.valor_unitario' => 'required|numeric|min:0',
            'produtos.*.valor_total' => 'required|numeric|min:0',
            'forma_pagamento' => 'nullable|string|in:Cartão de Crédito,Cartão de Débito,Pix,Dinheiro,Outros',
            'tipo_pagamento' => 'required|string|in:avista,Parcelado',
            'qtd_parcelas' => 'numeric|max:12',
            'parcelas' => 'required_if:tipo_pagamento,Parcelado|array|min:1',
            'parcelas.*.valor' => 'required|numeric|min:0.01',
            'parcelas.*.data' => 'required|date|after_or_equal:today',
            'parcelas.*.observacao' => 'nullable|string|max:255',
        ];

        $feedback = [
            'cliente_id.exists' => 'Cliente selecionado não encontrado.',
            'produtos.required' => 'Você deve adicionar ao menos um produto.',
            'produtos.*.id.required' => 'O produto é obrigatório.',
            'produtos.*.id.exists' => 'O produto selecionado é inválido.',
            'produtos.*.quantidade.required' => 'A quantidade é obrigatória.',
            'produtos.*.quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'produtos.*.quantidade.min' => 'A quantidade deve ser no mínimo 1.',
            'produtos.*.valor_unitario.required' => 'O valor unitário é obrigatório.',
            'produtos.*.valor_unitario.numeric' => 'O valor unitário deve ser um número.',
            'produtos.*.valor_total.required' => 'O valor total é obrigatório.',
            'produtos.*.valor_total.numeric' => 'O valor total deve ser um número.',
            'forma_pagamento.in' => 'A forma de pagamento selecionada é inválida.',
            'tipo_pagamento.required' => 'O tipo de pagamento é obrigatório.',
            'tipo_pagamento.in' => 'O tipo de pagamento selecionado é inválido.',
            'qtd_parcelas.numeric' => 'A quantidade de parcelas deve ser um número.',
            'qtd_parcelas.max' => 'A quantidade máxima de parcelas é de 12.',
            'parcelas.required_if' => 'As parcelas são obrigatórias para pagamento parcelado.',
            'parcelas.*.valor.required' => 'O valor da parcela é obrigatório.',
            'parcelas.*.valor.numeric' => 'O valor da parcela deve ser numérico.',
            'parcelas.*.valor.min' => 'O valor da parcela deve ser maior que zero.',
            'parcelas.*.data.required' => 'A data de vencimento é obrigatória.',
            'parcelas.*.data.date' => 'A data de vencimento deve ser uma data válida.',
            'parcelas.*.data.after_or_equal' => 'A data de vencimento deve ser hoje ou futura.',
            'parcelas.*.observacao.max' => 'A observação pode ter no máximo 255 caracteres.',
        ];

        $request->validate($regras, $feedback);
        
   

        $valorConta = $request->input('valor_total');
        $produtos = $request->input('produtos', []);
        $parcelas = $request->input('parcelas', []);
        $somaParcelas = collect($parcelas)->sum('valor');

        if($request['tipo_pagamento'] == 'Parcelado'){
            if ($somaParcelas < $valorConta) {
                return redirect()->back()->withErrors(['parcelas' => 'A soma dos valores das parcelas não pode ser menor que o valor total da venda.'])->withInput();
            }
            if ($somaParcelas > $valorConta) {
                return redirect()->back()->withErrors(['parcelas' => 'A soma dos valores das parcelas não pode ser maiores que o valor total da venda.'])->withInput();
            }
        }



        try {
            $venda->update([
                'cliente_id' => $request['cliente_id'] ?? null,
                'valor_total' => $request['valor_total'],
                'tipo_pagamento' => $request['tipo_pagamento'],
                'forma_pagamento'=> $request['forma_pagamento'],
            ]);


            $venda->itens()->delete();

            foreach ($produtos as $index => $produto) {

                ItemVenda::create([
                    'venda_id' => $venda->id,
                    'produto_id' => $produto['id'],
                    'quantidade' => $produto['quantidade'],
                    'preco_unitario' => $produto['valor_unitario'],
                    'total' => $produto['valor_total'],
                ]);
            }

            $venda->parcelas()->delete();

            if($request['tipo_pagamento'] == 'Parcelado'){
                foreach ($parcelas as $index => $parcela) {
                    ParcelaVenda::create([
                        'venda_id' => $venda->id,
                        'numero' => $index + 1 ,
                        'valor' => $parcela['valor'],
                        'data' => $parcela['data'],
                        'observacao' => $parcela['observacao'],
                    ]);
                }
            }

            return redirect()->route('venda.index')->with('success','Atualização de venda Realizada com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Não foi possível atualizar a venda. Tente novamente. ' . $e->getMessage())->withInput();;
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venda $venda)
    {
        $venda->delete();

        return redirect()->route('venda.index')->with('success','Venda excluida com sucesso');
    }

    public function gerarPdf($id){
        $venda = Venda::with(['cliente', 'user', 'itens.produto', 'parcelas'])->findOrFail($id);

        $pdf = Pdf::loadView('sistema.venda.pdf.view', compact('venda'));
        return $pdf->download("venda_{$venda->id}.pdf");
    }
}
