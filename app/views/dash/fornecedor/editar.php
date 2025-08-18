<form method="POST" action="http://localhost/kioficina/public/fornecedores/editar/<?php echo $fornecedor['id_fornecedor']; ?>" enctype="multipart/form-data">
    <div class="container my-5">
        <div class="row">

            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <label for="nome_fornecedor" class="form-label">Nome do Fornecedor:</label>
                        <input type="text" class="form-control" id="nome_fornecedor" name="nome_fornecedor" value="<?php echo htmlspecialchars($fornecedor['nome_fornecedor']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tipo_fornecedor" class="form-label">Tipo de Fornecedor:</label>
                        <select class="form-select" id="tipo_fornecedor" name="tipo_fornecedor" required>
                            <option value="Fisica" <?php echo $fornecedor['tipo_fornecedor'] == 'Fisica' ? 'selected' : ''; ?>>Física</option>
                            <option value="Juridica" <?php echo $fornecedor['tipo_fornecedor'] == 'Juridica' ? 'selected' : ''; ?>>Jurídica</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="cpf_cnpj_fornecedor" class="form-label">CPF/CNPJ:</label>
                        <input type="text" class="form-control" id="cpf_cnpj_fornecedor" name="cpf_cnpj_fornecedor" value="<?php echo htmlspecialchars($fornecedor['cpf_cnpj_fornecedor']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="data_cad_fornecedor" class="form-label">Data de Cadastro:</label>
                        <input type="date" class="form-control" id="data_cad_fornecedor" name="data_cad_fornecedor" value="<?php echo htmlspecialchars($fornecedor['data_cad_fornecedor']); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="email_fornecedor" class="form-label">E-mail:</label>
                        <input type="email" class="form-control" id="email_fornecedor" name="email_fornecedor" value="<?php echo htmlspecialchars($fornecedor['email_fornecedor']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="site_fornecedor" class="form-label">Site:</label>
                        <input type="text" class="form-control" id="site_fornecedor" name="site_fornecedor" value="<?php echo htmlspecialchars($fornecedor['site_fornecedor']); ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="telefone_fornecedor" class="form-label">Telefone:</label>
                        <input type="text" class="form-control" id="telefone_fornecedor" name="telefone_fornecedor" value="<?php echo htmlspecialchars($fornecedor['telefone_fornecedor']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="endereco_fornecedor" class="form-label">Endereço:</label>
                        <input type="text" class="form-control" id="endereco_fornecedor" name="endereco_fornecedor" value="<?php echo htmlspecialchars($fornecedor['endereco_fornecedor']); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="bairro_fornecedor" class="form-label">Bairro:</label>
                        <input type="text" class="form-control" id="bairro_fornecedor" name="bairro_fornecedor" value="<?php echo htmlspecialchars($fornecedor['bairro_fornecedor']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="cidade_fornecedor" class="form-label">Cidade:</label>
                        <input type="text" class="form-control" id="cidade_fornecedor" name="cidade_fornecedor" value="<?php echo htmlspecialchars($fornecedor['cidade_fornecedor']); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="id_uf" class="form-label">Estado:</label>
                        <select class="form-select" id="id_uf" name="id_uf" required>
                            <option value="0">Selecione</option>
                            <?php foreach ($estados as $linha): ?>
                                <option value="<?php echo $linha['id_uf']; ?>" <?php echo $fornecedor['id_uf'] == $linha['id_uf'] ? 'selected' : ''; ?>><?php echo $linha['nome_uf']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="status_fornecedor" class="form-label">Status:</label>
                        <select class="form-select" id="status_fornecedor" name="status_fornecedor">
                            <option value="<?php echo htmlspecialchars($fornecedor['status_fornecedor']); ?>" selected><?php echo htmlspecialchars($fornecedor['status_fornecedor']); ?></option>
                            <option>Ativo</option>
                            <option>Inativo</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a href="http://localhost/kioficina/public/fornecedores" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</form>
