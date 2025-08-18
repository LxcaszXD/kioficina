<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['mensagem']) && isset($_SESSION['tipo-msg'])) {
    $mensagem = $_SESSION['mensagem'];
    $tipo = $_SESSION['tipo-msg'];

    if ($tipo == 'sucesso') {
        echo '<div class="alert alert-danger" role="alert">' . $mensagem . '</div>';
    } elseif ($tipo == 'erro') {
        echo '<div class="alert alert-warning" role="alert">' . $mensagem . '</div>';
    }

    unset($_SESSION['mensagem']);
    unset($_SESSION['tipo-msg']);
}

?>



<a href="http://localhost/kioficina/public/clientes/adicionar" class="btn btn-secondary" style="margin-bottom: 10px;">
    Adicionar
</a>

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Foto</th>
            <th scope="col">Nome</th>
            <th scope="col">Tipo</th>
            <th scope="col">CPF/CNPJ</th>
            <th scope="col">Email</th>
            <th scope="col">Telefone</th>
            <th scope="col">Endereço</th>
            <th scope="col">Estado</th>
            <th scope="col">Status</th>
            <th scope="col">Editar</th>
            <th scope="col">Excluir</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($listaCliente as $linha): ?>
            <tr>
                <td>
                    <?php
                    // Caminho da foto
                    $caminhoBase = "http://localhost/kioficina/public/uploads/";
                    $caminhoFoto = $_SERVER['DOCUMENT_ROOT'] . "/kioficina/public/uploads/" . $linha['foto_cliente'];
                    $urlFoto = $linha['foto_cliente'] != "" && file_exists($caminhoFoto)
                        ? $caminhoBase . htmlspecialchars($linha['foto_cliente'], ENT_QUOTES, 'UTF-8')
                        : $caminhoBase . "sem-foto.png";
                    ?>
                    <img src="<?php echo $urlFoto; ?>" alt="Foto do Cliente" style="width: 100px; height: auto;">
                </td>
                <td><?php echo $linha['nome_cliente'] ?></td>
                <td><?php echo $linha['tipo_cliente'] ?></td>
                <td><?php echo $linha['cpf_cnpj_cliente'] ?></td>
                <td><?php echo $linha['email_cliente'] ?></td>
                <td><?php echo $linha['telefone_cliente'] ?></td>
                <td><?php echo $linha['endereco_cliente'] ?></td>
                <td><?php echo $linha['nome_uf'] ?></td>
                <td><?php echo $linha['status_cliente'] ?></td>
                <td>
                    <a href="http://localhost/kioficina/public/clientes/editar/<?php echo $linha['id_cliente'] ?>" title="Editar">
                        <img src="http://localhost/kioficina/public/uploads/pencil.png" alt="Editar" style="width: 20px; height: auto;">
                    </a>
                </td>
                <td>
                    <a href="#" title="Desativar" onclick="abrirModalDesativarCliente(<?php echo $linha['id_cliente']; ?>)">
                        <img src="http://localhost/kioficina/public/uploads/trash.png" alt="Desativar" style="width: 20px; height: auto;">
                    </a>
                </td>

            </tr>

        <?php endforeach; ?>

    </tbody>
</table>

<!-- Modal desativar cliente -->
<div class="modal" tabindex="-1" id="modalDesativarCliente">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desativar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja desativar este cliente?</p>
                <input type="hidden" id="idClienteDesativar">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarCliente">Desativar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function abrirModalDesativarCliente(idCliente) {
        document.getElementById('idClienteDesativar').value = idCliente;
        $('#modalDesativarCliente').modal('show');
    }

    document.getElementById('btnConfirmarCliente').addEventListener('click', function() {
        const idCliente = document.getElementById('idClienteDesativar').value;
        fetch(`http://localhost/kioficina/public/clientes/desativar/${idCliente}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.sucesso) {
                $('#modalDesativarCliente').modal('hide');
                setTimeout(() => location.reload(), 500);
            } else {
                alert(data.mensagem || "Erro ao desativar cliente");
            }
        })
        .catch(() => alert('Erro na requisição.'));
    });
</script>
