<!DOCTYPE html>
<html lang="pt-br">

<?php 
require_once('template/head.php');
?>

<body id="login">

    <main>
        <div class="container">
            <figure><img src="assets/img/logo-kioficina.png" alt=""></figure>
            <h3>LOGIN</h3>
            <div class="login-box">
                <form action="<?php echo BASE_URL; ?>index.php?url=menu" method="POST">
                    <div class="mb-3 text-start">
                        <label for="email" class="form-label">E-MAIL</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3 text-start">
                        <label for="password" class="form-label">SENHA</label>
                        <input type="password" class="form-control" id="password" required>
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