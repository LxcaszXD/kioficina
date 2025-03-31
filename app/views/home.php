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

        <div class="sidebar mx-auto">
            <figure><img src="../../img/logo-kioficina.png" alt=""></figure>

            <div class="welcome-text">BEM VINDO À <br> KI-OFICINA</div>
            <div class="user-name">OLÁ, JOÃO SILVA</div>
              <a href="../views/agendamento.php" class="btn btn-custom">AGENDAMENTO</a>
                <a href="../views/listarServico.php" class="btn btn-custom">LISTAR SERVIÇO</a>
                <a href="../views/depoimentos.php" class="btn btn-custom">DEPOIMENTOS</a>
                <a href="../views/perfil.php" class="btn btn-custom">PERFIL</a>
                <a href="../../index.php" class="btn btn-custom btn-exit">SAIR</a>
        </div>
        
    </div>
 </main>


    <script src="script/script.js"></script>
</body>
</html>