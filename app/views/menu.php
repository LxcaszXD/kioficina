<!DOCTYPE html>
<html lang="pt-br">

<?php 
require_once('template/head.php');
?>

<body>
<main>
    <div class="container">
        <div class="sidebar mx-auto">
        <figure><img src="../../assets/img/logo-kioficina.png" alt=""></figure>
            <div class="welcome-text">BEM VINDO À <br> KI-OFICINA</div>
            <div class="user-name">Bem-vindo <?php echo $nome_cliente?> !</div>
                <a href="<?php echo BASE_URL; ?>index.php?url=agendamento" class="btn btn-custom">AGENDAMENTO</a>
                <a href="<?php echo BASE_URL; ?>index.php?url=listarServico" class="btn btn-custom">LISTAR SERVIÇO</a>
                <a href="<?php echo BASE_URL; ?>index.php?url=depoimentos" class="btn btn-custom">DEPOIMENTOS</a>
                <a href="<?php echo BASE_URL; ?>index.php?url=perfil" class="btn btn-custom">PERFIL</a>
                <a href="<?php echo BASE_URL; ?>index.php?url=login" class="btn btn-custom btn-exit">SAIR</a>
        </div>
        
    </div>
</main>


    <script src="script/script.js"></script>
</body>
</html>