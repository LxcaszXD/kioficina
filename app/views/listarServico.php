<!DOCTYPE html>
<html lang="pt-br">


<?php
require_once('template/head.php');
?>

<body>
    <main>
        <div class="container">

            <div class="servicos-container">

                <h3>Lista de Serviços</h3>

                <div class="card-servico">
                    <P><span>Data de Entrada:</span>29/08/2024</P>
                    <P><span>Previsão de Saída:</span>29/08/2024</P>
                    <P><span>Marca:</span>Honda Motor</P>
                    <P><span>Modelo:</span>Honda civic</P>
                    <P><span>Chassi:</span>DDFF6622365dd</P>
                    <P><span>Observação:</span>Pintura completa</P>
                    <P><span>Total:</span>R$1.800,90</P>
                    <p class="status" style="color: red;">Status:Cancelado</p>
                </div>
                <a href="<?php echo BASE_URL; ?>index.php?url=menu" class="btn btn-back">VOLTAR</a>
            </div>


        </div>
    </main>


    <script src="script/script.js"></script>
</body>

</html>