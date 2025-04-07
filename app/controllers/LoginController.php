<?php
 
class LoginController extends Controller{
    public function index()
    {
 
        $dados = array();
        $dados['titulo'] = 'KiOficina - Login';
        $this->carregarViews('login', $dados);
    }
 
    //Método de autenticação
    public function autenticar()
    {
        $email = $_POST['email'] ?? null;
        $senha = $_POST['senha'] ?? null;
 
        //Fazer a requisição da API de login
        $url = BASE_API . "login?email_cliente=$email&senha_cliente=$senha";
        //Recebe os dados dessa solicitação
        $response = file_get_contents($url);
        //Separa os dados em 'campos'
        $data = json_decode($response, true);
 
        if(isset($data['token'])){
            $idToken = json_decode(base64_decode($data['token']), true);
            $id_cliente = $idToken['id'] ?? null;
 
            $_SESSION['token'] = $data['token'];
            $_SESSION['id_cliente'] = $id_cliente;
            header("Location: " . BASE_URL . "index.php?url=menu");
            exit;
        }else{
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }
 
    }
 
}