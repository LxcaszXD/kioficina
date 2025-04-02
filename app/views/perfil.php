<!DOCTYPE html>
<html lang="pt-br">

<?php
require_once('template/head.php');
?>

<body>
<main>
    <div class="container">

        <h2 class="text-warning">MEU PERFIL</h2>
        <img src="img/member_4.jpg" alt="Foto de perfil" class="profile-pic">
        <div class="profile-box">
            <label><strong>NOME:</strong></label>
            <input type="text" class="form-control" value="João Silva">
            
            <label><strong>EMAIL:</strong></label>
            <input type="email" class="form-control" value="joao.silva@email.com">
            
            <label><strong>TELEFONE:</strong></label>
            <input type="text" class="form-control" value="11987654321">
            
            <label><strong>ENDEREÇO:</strong></label>
            <input type="text" class="form-control" value="Rua das Flores, 123">
            
            <label><strong>BAIRRO:</strong></label>
            <input type="text" class="form-control" value="Mogi">
            
            <label><strong>CIDADE:</strong></label>
            <input type="text" class="form-control" value="São Paulo">
            
            <label><strong>ESTADO:</strong></label>
            <select class="form-control">
                <option selected>SP</option>
                <option>RJ</option>
                <option>MG</option>
                <option>RS</option>
            </select>
            
            <label><strong>ALTERAR SENHA (OPCIONAL):</strong></label>
            <input type="password" class="form-control" placeholder="Nova senha">
            
            <button class="btn btn-custom">SALVAR ALTERAÇÕES</button>
        </div>
        <a href="<?php echo BASE_URL; ?>index.php?url=menu" class="btn btn-custom">VOLTAR</a>
        
    </div>
</main>


    <script src="script/script.js"></script>
</body>
</html>