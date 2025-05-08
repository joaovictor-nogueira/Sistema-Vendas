<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();

        return view("sistema.cliente.index", compact("clientes"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // NÃO PRECISA POIS ESTA SENDO FEITO POR MODAL
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $regras = [
            'nome_cliente' => 'required|string|min:3|max:100',
            'email_cliente' => 'nullable|email|unique:clientes,email',
            'telefone_cliente' => 'nullable|max:20',
            'cpf_cliente' => 'nullable|unique:clientes,cpf',
            'status_cliente' => 'required|in:0,1',
        ];

        $feedback = [
            'nome_cliente.required' => 'O campo nome é obrigatório.',
            'nome_cliente.max' => 'O nome deve ter no máximo :max caracteres.',
            'email_cliente.email' => 'Informe um e-mail válido.',
            'email_cliente.unique' => 'Este e-mail já está cadastrado.',
            'telefone_cliente.min' => 'O telefone deve ter no mínimo :min caracteres.',
            'telefone_cliente.max' => 'O telefone deve ter no máximo :max caracteres.',
            'cpf_cliente.unique' => 'Este CPF já está cadastrado.',
            'status_cliente_edit.required' => 'O campo status é obrigatório.',
            'status_cliente_edit.in' => 'O status deve ser Ativo ou Inativo.',
        ];

        $request->validate($regras, $feedback);

        $cliente = Cliente::create([
            'nome' => $request['nome_cliente'],
            'email' => $request['email_cliente'],
            'telefone' => $request['telefone_cliente'],
            'cpf' => $request['cpf_cliente'],
            'status' => $request['status_cliente'],
        ]);

        return redirect()->back()->with('success', 'Cliente Cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        // Não precisa pois esta no modal
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $regras = [
            'nome_cliente_edit' => 'required|string|min:3|max:100',
            'email_cliente_edit' => ['nullable', 'email', Rule::unique('clientes', 'email')->ignore($cliente->id)],
            'telefone_cliente_edit' => 'nullable|max:20',
            'cpf_cliente_edit' => ['nullable',  Rule::unique('clientes', 'cpf')->ignore($cliente->id)],
            'status_cliente_edit' => 'required|in:0,1',
        ];

        $feedback = [
            'nome_cliente_edit.required' => 'O campo nome é obrigatório.',
            'nome_cliente_edit.max' => 'O nome deve ter no máximo :max caracteres.',
            'email_cliente_edit.email' => 'Informe um e-mail válido.',
            'email_cliente_edit.unique' => 'Este e-mail já está cadastrado.',
            'telefone_cliente_edit.min' => 'O telefone deve ter no mínimo :min caracteres.',
            'telefone_cliente_edit.max' => 'O telefone deve ter no máximo :max caracteres.',
            'cpf_cliente_edit.unique' => 'Este CPF já está cadastrado.',
            'status_cliente_edit.required' => 'O campo status é obrigatório.',
            'status_cliente_edit.in' => 'O status deve ser Ativo ou Inativo.',
        ];

        $request->validate($regras, $feedback);

        $cliente->update([
            'nome' => $request['nome_cliente_edit'],
            'email' => $request['email_cliente_edit'],
            'telefone' => $request['telefone_cliente_edit'],
            'cpf' => $request['cpf_cliente_edit'],
            'status' => $request['status_cliente_edit'],

        ]);

        return redirect()->back()->with('success', 'Cliente Atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        //
    }
}
