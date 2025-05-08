<div class="modal fade" id="createClienteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('cliente.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createClienteModalLabel">Novo Cliente</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nome_cliente" class="form-label">Nome</label>
                        <input type="text" name="nome_cliente" id="nome_cliente" value="{{old('nome_cliente')}}" class="form-control @error('nome_cliente') is-invalid @enderror" required>
                        <p class="invalid-feedback d-block">{{ $errors->first('nome_cliente') }}</p>
                    </div>

                    <div class="mb-3">
                        <label for="email_cliente" class="form-label">E-mail</label>
                        <input type="email_cliente" name="email_cliente" id="email_cliente" value="{{old('email_cliente')}}"  class="form-control @error('email_cliente') is-invalid @enderror">
                        <p class="invalid-feedback d-block">{{ $errors->first('email_cliente') }}</p>
                    </div>

                    <div class="mb-3">
                        <label for="telefone_cliente" class="form-label">Telefone</label>
                        <input type="text" name="telefone_cliente" id="telefone_cliente" value="{{old('telefone_cliente')}}"  class="form-control @error('telefone_cliente') is-invalid @enderror">
                        <p class="invalid-feedback d-block">{{ $errors->first('telefone_cliente') }}</p>
                    </div>

                    <div class="mb-3">
                        <label for="cpf_cliente" class="form-label">CPF</label>
                        <input type="text" name="cpf_cliente" id="cpf_cliente" value="{{old('cpf_cliente')}}"  class="form-control @error('cpf_cliente') is-invalid @enderror" maxlength="14" placeholder="000.000.000-00">
                        <p class="invalid-feedback d-block">{{ $errors->first('cpf_cliente') }}</p>
                    </div>

                    <div class="mb-3">
                        <label for="status_cliente" class="form-label">Status</label>
                        <select name="status_cliente" id="status_cliente" class="form-select @error('status_cliente') is-invalid @enderror">
                            <option value="1" {{ old('status_cliente') == '1' ? 'selected' : '' }}>Ativo</option>
                            <option value="0" {{ old('status_cliente') == '0' ? 'selected' : '' }}>Inativo</option>
                        </select>
                        <p class="invalid-feedback d-block">{{ $errors->first('status_cliente') }}</p>
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