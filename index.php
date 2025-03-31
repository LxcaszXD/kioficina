<?php require_once('config/config.php');
$titulo = 'Login - Ki-Oficina'
?>

<!DOCTYPE html>
<html lang="pt-br">

<?php 
require_once('app/views/template/head.php');
?>

<body>



    <main>


        <div class="container">

            <figure><img src="img/logo-kioficina.png" alt=""></figure>

            <h3>LOGIN</h3>
            <div class="login-box">
              
                <form action="app/views/home.php">
                    <div class="mb-3 text-start">
                        <label for="email" class="form-label">E-MAIL</label>
                        <input type="email" class="form-control" id="email" >
                    </div>
                    <div class="mb-3 text-start">
                        <label for="password" class="form-label">SENHA</label>
                        <input type="password" class="form-control" id="password" >
                        <a href="#" class="forgot-password">Esqueci a senha</a>
                    </div>
                    <button type="submit" class="btn btn-custom w-100">ENTRAR</button>
                </form>
            </div>

        </div>
    </main>

    <script src="script/script.js" defer></script>
</body>

</html>