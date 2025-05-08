@extends('layouts.app')

@section('content')


    <div class="container py-4">
        <div class="card shadow rounded">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Editar Venda {{ $venda->id }}</h4>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

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


                <ul class="nav nav-tabs mb-4" id="vendasTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="produtos-tab" data-bs-toggle="tab" data-bs-target="#produtos"
                            type="button" role="tab" aria-controls="produtos" aria-selected="true">
                            <i class="bi bi-box-seam me-1"></i> Produtos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="parcelas-tab" data-bs-toggle="tab" data-bs-target="#parcelas"
                            type="button" role="tab" aria-controls="parcelas" aria-selected="false">
                            <i class="bi bi-credit-card me-1"></i> Pagamento
                        </button>
                    </li>
                </ul>

                <form action="{{ route('venda.update', $venda->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="tab-content" id="veiculoTabContent">


                        <div class="tab-pane fade show active" id="produtos" role="tabpanel"
                            aria-labelledby="produtos-tab">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="cliente_id" class="form-label">Cliente (Opcional)</label>
                                    <select name="cliente_id" id="cliente_id"
                                        class="form-select @error('cliente_id') is-invalid @enderror">
                                        <option disabled value=""
                                            {{ old('cliente_id', $venda->cliente?->id) ? '' : 'selected' }}>Selecione um
                                            cliente...</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}"
                                                {{ old('cliente_id', $venda->cliente?->id) == $cliente->id ? 'selected' : '' }}>
                                                {{ $cliente->nome }}
                                            </option>
                                        @endforeach
                                    </select>


                                    <p class="invalid-feedback d-block">{{ $errors->first('cliente_id') }}</p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h5 class="border-bottom pb-2">
                                    <i class="bi bi-list-check me-2"></i>Produtos
                                </h5>

                                @if (old('produtos'))
                                    @foreach (old('produtos') as $index => $produto)
                                        <div class="produto row g-3 align-items-end mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Produto <span class="text-danger">*</span></label>
                                                <select name="produtos[{{ $index }}][id]"
                                                    class="form-select produto-select @error("produtos.$index.id") is-invalid @enderror"
                                                    onchange="atualizarValor(this)" required>
                                                    <option selected disabled value="">Selecione um produto...
                                                    </option>
                                                    @foreach ($produtos as $item)
                                                        <option value="{{ $item->id }}"
                                                            data-preco="{{ $item->preco_venda }}"
                                                            {{ old("produtos.$index.id") == $item->id ? 'selected' : '' }}>
                                                            {{ $item->nome }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <p class="invalid-feedback">{{ $errors->first("produtos.$index.id") }}</p>
                                            </div>

                                            <div class="col-md-1">
                                                <label class="form-label">Qtd <span class="text-danger">*</span></label>
                                                <input type="number" name="produtos[{{ $index }}][quantidade]"
                                                    class="form-control @error("produtos.$index.quantidade") is-invalid @enderror"
                                                    min="1" value="{{ old("produtos.$index.quantidade", 1) }}"
                                                    required>
                                                <p class="invalid-feedback">
                                                    {{ $errors->first("produtos.$index.quantidade") }}</p>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label">Valor Unitário</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">R$</span>
                                                    <input type="text"
                                                        name="produtos[{{ $index }}][valor_unitario]"
                                                        class="form-control @error("produtos.$index.valor_unitario") is-invalid @enderror"
                                                        value="{{ old("produtos.$index.valor_unitario") }}" required>
                                                </div>
                                                <p class="invalid-feedback">
                                                    {{ $errors->first("produtos.$index.valor_unitario") }}</p>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label">Valor Total</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">R$</span>
                                                    <input type="text"
                                                        name="produtos[{{ $index }}][valor_total]"
                                                        class="form-control"
                                                        value="{{ old("produtos.$index.valor_total") }}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-outline-danger w-100"
                                                    onclick="removerProduto(this)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    @foreach ($venda->itens as $index => $produto)
                                        <div class="produto row g-3 align-items-end mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Produto <span
                                                        class="text-danger">*</span></label>
                                                <select name="produtos[{{ $index }}][id]"
                                                    class="form-select produto-select @error("produtos.$index.id") is-invalid @enderror"
                                                    onchange="atualizarValor(this)" required>
                                                    <option disabled value="">Selecione um produto...</option>
                                                    @foreach ($produtos as $item)
                                                        <option value="{{ $item->id }}"
                                                            data-preco="{{ $item->preco_venda }}"
                                                            {{ $produto->id == $item->id ? 'selected' : '' }}>
                                                            {{ $item->nome }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-1">
                                                <label class="form-label">Qtd</label>
                                                <input type="number" name="produtos[{{ $index }}][quantidade]"
                                                    class="form-control @error("produtos[{{ $index }}][quantidade]") is-invalid @enderror"
                                                    value="{{ $produto->quantidade }}" min="1" required>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label">Valor Unitário</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">R$</span>
                                                    <input type="text"
                                                        name="produtos[{{ $index }}][valor_unitario]"
                                                        class="form-control  @error("produtos[{{ $index }}][valor_unitario]") is-invalid @enderror"
                                                        value="{{ $produto->preco_unitario }}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label">Valor Total</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">R$</span>
                                                    <input type="text"
                                                        name="produtos[{{ $index }}][valor_total]"
                                                        class="form-control" value="{{ $produto->valor_total }}"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-outline-danger w-100"
                                                    onclick="removerProduto(this)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif


                                <button type="button" class="btn btn-outline-primary mt-2" onclick="addProduto()">
                                    <i class="bi bi-plus-circle me-1"></i> Adicionar Produto
                                </button>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="parcelas" role="tabpanel" aria-labelledby="parcelas-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card border-0 shadow-sm mb-4">
                                        <div class="card-body">
                                            <h6 class="card-title text-muted mb-3"><i
                                                    class="bi bi-credit-card-2-front me-1"></i> Detalhes de Pagamento</h6>

                                            <div class="mb-3">
                                                <label for="forma_pagamento" class="form-label">Forma de Pagamento</label>
                                                <select name="forma_pagamento" id="forma_pagamento"
                                                    class="form-select @error('forma_pagamento') is-invalid @enderror">
                                                    <option disabled value="">Selecione a forma de pagamento...
                                                    </option>
                                                    <option value="Cartão de Crédito"
                                                        {{ old('forma_pagamento', $venda->forma_pagamento ?? '') == 'Cartão de Crédito' ? 'selected' : '' }}>
                                                        Cartão de Crédito</option>
                                                    <option value="Cartão de Débito"
                                                        {{ old('forma_pagamento', $venda->forma_pagamento ?? '') == 'Cartão de Débito' ? 'selected' : '' }}>
                                                        Cartão de Débito</option>
                                                    <option value="Pix"
                                                        {{ old('forma_pagamento', $venda->forma_pagamento ?? '') == 'Pix' ? 'selected' : '' }}>
                                                        Pix</option>
                                                    <option value="Dinheiro"
                                                        {{ old('forma_pagamento', $venda->forma_pagamento ?? '') == 'Dinheiro' ? 'selected' : '' }}>
                                                        Dinheiro
                                                    </option>
                                                    <option value="Outros"
                                                        {{ old('forma_pagamento', $venda->forma_pagamento ?? '') == 'Outros' ? 'selected' : '' }}>
                                                        Outros</option>
                                                </select>

                                                <p class="invalid-feedback d-block">
                                                    {{ $errors->first('forma_pagamento') }}</p>
                                            </div>

                                            <div class="mb-3">
                                                <label for="tipo_pagamento" class="form-label">Tipo de Pagamento<span
                                                        class="text-danger">*</span></label>
                                                <select name="tipo_pagamento" id="tipo_pagamento"
                                                    class="form-select @error('tipo_pagamento') is-invalid @enderror"
                                                    onchange="toggleParcelas()" required>
                                                    <option disabled value="">Selecione o tipo de pagamento...
                                                    </option>
                                                    <option value="avista"
                                                        {{ old('tipo_pagamento', $venda->tipo_pagamento ?? '') == 'avista' ? 'selected' : '' }}>
                                                        À Vista</option>
                                                    <option value="Parcelado"
                                                        {{ old('tipo_pagamento', $venda->tipo_pagamento ?? '') == 'Parcelado' ? 'selected' : '' }}>
                                                        Parcelado</option>
                                                </select>
                                                <p class="invalid-feedback d-block">{{ $errors->first('tipo_pagamento') }}
                                                </p>
                                            </div>

                                            <div id="parcelas-container" class="mt-3"
                                                style="{{ old('tipo_pagamento', $venda->tipo_pagamento ?? '') == 'Parcelado' ? '' : 'display: none;' }}">
                                                <label for="qtd_parcelas" class="form-label">Parcelas</label>
                                                <div class="input-group mb-3">
                                                    <input type="number" id="qtd_parcelas" name="qtd_parcelas"
                                                        class="form-control @error('qtd_parcelas') is-invalid @enderror"
                                                        min="1" max="12"
                                                        value="{{ old('qtd_parcelas', $venda->parcelas->count()) }}"
                                                        onchange="gerarParcelas()">
                                                    <span class="input-group-text">x</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div id="lista-parcelas" class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <h6 class="card-title text-muted mb-3">
                                                <i lass="bi bi-calendar-check me-1"></i> Parcelas
                                            </h6>
                                            @if (old('tipo_pagamento') == 'Parcelado' && old('parcelas'))
                                                @foreach (old('parcelas') as $i => $parcela)
                                                    <div class="border p-3 mb-3 rounded bg-light">
                                                        <div class="row align-items-center g-2">
                                                            <div class="col-md-1">
                                                                <label
                                                                    class="form-label mb-0"><strong>{{ $i + 1 }}</strong></label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label
                                                                    class="form-label small text-muted mb-0">Valor</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">R$</span>
                                                                    <input type="number" step="0.01"
                                                                        name="parcelas[{{ $i }}][valor]"
                                                                        class="form-control parcela-valor @error("parcelas.$i.valor") is-invalid @enderror"
                                                                        value="{{ $parcela['valor'] ?? '' }}"
                                                                        {{ $i == count(old('parcelas')) - 1 ? 'readonly' : '' }}>
                                                                    @error("parcelas.$i.valor")
                                                                        <p class="invalid-feedback d-block">
                                                                            {{ $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label small text-muted mb-0 ">Data de
                                                                    Vencimento</label>
                                                                <input type="date"
                                                                    name="parcelas[{{ $i }}][data]"
                                                                    class="form-control  @error("parcelas.$i.data") is-invalid @enderror"
                                                                    required value="{{ $parcela['data'] ?? '' }}">
                                                                @error("parcelas.$i.data")
                                                                    <p class="invalid-feedback d-block">
                                                                        {{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-5">
                                                                <label
                                                                    class="form-label small text-muted mb-0">Observação</label>
                                                                <input type="text"
                                                                    name="parcelas[{{ $i }}][observacao]"
                                                                    value="{{ $parcela['observacao'] ?? '' }}"
                                                                    placeholder="Opcional"
                                                                    class="form-control @error("parcelas.$i.observacao") is-invalid @enderror">
                                                                @error("parcelas.$i.observacao")
                                                                    <p class="invalid-feedback d-block">
                                                                        {{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @elseif($venda->parcelas)
                                                @foreach ($venda->parcelas as $index => $parcela)
                                                    <div class="border p-3 mb-3 rounded bg-light">
                                                        <div class="row align-items-center g-2">
                                                            <div class="col-md-1">
                                                                <label
                                                                    class="form-label mb-0"><strong>{{ $index + 1 }}</strong></label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label
                                                                    class="form-label small text-muted mb-0">Valor</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">R$</span>
                                                                    <input type="number" step="0.01"
                                                                        name="parcelas[{{ $index }}][valor]"
                                                                        class="form-control parcela-valor @error("parcelas.$index.valor") is-invalid @enderror"
                                                                        value="{{ $parcela->valor ?? '' }}"
                                                                        {{ $loop->last ? 'readonly' : '' }}>
                                                                    @error("parcelas.$index.valor")
                                                                        <p class="invalid-feedback d-block">
                                                                            {{ $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label small text-muted mb-0">Data de
                                                                    Vencimento</label>
                                                                <input type="date"
                                                                    name="parcelas[{{ $index }}][data]"
                                                                    class="form-control @error("parcelas.$index.data") is-invalid @enderror"
                                                                    required value="{{ $parcela->data ?? '' }}">
                                                                @error("parcelas.$index.data")
                                                                    <p class="invalid-feedback d-block">{{ $message }}
                                                                    </p>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-5">
                                                                <label
                                                                    class="form-label small text-muted mb-0">Observação</label>
                                                                <input type="text"
                                                                    name="parcelas[{{ $index }}][observacao]"
                                                                    value="{{ $parcela->observacao ?? '' }}"
                                                                    placeholder="Opcional"
                                                                    class="form-control @error("parcelas.$index.observacao") is-invalid @enderror">
                                                                @error("parcelas.$index.observacao")
                                                                    <p class="invalid-feedback d-block">{{ $message }}
                                                                    </p>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @elseif(old('tipo_pagamento') == 'A vista')
                                                <div class="alert alert-success py-2">
                                                    <small class="d-flex align-items-center">
                                                        <i class="bi bi-check-circle me-2"></i> O valor total será cobrado
                                                        em uma única parcela
                                                    </small>
                                                </div>
                                                <input type="hidden" name="parcelas[0][valor]"
                                                    value="{{ old('parcelas.0.valor', '0,00') }}">
                                            @else
                                                <div class="alert alert-info py-2">
                                                    <small class="d-flex align-items-center">
                                                        <i class="bi bi-info-circle me-2"></i> Adicione os produtos
                                                        corretamente e selecione o tipo de pagamento
                                                        para configurar as parcelas
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-4">
                        <div class="card bg-light border-success shadow-sm">
                            <div class="card-body py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 text-success">
                                        <i class="bi bi-currency-dollar me-2"></i>Total da Venda:
                                    </h5>
                                    <h3 class="mb-0 text-success fw-bold" id="total-geral">R$ 0,00</h3>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="valor_total" id="valor_total_input" value="0">

                        <div class="text-center mt-4">

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i> Salvar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        //SELECT2
        $(document).ready(function() {
            $('#cliente_id').select2({
                theme: 'bootstrap4',
                placeholder: 'Selecione ou digite para buscar...',
                allowClear: true,
                width: '100%'
            });



            $('.produto-select').select2({
                theme: 'bootstrap4',
                placeholder: 'Selecione ou digite para buscar...',
                allowClear: true,
                width: '100%'
            });

            setTimeout(() => {
                atualiTodosOsProdutos();
                atualizarTotalGeral();
            }, 500);
        });
        //------------------------------
        //parte dos produtos
        let produtoIndex = {{ count(old('produtos', $venda->itens)) }};

        function addProduto() {
            const container = document.querySelector('#produtos .mb-3'); // Seleciona o container principal
            const button = container.querySelector('button[onclick="addProduto()"]'); // Seleciona o botão

            const html = `
        <div class="produto row g-3 align-items-end mb-3">
            <div class="col-md-6">
                <label class="form-label">Produto <span class="text-danger">*</span></label>
                <select name="produtos[${produtoIndex}][id]" class="form-select produto-select" onchange="atualizarValor(this)" required>
                    <option selected disabled value="">Selecione um produto...</option>
                    @foreach ($produtos as $produto)
                        <option value="{{ $produto->id }}" data-preco="{{ $produto->preco_venda }}">
                            {{ $produto->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label">Qtd <span class="text-danger">*</span></label>
                <input type="number" name="produtos[${produtoIndex}][quantidade]" class="form-control" min="1" value="1" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Valor Unitário</label>
                <div class="input-group">
                    <span class="input-group-text">R$</span>
                    <input type="text" name="produtos[${produtoIndex}][valor_unitario]" class="form-control" required>
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label">Valor Total</label>
                <div class="input-group">
                    <span class="input-group-text">R$</span>
                    <input type="text" name="produtos[${produtoIndex}][valor_total]" class="form-control" readonly>
                </div>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-outline-danger w-100" onclick="removerProduto(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;

            // Insere o novo produto antes do botão
            button.insertAdjacentHTML('beforebegin', html);
            produtoIndex++;

            // Inicializa o Select2 para o novo select
            $('.produto-select').select2({
                theme: 'bootstrap4',
                placeholder: 'Selecione ou digite para buscar...',
                allowClear: true,
                width: '100%'
            });
        }

        function removerProduto(botao) {
            const produto = botao.closest('.produto');
            produto.remove();

            atualizarTotalGeral();
        }

        function atualizarTodosOsProdutos() {
            document.querySelectorAll('.produto-select').forEach(select => {
                atualizarValor(select);
            });
        }

        function atualizarValor(selectElement) {
            const produtoDiv = selectElement.closest('.produto');
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const preco = parseFloat(selectedOption.getAttribute('data-preco')) || 0;

            const quantidadeInput = produtoDiv.querySelector('input[name$="[quantidade]"]');
            const valorUnitarioInput = produtoDiv.querySelector('input[name$="[valor_unitario]"]');
            const valorTotalInput = produtoDiv.querySelector('input[name$="[valor_total]"]');


            if (valorUnitarioInput && !valorUnitarioInput.dataset.editado) {
                valorUnitarioInput.value = preco.toFixed(2);
            }

            if (quantidadeInput && valorUnitarioInput && valorTotalInput) {
                const quantidade = parseFloat(quantidadeInput.value) || 0;
                const valorUnitario = parseFloat(valorUnitarioInput.value) || 0;
                valorTotalInput.value = (quantidade * valorUnitario).toFixed(2);
            }
            atualizarTotalGeral();
        }


        document.addEventListener('input', function(e) {
            const nome = e.target.name;
            const produtoDiv = e.target.closest('.produto');

            if (nome.includes('[quantidade]') || nome.includes('[valor_unitario]')) {
                const quantidade = parseFloat(produtoDiv.querySelector('input[name$="[quantidade]"]').value) || 0;
                const valorUnitarioInput = produtoDiv.querySelector('input[name$="[valor_unitario]"]');
                const valorTotalInput = produtoDiv.querySelector('input[name$="[valor_total]"]');

                if (valorUnitarioInput && valorTotalInput) {
                    const valorUnitario = parseFloat(valorUnitarioInput.value) || 0;
                    valorTotalInput.value = (quantidade * valorUnitario).toFixed(2);

                    if (nome.includes('[valor_unitario]')) {
                        valorUnitarioInput.dataset.editado = true;
                    }

                }
            }
            atualizarTotalGeral();
        });


        function atualizarTotalGeral() {
            let total = 0;
            document.querySelectorAll('input[name$="[valor_total]"]').forEach(input => {
                total += parseFloat(input.value) || 0;
            });

            const totalFormatado = total.toFixed(2);
            document.getElementById('total-geral').innerText = 'R$ ' + totalFormatado.replace('.', ',');
            document.getElementById('valor_total_input').value = totalFormatado;

            if (document.getElementById('tipo_pagamento').value === 'Parcelado') {
                gerarParcelas();
            }
        }
        //-------------------------------------------------------
        // Parte das Parcelas

        function toggleParcelas() {
            const tipo = document.getElementById('tipo_pagamento').value;
            const container = document.getElementById('parcelas-container');
            const lista = document.getElementById('lista-parcelas');

            container.style.display = tipo === 'Parcelado' ? 'block' : 'none';

            if (tipo === 'A vista') {
                lista.innerHTML = `
            <div class="card-body">
                <h6 class="card-title text-muted mb-3"><i class="bi bi-calendar-check me-1"></i> Pagamento à Vista</h6>
                <div class="alert alert-success py-2">
                    <small class="d-flex align-items-center">
                        <i class="bi bi-check-circle me-2"></i> O valor total será cobrado em uma única parcela
                    </small>
                </div>
                <input type="hidden" name="parcelas[0][valor]" value="${document.getElementById('total-geral').innerText}">
            </div>
        `;
            } else if (tipo === 'Parcelado') {
                gerarParcelas();
            }
        }

        function gerarParcelas() {
            const lista = document.getElementById('lista-parcelas');
            if (!lista) return;

            const qtdInput = document.getElementById('qtd_parcelas');
            if (!qtdInput) return;

            const qtd = parseInt(qtdInput.value) || 1;
            const total = parseFloat(document.getElementById('valor_total_input').value) || 0;

            if (total <= 0) {
                lista.innerHTML = `
                <div class="card-body">
                    <div class="alert alert-warning py-2">
                        <small class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle me-2"></i> Adicione produtos para calcular as parcelas
                        </small>
                    </div>
                </div>
            `;
                return;
            }

            const valorParcela = parseFloat((total / qtd).toFixed(2));
            let valores = Array(qtd).fill(valorParcela);
            let soma = valores.reduce((acc, val) => acc + val, 0);

            // Ajustar a diferença na última parcela
            const diferenca = parseFloat((total - soma).toFixed(2));
            valores[qtd - 1] += diferenca;

            const hoje = new Date();

            let html =
                '<div class="card-body"><h6 class="card-title text-muted mb-3"><i class="bi bi-calendar-check me-1"></i> Parcelas</h6>';

            for (let i = 0; i < qtd; i++) {
                let data = new Date(hoje);
                data.setMonth(data.getMonth() + i);
                const dataFormatada = data.toISOString().split('T')[0];

                html += `
                <div class="border p-3 mb-3 rounded bg-light">
                    <div class="row align-items-center g-2">
                        <div class="col-md-1">
                            <label class="form-label mb-0"><strong>${i + 1}</strong></label>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted mb-0">Valor</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="number" step="0.01" name="parcelas[${i}][valor]" 
                                    class="form-control parcela-valor" 
                                    ${i === qtd - 1 ? 'readonly' : ''} 
                                    value="${valores[i].toFixed(2)}" 
                                    data-index="${i}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted mb-0">Data de Vencimento</label>
                            <input type="date" name="parcelas[${i}][data]" class="form-control" required value="${dataFormatada}">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small text-muted mb-0">Observação</label>
                            <input type="text" name="parcelas[${i}][observacao]" placeholder="Opcional" class="form-control">
                        </div>
                    </div>
                </div>
            `;
            }
            html += '</div>';
            lista.innerHTML = html;

            adicionarListenersParcelas();
        }

        function adicionarListenersParcelas() {
            document.querySelectorAll('.parcela-valor').forEach(input => {
                if (!input.hasAttribute('readonly')) {
                    input.addEventListener('input', atualizarUltimaParcela);
                }
            });
        }

        function atualizarUltimaParcela() {
            const inputs = document.querySelectorAll('.parcela-valor');
            if (inputs.length === 0) return;

            const total = parseFloat(document.getElementById('valor_total_input').value) || 0;
            const qtd = inputs.length;

            let soma = 0;
            for (let i = 0; i < qtd - 1; i++) {
                soma += parseFloat(inputs[i].value) || 0;
            }

            const ultima = inputs[qtd - 1];
            let valorFinal = total - soma;

            if (valorFinal < 0) valorFinal = 0;
            ultima.value = valorFinal.toFixed(2);
        }

        document.addEventListener('DOMContentLoaded', function() {
            atualizarTodosOsProdutos();
            atualizarTotalGeral();
            toggleParcelas();
        });
    </script>
@endsection
