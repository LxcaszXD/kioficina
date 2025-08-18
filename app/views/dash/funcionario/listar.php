<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['mensagem']) && isset($_SESSION['tipo-msg'])) {
    $mensagem = $_SESSION['mensagem'];
    $tipo = $_SESSION['tipo-msg'];

    // Exibir mensagem
    if ($tipo == 'sucesso') {
        echo '<div class="alert alert-success" role="alert">' . $mensagem . '</div>';
    } elseif ($tipo == 'erro') {
        echo '<div class="alert alert-danger" role="alert">' . $mensagem . '</div>';
    }

    // Limpar variáveis de sessão
    unset($_SESSION['mensagem']);
    unset($_SESSION['tipo-msg']);
}
?>

<a href="http://localhost/kioficina/public/funcionarios/adicionar/" class="btn btn-primary btn-lg btn-block btn-dash">Cadastrar Funcionário</a>

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Foto</th>
            <th scope="col">Nome</th>
            <th scope="col">Cargo</th>
            <th scope="col">Especialidade</th>
            <th scope="col">E-mail</th>
            <th scope="col">Telefone</th>
            <th scope="col">Editar</th>
            <th scope="col">Desativar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listaFuncionario as $linha): ?>

            <tr>
                <td>
                    <?php
                    // Caminho da foto
                    $caminhoBase = "http://localhost/kioficina/public/uploads/";
                    $caminhoFoto = $_SERVER['DOCUMENT_ROOT'] . "/kioficina/public/uploads/" . $linha['foto_funcionario'];
                    $urlFoto = $linha['foto_funcionario'] != "" && file_exists($caminhoFoto)
                        ? $caminhoBase . htmlspecialchars($linha['foto_funcionario'], ENT_QUOTES, 'UTF-8')
                        : $caminhoBase . "sem-foto.png";
                    ?>
                    <img src="<?php echo $urlFoto; ?>" alt="<?php echo htmlspecialchars($linha['alt_foto_funcionario'], ENT_QUOTES, 'UTF-8'); ?>" style="width: 100px; height: auto;">
                </td>
                <td><?php echo $linha['nome_funcionario']; ?></td>
                <td><?php echo htmlspecialchars($linha['cargo_funcionario'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($linha['nome_especialidade'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($linha['email_funcionario'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($linha['telefone_funcionario'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <a href="http://localhost/kioficina/public/funcionarios/editar/<?php echo $linha['id_funcionario'] ?>" title="Editar">
                        <img src="http://localhost/kioficina/public/uploads/pencil.png" alt="Editar" style="width: 20px; height: auto;">
                    </a>
                </td>
                <td>
                    <a href="#" title="Desativar" onclick="abrirModalDesativarFuncionario(<?php echo $linha['id_funcionario']; ?>)">
                        <img src="http://localhost/kioficina/public/uploads/trash.png" alt="Desativar" style="width: 20px; height: auto;">
                    </a>
                </td>

            </tr>

        <?php endforeach; ?>

    </tbody>
</table>

<!-- Modal desativar funcionário -->
<div class="modal" tabindex="-1" id="modalDesativarFuncionario">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desativar Funcionário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja desativar este funcionário?</p>
                <input type="hidden" id="idFuncionarioDesativar">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarFuncionario">Desativar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function abrirModalDesativarFuncionario(idFuncionario) {
        document.getElementById('idFuncionarioDesativar').value = idFuncionario;
        $('#modalDesativarFuncionario').modal('show');
    }

    document.getElementById('btnConfirmarFuncionario').addEventListener('click', function() {
        const idFuncionario = document.getElementById('idFuncionarioDesativar').value;
        fetch(`http://localhost/kioficina/public/funcionarios/desativar/${idFuncionario}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.sucesso) {
                $('#modalDesativarFuncionario').modal('hide');
                setTimeout(() => location.reload(), 500);
            } else {
                alert(data.mensagem || "Erro ao desativar funcionário");
            }
        })
        .catch(() => alert('Erro na requisição.'));
    });
</script>
