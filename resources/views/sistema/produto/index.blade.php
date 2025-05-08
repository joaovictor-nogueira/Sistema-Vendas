@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Produtos</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Lista de Produtos</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProdutoModal">
                <i class="bi bi-plus-circle"></i> Novo Produto
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
            <table class="table table-striped table-hover align-middle mb-0" id="produtoTable">
                <thead class="">
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Status</th>
                        <th>Preço de Venda</th>
                        <th>Ações</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($produtos as $produto)
                        <tr>
                            <td>{{ $produto->id }}</td>
                            <td>{{ $produto->nome }}</td>
                            <td>
                                @if ($produto->status == 1)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                            <td> R$ {{ number_format($produto->preco_venda, 2, ',', '.') }} </td>

                            <td>

                                <button data-bs-toggle="modal" data-bs-target="#editProdutoModal{{ $produto->id }}"
                                    class="btn btn-sm btn-warning text-white">
                                    <i class="bi bi-pencil"></i>
                                </button>

                            </td>
                        </tr>

                        @include('sistema.produto.modais.editProduto')

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('sistema.produto.modais.createProduto')


    <script>
        new DataTable('#produtoTable', {
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/pt-BR.json',
                paginate: {
                    first: '&laquo;',
                    last: '&raquo;',
                    previous: '&lsaquo;',
                    next: '&rsaquo;'
                },

            },

            responsive: true,
            order: [
                [1, 'asc']
            ],
            pageLength: 10,
            ordering: true,
            fixedHeader: true,
            columnDefs: [{
                    orderable: false,
                    targets: [3]
                },

            ]

        });
    </script>
@endsection
