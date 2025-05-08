<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Venda #{{ $venda->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        h1,
        h2,
        h3,
        h4 {
            margin: 0;
            padding: 0;
        }

        .section {
            margin-bottom: 20px;
        }

        .title {
            background: #f0f0f0;
            padding: 8px;
            font-weight: bold;
        }

        .list-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .badge {
            padding: 3px 6px;
            border-radius: 4px;
        }

        .bg-success {
            background: #d4edda;
        }

        .bg-info {
            background: #d1ecf1;
            color: #0c5460;
        }
    </style>
</head>

<body>

    <h1>Detalhes da Venda #{{ $venda->id }}</h1>

    <div class="section">
        <div class="title">Dados da Venda</div>
        <div class="list-item">
            <strong>Criação:</strong>
            <span>{{ $venda->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="list-item">
            <strong>Cliente:</strong>
            <span>{{ $venda->cliente->nome ?? '' }}</span>
        </div>
        <div class="list-item">
            <strong>Vendedor:</strong>
            <span>{{ $venda->user->name ?? '' }}</span>
        </div>
        <div class="list-item">
            <strong>Valor Total:</strong>
            <span class="badge bg-success">R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</span>
        </div>
        <div class="list-item">
            <strong>Tipo de Pagamento:</strong>
            <span class="badge bg-info">
                {{ $venda->tipo_pagamento === 'avista' ? 'À Vista' : 'Parcelado' }}
            </span>
        </div>
        <div class="list-item">
            <strong>Forma de Pagamento:</strong>
            <span>{{ $venda->forma_pagamento }}</span>
        </div>
    </div>

    <div class="section">
        <div class="title">Itens da Venda</div>
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th class="text-right">Quantidade</th>
                    <th class="text-right">Preço Unitário</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venda->itens as $item)
                    <tr>
                        <td>{{ $item->produto->nome }}</td>
                        <td class="text-right">{{ $item->quantidade }}</td>
                        <td class="text-right">R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                        <td class="text-right">R$ {{ number_format($item->total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($venda->tipo_pagamento !== 'avista')
        <div class="section">
            <div class="title">Parcelas</div>
            <table>
                <thead>
                    <tr>
                        <th>Nº Parcela</th>
                        <th class="text-right">Valor</th>
                        <th class="text-right">Vencimento</th>
                        <th>Observação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($venda->parcelas as $parcela)
                        <tr>
                            <td>{{ $parcela->numero }}</td>
                            <td class="text-right">R$ {{ number_format($parcela->valor, 2, ',', '.') }}</td>
                            <td class="text-right">{{ $parcela->data->format('d/m/Y') }}</td>
                            <td>{{ $parcela->observacao }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</body>

</html>
