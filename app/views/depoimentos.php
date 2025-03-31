<?php require_once('../../config/config.php');
$titulo = 'Depoimento - Ki-Oficina'
?>

<!DOCTYPE html>
<html lang="pt-br">

<?php 
require_once('template/head.php');
?>

<body>
 <main>
    <div class="container">

        <h2>DEIXE SEU DEPOIMENTO</h2>
        <div class="depoimento-container">

            <h6>SEU DEPOIMENTO</h6>
            <textarea name="" id=""></textarea>
            <h6>NOTA:</h6>
            <div class="stars" id="star-rating">
                <span class="star" data-value="1">★</span>
                <span class="star" data-value="2">★</span>
                <span class="star" data-value="3">★</span>
                <span class="star" data-value="4">★</span>
                <span class="star" data-value="5">★</span>
            </div>
            <input type="hidden" id="rating-value" name="rating" value="0">
            
            <a href="" class="btn">ENVIAR DEPOIMENTO</a>
        </div>
        <a href="../views/home.php" class="btn btn-back">VOLTAR</a>
    </div>
 </main>


    <script src="script/script.js"></script>
</body>
</html>