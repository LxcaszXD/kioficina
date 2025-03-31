<?php require_once('../../config/config.php');
$titulo = 'Home - Ki-Oficina'
?>

<!DOCTYPE html>
<html lang="pt-br">

<?php 
require_once('template/head.php');
?>

<body>
    <main>
        <div class="container">

            <div class="agendamentos-container">
                <h3>Lista de agendamentos</h3>

                <div class="card-agendamento">
                    <p><span>Veiculo:</span>Honda Motor -Honda Civic</p>
                    <p><span>Funcionário:</span>Fernanda Oliveira</p>
                    <p><span>Data Agenda:</span>20/02/2024</p>
                    <p style="color: green;" class="status"> Status: Concluído</p>
                </div>
                <div class="card-agendamento">
                    <p><span>Veiculo:</span>Honda Motor -Honda Civic</p>
                    <p><span>Funcionário:</span>Sabrina sato</p>
                    <p><span>Data Agenda:</span>20/02/2024</p>
                    <p style="color: red;" class="status"> Status: Cancelado</p>
                </div>
                <div class="card-agendamento">
                    <p><span>Veiculo:</span>Honda Motor -Honda Civic</p>
                    <p><span>Funcionário:</span> Pedro Lima</p>
                    <p><span>Data Agenda:</span>20/02/2024</p>
                    <p style="color: #0099ff;" class="status"> Status: Em analise</p>
                </div>



            </div>
            <a href="../../app/views/agendamento.php" class="btn btn-back">VOLTAR</a>
        </div>
    </main>


    <script src="script/script.js"></script>
</body>

</html>