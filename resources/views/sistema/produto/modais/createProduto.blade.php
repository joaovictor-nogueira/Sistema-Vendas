<div class="modal fade" id="createProdutoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createProdutoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('produto.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createProdutoModalLabel">Novo Produto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nome_produto" class="form-label">Nome</label>
                        <input type="text" name="nome_produto" id="nome_produto" value="{{old('nome_produto')}}" class="form-control @error('nome_produto') is-invalid @enderror" required>
                        <p class="invalid-feedback d-block">{{ $errors->first('nome_produto') }}</p>
                    </div>

                    <div class="mb-3">
                        <label for="preco_venda" class="form-label">Preço de Venda</label>
                        <input type="number" name="preco_venda" id="preco_venda" step="0.01" min="0" value="{{ old('preco_venda') }}" class="form-control @error('preco_venda') is-invalid @enderror" required>
                        <p class="invalid-feedback d-block">{{ $errors->first('preco_venda') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status_produto" class="form-label">Status</label>
                        <select name="status_produto" id="status_produto" class="form-select @error('status_produto') is-invalid @enderror">
                            <option value="1" {{ old('status_produto') == '1' ? 'selected' : '' }}>Ativo</option>
                            <option value="0" {{ old('status_produto') == '0' ? 'selected' : '' }}>Inativo</option>
                        </select>
                        <p class="invalid-feedback d-block">{{ $errors->first('status_produto') }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>