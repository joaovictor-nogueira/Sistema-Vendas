<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProdutoController extends Controller
{

    public function index()
    {
        $produtos = Produto::all();

        return view("sistema.produto.index", compact("produtos"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // esta no modal
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** dd($request->all()); */

        $regras = [
            'nome_produto' => 'required|string|min:3|max:100|unique:produtos,nome',
            'status_produto' => 'required|in:0,1',
            'preco_venda' => 'required|numeric|min:0',
        ];
    
        $feedback = [
            'nome_produto.required' => 'O campo nome é obrigatório.',
            'nome_produto.min' => 'O nome deve ter pelo menos :min caracteres.',
            'nome_produto.max' => 'O nome deve ter no máximo :max caracteres.',
            'nome_produto.unique' => 'Este produto já está cadastrado.',
            'status_produto.required' => 'O campo status é obrigatório.',
            'status_produto.in' => 'O status selecionado é inválido.',
            'preco_venda.required' => 'O campo preço de venda é obrigatório.',
            'preco_venda.numeric' => 'O preço de venda deve ser um valor numérico.',
            'preco_venda.min' => 'O preço de venda deve ser um valor positivo.',
        ];

        $request->validate($regras, $feedback);

        $produto = Produto::create([
            'nome' => $request['nome_produto'],
            'status'=> $request['status_produto'],
            'preco_venda'=> $request['preco_venda'],
        ]);

        return redirect()->back()->with('success','Produto cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        // esta no modal 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produto $produto)
    {
        

        $regras = [
            'nome_produto_edit' => ['required','string','min:3','max:100', Rule::unique('produtos', 'nome')->ignore($produto->id)],
            'status_produto_edit' => 'required|in:0,1',
            'preco_venda_edit' => 'required|numeric|min:0',
        ];
    
        $feedback = [
            'nome_produto_edit.required' => 'O campo nome é obrigatório.',
            'nome_produto_edit.min' => 'O nome deve ter pelo menos :min caracteres.',
            'nome_produto_edit.max' => 'O nome deve ter no máximo :max caracteres.',
            'nome_produto_edit.unique' => 'Este produto já está cadastrado.',
            'status_produto_edit.required' => 'O campo status é obrigatório.',
            'status_produto_edit.in' => 'O status selecionado é inválido.',
            'preco_venda_edit.required' => 'O campo preço de venda é obrigatório.',
            'preco_venda_edit.numeric' => 'O preço de venda deve ser um valor numérico.',
            'preco_venda_edit.min' => 'O preço de venda deve ser um valor positivo.',
        ];

        $request->validate($regras, $feedback);

        $produto->update([
            'nome' => $request['nome_produto_edit'],
            'status'=> $request['status_produto_edit'],
            'preco_venda'=> $request['preco_venda_edit'],
        ]);

        return redirect()->back()->with('success','Produto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        //
    }
}
