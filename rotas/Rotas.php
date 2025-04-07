<?php
class Rotas {
    public function executar() {
        $url = '/';
 
        if (isset($_GET['url'])) {
            $url .= $_GET['url'];
        }
 
        $parametro = array();
 
        // Verifica se a URL não está vazia e não é a raiz
        if (!empty($url) && $url != '/') {
            $url = explode('/', $url);
            array_shift($url); // Remove a barra
 
            $controladorAtual = ucfirst($url[0]) . 'Controller'; // Primeiro caractere em maiúscula
            array_shift($url);
 
            if (isset($url[0]) && !empty($url[0])) {
                $acaoAtual = $url[0];
                array_shift($url);
            } else {
                $acaoAtual = 'index';
            }
 
            // Se ainda tiver elementos na URL, serão considerados parâmetros
            if (count($url) > 0) {
                $parametro = $url;
            }
        } else {
            $controladorAtual = 'LoginController';
            $acaoAtual = 'index';
        }
 
        // Verifica se o arquivo do controlador existe
        if (!file_exists('../app/controllers/' . $controladorAtual . '.php')) {
            echo 'Erro: controlador ' . $controladorAtual . ' não encontrado!';
            $controladorAtual = 'ErroController';
            $acaoAtual = 'index';
        } else {
            require_once '../app/controllers/' . $controladorAtual . '.php';
 
            // Verifica se a classe existe e se o método é válido
            if (!class_exists($controladorAtual)) {
                echo 'Erro: classe ' . $controladorAtual . ' não encontrada!';
                exit;
            }
 
            $controller = new $controladorAtual;
 
            if (!method_exists($controller, $acaoAtual)) {
                echo 'Erro: método ' . $acaoAtual . ' não encontrado no controlador ' . $controladorAtual;
                exit;
            }
 
            // Chama a ação no controlador e passa os parâmetros
            call_user_func_array(array($controller, $acaoAtual), $parametro);
        }
    }
}
?>