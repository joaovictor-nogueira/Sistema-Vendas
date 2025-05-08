<div class="modal fade" id="showVendaModal{{ $venda->id }}" tabindex="-1"
    aria-labelledby="showVendaModalLabel{{ $venda->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5 fw-bold" id="showVendaModalLabel{{ $venda->id }}">Detalhes da Venda #{{ $venda->id }}</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0 fw-bold">Dados da Venda</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Criação:</span>
                                <span>{{ $venda->created_at->format('d/m/y H:i') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Cliente:</span>
                                <span>{{ $venda->cliente->nome ?? '' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Vendedor:</span>
                                <span>{{ $venda->user->name ?? '' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Valor Total:</span>
                                <span class="badge bg-success rounded-pill fs-6">
                                    R$ {{ number_format($venda->valor_total, 2, ',', '.') }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Tipo de Pagamento:</span>
                                <span class="badge bg-info text-dark rounded-pill">
                                    @if ($venda->tipo_pagamento === 'avista')
                                        À Vista
                                    @else
                                        Parcelado
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Forma de Pagamento:</span>
                                <span>{{ $venda->forma_pagamento }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0 fw-bold">Itens da Venda</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produto</th>
                                        <th class="text-end">Quantidade</th>
                                        <th class="text-end">Preço Unitário</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($venda->itens as $item)
                                    <tr>
                                        <td>{{ $item->produto->nome }}</td>
                                        <td class="text-end">{{ $item->quantidade }}</td>
                                        <td class="text-end">R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                                        <td class="text-end fw-bold">R$ {{ number_format($item->total, 2, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if($venda->tipo_pagamento !== 'avista')
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0 fw-bold">Parcelas</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nº Parcela</th>
                                        <th class="text-end">Valor</th>
                                        <th class="text-end">Vencimento</th>
                                        <th>Observação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($venda->parcelas as $parcela)
                                    <tr>
                                        <td>{{ $parcela->numero }}</td>
                                        <td class="text-end">R$ {{ number_format($parcela->valor, 2, ',', '.') }}</td>
                                        <td class="text-end">{{ $parcela->data->format('d/m/Y') }}</td>
                                        <td>{{ $parcela->observacao }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Fechar
                </button>
            </div>
        </div>
    </div>
</div>