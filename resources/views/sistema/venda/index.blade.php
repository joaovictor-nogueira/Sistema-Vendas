@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Vendas</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Lista de Vendas</h2>
            <a href="{{ route('venda.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nova Venda
            </a>
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
            <table class="table table-striped table-hover align-middle mb-0" id="vendaTable">
                <thead class="">
                    <tr>
                        <th>Cod.</th>
                        <th>Data</th>
                        <th>Valor</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Tipo Pagamento</th>
                        <th>Forma Pagamento</th>
                        <th>Ações</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($vendas as $venda)
                        <tr>
                            <td>{{ $venda->id }}</td>
                            <td>{{ $venda->created_at->format('d/m/Y H:i') }}</td>
                            <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                            <td>{{ $venda->cliente->nome ?? ''  }}</td>
                            <td>{{ $venda->user->name ?? ''}}</td>
                            <td>
                                @if ($venda->tipo_pagamento === 'avista')
                                    À Vista
                                @else
                                    Parcelado
                                @endif
                            </td>
                            <td>{{ $venda->forma_pagamento }}</td>
                            <td>

                                <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal"
                                    data-bs-target="#showVendaModal{{ $venda->id }}">
                                    <i class="bi bi-eye"></i>
                                </button>

                                </button>

                                @include('sistema.venda.modais.showVendaModal')

                                <a href="{{route('venda.edit', $venda->id)}}" class="btn btn-sm btn-warning text-white">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('venda.destroy', $venda->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Tem certeza que deseja excluir esta venda?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger text-white">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                                

                            </td>
                        </tr>



                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
