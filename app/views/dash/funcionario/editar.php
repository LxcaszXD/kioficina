<form method="POST" action="http://localhost/kioficina/public/funcionarios/editar/<?php echo $funcionario['id_funcionario']; ?>" enctype="multipart/form-data">
    <div class="container my-5">
        <div class="row">
            <div class="col-md-3">
                <img id="preview-img"
                    src="<?php echo isset($funcionario['foto_funcionario']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/kioficina/public/uploads/' . $funcionario['foto_funcionario']) ? 'http://localhost/kioficina/public/uploads/' . $funcionario['foto_funcionario'] : 'http://localhost/kioficina/public/uploads/sem-foto.png'; ?>"
                    alt="Foto do Funcionário"
                    style="width:100%; cursor:pointer;"
                    title="Clique na imagem para selecionar uma foto">
                <input type="file" name="foto_funcionario" id="foto_funcionario" style="display: none;" accept="image/*">
            </div>

            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <label for="nome_funcionario" class="form-label">Nome do Funcionário:</label>
                        <input type="text" class="form-control" id="nome_funcionario" name="nome_funcionario" value="<?php echo htmlspecialchars($funcionario['nome_funcionario']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tipo_funcionario" class="form-label">Tipo de Funcionário:</label>
                        <select class="form-select" id="tipo_funcionario" name="tipo_funcionario" required>
                            <option value="Fisica" <?php echo $funcionario['tipo_funcionario'] == 'Fisica' ? 'selected' : ''; ?>>Física</option>
                            <option value="Juridica" <?php echo $funcionario['tipo_funcionario'] == 'Juridica' ? 'selected' : ''; ?>>Jurídica</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="cpf_cnpj_funcionario" class="form-label">CPF/CNPJ:</label>
                        <input type="text" class="form-control" id="cpf_cnpj_funcionario" name="cpf_cnpj_funcionario" value="<?php echo htmlspecialchars($funcionario['cpf_cnpj_funcionario']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="data_adm_funcionario" class="form-label">Data de Admissão:</label>
                        <input type="date" class="form-control" id="data_adm_funcionario" name="data_adm_funcionario" value="<?php echo htmlspecialchars($funcionario['data_adm_funcionario']); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="email_funcionario" class="form-label">E-mail:</label>
                        <input type="email" class="form-control" id="email_funcionario" name="email_funcionario" value="<?php echo htmlspecialchars($funcionario['email_funcionario']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="senha_funcionario" class="form-label">Senha:</label>
                        <input type="password" class="form-control" id="senha_funcionario" name="senha_funcionario" value="<?php echo htmlspecialchars($funcionario['senha_funcionario']); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="telefone_funcionario" class="form-label">Telefone:</label>
                        <input type="text" class="form-control" id="telefone_funcionario" name="telefone_funcionario" value="<?php echo htmlspecialchars($funcionario['telefone_funcionario']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="endereco_funcionario" class="form-label">Endereço:</label>
                        <input type="text" class="form-control" id="endereco_funcionario" name="endereco_funcionario" value="<?php echo htmlspecialchars($funcionario['endereco_funcionario']); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="bairro_funcionario" class="form-label">Bairro:</label>
                        <input type="text" class="form-control" id="bairro_funcionario" name="bairro_funcionario" value="<?php echo htmlspecialchars($funcionario['bairro_funcionario']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="cidade_funcionario" class="form-label">Cidade:</label>
                        <input type="text" class="form-control" id="cidade_funcionario" name="cidade_funcionario" value="<?php echo htmlspecialchars($funcionario['cidade_funcionario']); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="id_uf" class="form-label">Estado:</label>
                        <select class="form-select" id="id_uf" name="id_uf" required>
                            <option value="0">Selecione</option>
                            <?php foreach ($estados as $linha): ?>
                                <option value="<?php echo $linha['id_uf']; ?>" <?php echo $funcionario['id_uf'] == $linha['id_uf'] ? 'selected' : ''; ?>><?php echo $linha['nome_uf']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="id_especialidade" class="form-label">Especialidade:</label>
                        <select class="form-select" id="id_especialidade" name="id_especialidade" required>
                            <option selected>Selecione</option>
                            <?php foreach ($especialidades as $especialidade): ?>
                                <option value="<?php echo $especialidade['id_especialidade']; ?>"><?php echo $especialidade['nome_especialidade']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="cargo_funcionario" class="form-label">Cargo:</label>
                        <input type="text" class="form-control" id="cargo_funcionario" name="cargo_funcionario" value="<?php echo htmlspecialchars($funcionario['cargo_funcionario']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="salario_funcionario" class="form-label">Salário:</label>
                        <input type="text" class="form-control" id="salario_funcionario" name="salario_funcionario" value="<?php echo htmlspecialchars($funcionario['salario_funcionario']); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="facebook_funcionario" class="form-label">Facebook:</label>
                        <input type="text" class="form-control" id="facebook_funcionario" name="facebook_funcionario" value="<?php echo htmlspecialchars($funcionario['facebook_funcionario']); ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="instagram_funcionario" class="form-label">Instagram:</label>
                        <input type="text" class="form-control" id="instagram_funcionario" name="instagram_funcionario" value="<?php echo htmlspecialchars($funcionario['instagram_funcionario']); ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="linkedin_funcionario" class="form-label">LinkedIn:</label>
                        <input type="text" class="form-control" id="linkedin_funcionario" name="linkedin_funcionario" value="<?php echo htmlspecialchars($funcionario['linkedin_funcionario']); ?>">
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="status_funcionario" class="form-label">Status do Serviço:</label>
                        <select class="form-select" id="status_funcionario" name="status_funcionario">
                            <option value="<?php echo htmlspecialchars($funcionario['status_funcionario']); ?>" selected><?php echo htmlspecialchars($funcionario['status_funcionario']); ?></option>
                            <option>Ativo</option>
                            <option>Inativo</option>
                        </select>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a href="http://localhost/kioficina/public/funcionarios" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const visualizarImg = document.getElementById('preview-img');
        const arquivo = document.getElementById('foto_funcionario');

        visualizarImg.addEventListener('click', function() {
            arquivo.click();
        });

        arquivo.addEventListener('change', function() {
            if (arquivo.files && arquivo.files[0]) {
                let render = new FileReader();
                render.onload = function(e) {
                    visualizarImg.src = e.target.result;
                }
                render.readAsDataURL(arquivo.files[0]);
            }
        });
    });
</script>
