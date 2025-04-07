<?php
 
class MenuController extends Controller{
    public function index()
    {
 
        if(!isset($_SESSION['id_cliente'])){
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }
 
        $clienteId = $_SESSION['id_cliente'];
 
        if(!$clienteId){
            session_destroy();
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }
 
        //Buscar Cliente na API
        $url = BASE_API . "cliente/$clienteId";
        //Recebendo os dados dessa solicitação
        $response = file_get_contents($url);
        //Separa os dados em 'campos'
        $cliente = json_decode($response, true);
 
 
        $dados = array();
        $dados['titulo'] = 'KiOficina - Menu';
        $dados['nome_cliente'] = $cliente['nome_cliente'] ?? 'Cliente';
 
        $this->carregarViews('menu', $dados);
    }
 
}