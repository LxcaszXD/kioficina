<?php require_once('../../config/config.php');
$titulo = 'Agendamento - Ki-Oficina'
?>

<!DOCTYPE html>
<html lang="pt-br">

<?php 
require_once('template/head.php');
?>

<body>
    <main>
        <div class="container">
            
            <h2 class="text-warning">FAÇA SEU <br> AGENDAMENTO</h2>
            <div class="box-form">
                <label><strong>VEÍCULO:</strong></label>
                <input type="text" class="form-control" placeholder="Selecione seu veículo">

                <label><strong>DATA:</strong></label>
                <input type="date" class="form-control">

                <label><strong>HORA:</strong></label>
                <input type="time" class="form-control">

                <label><strong>FUNCIONÁRIO:</strong></label>
                <input type="text" class="form-control" placeholder="Selecione o funcionário">

                <a href="listaAgendamentos.html"><button class="btn btn-custom">AGENDAR</button></a>
            </div>
            <a href="../views/home.php" class="btn btn-back">VOLTAR</a>
            <a href="../views/listaAgendamentos.php" class="btn btn-green">LISTAR AGENDA</a>


        </div>
    </main>


    <script src="script/script.js"></script>
</body>

</html>