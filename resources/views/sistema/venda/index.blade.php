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
            <div class="p-2">
                <button class="btn btn-outline-secondary btn-sm" id="toggleFiltros">
                    <i class="fas fa-filter me-1"></i> Filtros
                </button>
            </div>

            <div id="filtrosContainer" class="card shadow-sm p-2 border-0 rounded mb-2" style="display: none;">
                <div class="card-body p-2">

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="filtroCodigo" class="form-label fw-semibold">Código</label>
                            <input type="text" id="filtroCodigo" class="form-control form-control-sm"
                                placeholder="Digite o código da venda">
                        </div>
                        <div class="col-md-4">
                            <label for="filtroCliente" class="form-label fw-semibold">Cliente</label>
                            <input type="text" id="filtroCliente" class="form-control form-control-sm"
                                placeholder="Digite o cliente">
                        </div>
                        <div class="col-md-4">
                            <label for="filtroVendedor" class="form-label fw-semibold">Vendedor</label>
                            <input type="text" id="filtroVendedor" class="form-control form-control-sm"
                                placeholder="Digite o nome do vendedor">
                        </div>
                        <div class="col-md-4">
                            <label for="filtroTipoPagamento" class="form-label fw-semibold">Tipo de Pagamento</label>
                            <select id="filtroTipoPagamento" class="form-select form-select-sm">
                                <option value="">Todos</option>
                                <option value="À Vista">À Vista</option>
                                <option value="parcelado">Parcelado</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="filtroFormaPagamento" class="form-label fw-semibold">Forma de Pagamento</label>
                            <select id="filtroFormaPagamento" class="form-select form-select-sm">
                                <option value="">Todas</option>
                                <option value="Cartão de Crédito">Cartão de Crédito</option>
                                <option value="Cartão de Débito">Cartão de Débito</option>
                                <option value="Pix">Pix</option>
                                <option value="Dinheiro">Dinheiro</option>
                                <option value="Outros">Outros</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="filtroDataInicio" class="form-label fw-semibold">Data Emissão Início</label>
                            <input type="date" id="filtroDataInicio" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2">
                            <label for="filtroDataFim" class="form-label fw-semibold">Data Emissão Fim</label>
                            <input type="date" id="filtroDataFim" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button class="btn btn-outline-secondary btn-sm" id="resetarFiltros">
                            <i class="fas fa-sync-alt me-1"></i> Resetar Filtros
                        </button>
                    </div>
                </div>
            </div>

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
                            <td>{{ $venda->cliente->nome ?? '' }}</td>
                            <td>{{ $venda->user->name ?? '' }}</td>
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

                                <a href="{{ route('venda.edit', $venda->id) }}" class="btn btn-sm btn-warning text-white">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('venda.destroy', $venda->id) }}" method="POST"
                                    style="display:inline-block;"
                                    onsubmit="return confirm('Tem certeza que deseja excluir esta venda?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger text-white">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>

                                <a href="{{ route('vendas.pdf', $venda->id) }}" class="btn btn-sm btn-primary text-white">
                                    <i class="bi bi-filetype-pdf"></i>
                                </a>

                            </td>
                        </tr>



                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = new DataTable('#vendaTable', {
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
                    [1, 'desc']
                ],
                pageLength: 10,
                ordering: true,
                columnDefs: [{
                    orderable: false,
                    targets: [7]
                }]
            });

            $('#toggleFiltros').on('click', function() {
                $('#filtrosContainer').slideToggle();
            });

            $('#filtroCodigo, #filtroCliente, #filtroDataInicio, #filtroDataFim, #filtroVendedor, #filtroTipoPagamento, #filtroFormaPagamento')
                .on('input change', function() {
                    table.draw();
                });

            function converterData(dataStr) {
                if (!dataStr) return null;
                const partes = dataStr.split('/');
                return new Date(`${partes[2]}-${partes[1]}-${partes[0]}`);
            }

            function removerAcentos(texto) {
                return texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
            }

            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                const codigo = $('#filtroCodigo').val().toLowerCase();
                const cliente = $('#filtroCliente').val().toLowerCase();
                const vendedor = $('#filtroVendedor').val().toLowerCase();
                const tipoPagamento = $('#filtroTipoPagamento').val();
                const formaPagamento = $('#filtroFormaPagamento').val();
                const dataInicio = $('#filtroDataInicio').val();
                const dataFim = $('#filtroDataFim').val();

                const colunaCodigo = data[0].toLowerCase();
                const colunaData = data[1];
                const colunaCliente = data[3].toLowerCase();
                const colunaVendedor = data[4].toLowerCase();
                const colunaTipoPagamento = data[5];
                const colunaFormaPagamento = data[6];

                if (codigo && !colunaCodigo.includes(codigo)) return false;
                if (cliente && !colunaCliente.includes(cliente)) return false;
                if (vendedor && !colunaVendedor.includes(vendedor)) return false;

                if (tipoPagamento && !removerAcentos(colunaTipoPagamento).includes(removerAcentos(
                        tipoPagamento))) return false;
                if (formaPagamento && !removerAcentos(colunaFormaPagamento).includes(removerAcentos(
                        formaPagamento))) return false;

                const dataEmissao = converterData(colunaData);
                if (dataInicio && dataEmissao < new Date(dataInicio)) return false;
                if (dataFim && dataEmissao > new Date(dataFim)) return false;

                return true;
            });

            $('#resetarFiltros').on('click', function() {
                $('#filtroCodigo, #filtroCliente, #filtroVendedor, #filtroDataInicio, #filtroDataFim').val(
                    '');
                $('#filtroTipoPagamento, #filtroFormaPagamento').val('');
                table.search('').columns().search('').draw();
            });

        });
    </script>
@endsection
