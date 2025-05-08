@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cliente</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Lista de Clientes</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClienteModal">
                <i class="bi bi-plus-circle"></i> Novo Cliente
            </button>
        </div>



        <div class="mb-0 mr-2 ml-2 mt-2">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <div class="table-responsive shadow-sm rounded bg-white">
            <table class="table table-striped table-hover align-middle mb-0" id="clienteTable">
                <thead class="">
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Status</th>
                        <th>CPF</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->id }}</td>
                            <td>{{ $cliente->nome }}</td>
                            <td>
                                @if ($cliente->status == 1)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                            <td>{{ $cliente->cpf }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td>{{ $cliente->telefone }}</td>
                            <td>

                                <button data-bs-toggle="modal" data-bs-target="#editClienteModal{{ $cliente->id }}"
                                    class="btn btn-sm btn-warning text-white">
                                    <i class="bi bi-pencil"></i>
                                </button>

                            </td>
                        </tr>

                        @include('sistema.cliente.modais.editCliente')

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('sistema.cliente.modais.createCliente')
@endsection
