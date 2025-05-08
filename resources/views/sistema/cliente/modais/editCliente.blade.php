<div class="modal fade" id="editClienteModal{{ $cliente->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editClienteModalLabel{{ $cliente->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('cliente.update', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editClienteModalLabel{{ $cliente->id }}">Editar Cliente</h5>
                    <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nome_cliente_edit" class="form-label">Nome</label>
                        <input type="text" name="nome_cliente_edit" id="nome_cliente_edit" value="{{ old('nome_cliente_edit', $cliente->nome) }}" class="form-control @error('nome_cliente_edit') is-invalid @enderror" required>
                        <p class="invalid-feedback d-block">{{ $errors->first('nome_cliente_edit') }}</p>
                    </div>

                    <div class="mb-3">
                        <label for="email_cliente_edit" class="form-label">E-mail</label>
                        <input type="email" name="email_cliente_edit" id="email_cliente_edit" value="{{ old('email_cliente_edit', $cliente->email) }}" class="form-control @error('email_cliente_edit') is-invalid @enderror">
                        <p class="invalid-feedback d-block">{{ $errors->first('email_cliente_edit') }}</p>
                    </div>

                    <div class="mb-3">
                        <label for="telefone_cliente_edit" class="form-label">Telefone</label>
                        <input type="text" name="telefone_cliente_edit" id="telefone_cliente_edit" value="{{ old('telefone_cliente_edit', $cliente->telefone) }}" class="form-control @error('telefone_cliente_edit') is-invalid @enderror">
                        <p class="invalid-feedback d-block">{{ $errors->first('telefone_cliente_edit') }}</p>
                    </div>

                    <div class="mb-3">
                        <label for="cpf_cliente_edit" class="form-label">CPF</label>
                        <input type="text" name="cpf_cliente_edit" id="cpf_cliente_edit" value="{{ old('cpf_cliente_edit', $cliente->cpf) }}" class="form-control @error('cpf_cliente_edit') is-invalid @enderror" maxlength="14" placeholder="000.000.000-00">
                        <p class="invalid-feedback d-block">{{ $errors->first('cpf_cliente_edit') }}</p>
                    </div>

                    <div class="mb-3">
                        <label for="status_cliente_edit" class="form-label">Status</label>
                        <select name="status_cliente_edit" id="status_cliente_edit" class="form-select @error('status_cliente_edit') is-invalid @enderror">
                            <option value="1" {{ old('status_cliente_edit', $cliente->status) == '1' ? 'selected' : '' }}>Ativo</option>
                            <option value="0" {{ old('status_cliente_edit', $cliente->status) == '0' ? 'selected' : '' }}>Inativo</option>
                        </select>
                        <p class="invalid-feedback d-block">{{ $errors->first('status_cliente_edit') }}</p>
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