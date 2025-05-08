<div class="modal fade" id="editProdutoModal{{ $produto->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editProdutoModalLabel{{ $produto->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('produto.update', $produto->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editProdutoModalLabel{{ $produto->id }}">Editar Produto</h5>
                    <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nome_produto_edit" class="form-label">Nome</label>
                        <input type="text" name="nome_produto_edit" id="nome_produto_edit" value="{{ old('nome_produto_edit', $produto->nome) }}" class="form-control @error('nome_produto_edit') is-invalid @enderror" required>
                        <p class="invalid-feedback d-block">{{ $errors->first('nome_produto_edit') }}</p>
                    </div>

                    <div class="mb-3">
                        <label for="preco_venda_edit" class="form-label">Preço de Venda</label>
                        <input type="number" name="preco_venda_edit" id="preco_venda_edit" step="0.01" min="0" value="{{ old('preco_venda_edit', $produto->preco_venda) }}" class="form-control @error('preco_venda_edit') is-invalid @enderror" required>
                        <p class="invalid-feedback d-block">{{ $errors->first('preco_venda_edit') }}</p>
                    </div>

                 
                    <div class="mb-3">
                        <label for="status_produto_edit" class="form-label">Status</label>
                        <select name="status_produto_edit" id="status_produto_edit" class="form-select @error('status_produto_edit') is-invalid @enderror">
                            <option value="1" {{ old('status_produto_edit', $produto->status) == '1' ? 'selected' : '' }}>Ativo</option>
                            <option value="0" {{ old('status_produto_edit', $produto->status) == '0' ? 'selected' : '' }}>Inativo</option>
                        </select>
                        <p class="invalid-feedback d-block">{{ $errors->first('status_produto_edit') }}</p>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>