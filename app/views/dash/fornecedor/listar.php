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

<a href="http://localhost/kioficina/public/fornecedores/adicionar/" class="btn btn-primary btn-lg btn-block btn-dash">Cadastrar Fornecedor</a>

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Nome</th>
            <th scope="col">Tipo</th>
            <th scope="col">CPF/CNPJ</th>
            <th scope="col">E-mail</th>
            <th scope="col">Telefone</th>
            <th scope="col">Cidade</th>
            <th scope="col">Editar</th>
            <th scope="col">Desativar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listaFornecedor as $linha): ?>

            <tr>
                <td><?php echo htmlspecialchars($linha['nome_fornecedor'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($linha['tipo_fornecedor'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($linha['cpf_cnpj_fornecedor'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($linha['email_fornecedor'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($linha['telefone_fornecedor'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($linha['cidade_fornecedor'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <a class="btn btn-primary" href="http://localhost/kioficina/public/fornecedores/editar/<?php echo $linha['id_fornecedor']; ?>" title="Editar">
                        <img src="http://localhost/kioficina/public/uploads/pencil.png" alt="Editar" style="width: 20px; height: auto;">
                    </a>
                </td>
                <td>
                    <a href="#" class="btn btn-danger" title="Desativar" onclick="abrirModalDesativarFornecedor(<?php echo $linha['id_fornecedor']; ?>)">
                        <img src="http://localhost/kioficina/public/uploads/trash.png" alt="Desativar" style="width: 20px; height: auto;">
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal desativar fornecedor -->
<div class="modal" tabindex="-1" id="modalDesativarFornecedor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desativar Fornecedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja desativar esse fornecedor?</p>
                <input type="hidden" id="idFornecedorDesativar" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarFornecedor">Desativar</button>
            </div>
        </div>
    </div>
</div>

<!-- Start Fornecedor -->
<script>
    function abrirModalDesativarFornecedor(idFornecedor) {
        if ($('#modalDesativarFornecedor').hasClass('show')) {
            return;
        }

        document.getElementById('idFornecedorDesativar').value = idFornecedor;

        $('#modalDesativarFornecedor').modal('show');
    }

    // Substituir o evento para o botão específico para este modal
    document.getElementById('btnConfirmarFornecedor').addEventListener('click', function() {
        const idFornecedor = document.getElementById('idFornecedorDesativar').value;

        if (idFornecedor) {
            desativarFornecedor(idFornecedor);
        }
    });

    function desativarFornecedor(idFornecedor) {
        fetch(`http://localhost/kioficina/public/fornecedores/desativar/${idFornecedor}`, {
               
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erro HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.sucesso) {
                    console.log("Fornecedor desativado com sucesso");
                    $('#modalDesativarFornecedor').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    alert(data.mensagem || "Ocorreu um erro ao desativar o fornecedor");
                }
            })
            .catch(erro => {
                console.error('Erro', erro);
                alert('Erro na requisição.');
            });
    }
</script>
<!-- End Fornecedor -->
