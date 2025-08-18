<?php

class ClientesController extends Controller
{

    private $clienteModel;

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instaciar o modelo Servico
        $this->clienteModel = new Cliente();
    }

    // ###############################################
    // BACK-END - DASHBOARD
    #################################################//

    // 1- Método para listar todos os clientes
    public function listar()
    {

        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {

            header('Location:' . BASE_URL);
            exit;
        }

        $dados = array();
        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);

        $dados['listaCliente'] = $this->clienteModel->getListarCliente();
        $dados['conteudo'] = 'dash/cliente/listar';
        $dados['func'] = $dadosFunc;
        $this->carregarViews('dash/dashboard', $dados);
    }

    // 2- Método para adicionar clientes
    public function adicionar()
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            header('Location:' . BASE_URL);
            exit;
        }

        $dados = array();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Captura e sanitiza os dados
            $nome_cliente         = filter_input(INPUT_POST, 'nome_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $tipo_cliente         = filter_input(INPUT_POST, 'tipo_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $cpf_cnpj_cliente     = filter_input(INPUT_POST, 'cpf_cnpj_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $data_nasc_cliente    = filter_input(INPUT_POST, 'data_nasc_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $email_cliente        = filter_input(INPUT_POST, 'email_cliente', FILTER_SANITIZE_EMAIL);
            $senha_cliente        = filter_input(INPUT_POST, 'senha_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $telefone_cliente     = filter_input(INPUT_POST, 'telefone_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $endereco_cliente     = filter_input(INPUT_POST, 'endereco_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $bairro_cliente       = filter_input(INPUT_POST, 'bairro_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $cidade_cliente       = filter_input(INPUT_POST, 'cidade_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $id_uf                = filter_input(INPUT_POST, 'id_uf', FILTER_SANITIZE_NUMBER_INT);
            $status_cliente       = filter_input(INPUT_POST, 'status_cliente', FILTER_SANITIZE_SPECIAL_CHARS);

            // Verifica e faz upload da foto
            if (isset($_FILES['foto_cliente']) && $_FILES['foto_cliente']['error'] == 0) {
                $foto_cliente = $this->uploadFoto($_FILES['foto_cliente']);
                $alt_foto_cliente = pathinfo($_FILES['foto_cliente']['name'], PATHINFO_FILENAME); // Nome do arquivo sem extensão
            } else {
            }

            // Verifica se os campos obrigatórios estão preenchidos
            if ($nome_cliente && $email_cliente && !empty($telefone_cliente)) {
                $dadosCliente = array(
                    'nome_cliente'       => $nome_cliente,
                    'tipo_cliente'       => $tipo_cliente,
                    'cpf_cnpj_cliente'   => $cpf_cnpj_cliente,
                    'data_nasc_cliente'  => $data_nasc_cliente,
                    'email_cliente'      => $email_cliente,
                    'senha_cliente'      => password_hash($senha_cliente, PASSWORD_BCRYPT),
                    'foto_cliente'       => $foto_cliente,
                    'alt_foto_cliente'   => $alt_foto_cliente,
                    'telefone_cliente'   => $telefone_cliente,
                    'endereco_cliente'   => $endereco_cliente,
                    'bairro_cliente'     => $bairro_cliente,
                    'cidade_cliente'     => $cidade_cliente,
                    'id_uf'              => $id_uf,
                    'status_cliente'     => $status_cliente,
                );

                // Insere o cliente no banco
                $id_cliente = $this->clienteModel->addCliente($dadosCliente);

                if ($id_cliente) {
                    $_SESSION['mensagem'] = "Cliente adicionado com sucesso!";
                    $_SESSION['tipo-msg'] = "Sucesso";
                    header('location: http://localhost/kioficina/public/clientes/listar');
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao adicionar o cliente";
                    $dados['tipo-msg'] = "Erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios!";
                $dados['tipo-msg'] = "Erro";
            }
        }

        // Buscar Funcionário
        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);

        // Buscar Estados
        $estado = new Estado();
        $dados['estados'] = $estado->getTodosEstados();

        $dados['conteudo'] = 'dash/cliente/adicionar';
        $dados['func'] = $dadosFunc;

        $this->carregarViews('dash/dashboard', $dados);
    }

    // Método Editar
    public function editar($id = null)
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            header('Location:' . BASE_URL);
            exit;
        }

        if ($id === null) {
            header('Location: http://localhost/kioficina/public/clientes/listar');
            exit;
        }

        $dados = array();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Captura e sanitiza os dados
            $nome_cliente         = filter_input(INPUT_POST, 'nome_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $tipo_cliente         = filter_input(INPUT_POST, 'tipo_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $cpf_cnpj_cliente     = filter_input(INPUT_POST, 'cpf_cnpj_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $data_nasc_cliente    = filter_input(INPUT_POST, 'data_nasc_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $email_cliente        = filter_input(INPUT_POST, 'email_cliente', FILTER_SANITIZE_EMAIL);
            $senha_cliente        = filter_input(INPUT_POST, 'senha_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $telefone_cliente     = filter_input(INPUT_POST, 'telefone_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $endereco_cliente     = filter_input(INPUT_POST, 'endereco_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $bairro_cliente       = filter_input(INPUT_POST, 'bairro_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $cidade_cliente       = filter_input(INPUT_POST, 'cidade_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $id_uf                = filter_input(INPUT_POST, 'id_uf', FILTER_SANITIZE_NUMBER_INT);
            $status_cliente       = filter_input(INPUT_POST, 'status_cliente', FILTER_SANITIZE_SPECIAL_CHARS);

            // Verifica e faz upload da foto
            if (isset($_FILES['foto_cliente']) && $_FILES['foto_cliente']['error'] == 0) {
                $foto_cliente = $this->uploadFoto($_FILES['foto_cliente']);
                $alt_foto_cliente = pathinfo($_FILES['foto_cliente']['name'], PATHINFO_FILENAME);
            } else {
                $foto_cliente = null;
                $alt_foto_cliente = null;
            }

            // Verifica se os campos obrigatórios estão preenchidos
            if ($nome_cliente && $email_cliente && !empty($telefone_cliente)) {
                $dadosCliente = array(
                    'nome_cliente'       => $nome_cliente,
                    'tipo_cliente'       => $tipo_cliente,
                    'cpf_cnpj_cliente'   => $cpf_cnpj_cliente,
                    'data_nasc_cliente'  => $data_nasc_cliente,
                    'email_cliente'      => $email_cliente,
                    'senha_cliente'      => password_hash($senha_cliente, PASSWORD_BCRYPT),
                    'telefone_cliente'   => $telefone_cliente,
                    'endereco_cliente'   => $endereco_cliente,
                    'bairro_cliente'     => $bairro_cliente,
                    'cidade_cliente'     => $cidade_cliente,
                    'id_uf'              => $id_uf,
                    'status_cliente'     => $status_cliente,
                );

                // Atualiza a foto apenas se uma nova foi enviada
                if ($foto_cliente) {
                    $dadosCliente['foto_cliente'] = $foto_cliente;
                    $dadosCliente['alt_foto_cliente'] = $alt_foto_cliente;
                }

                // Atualiza os dados no banco
                $atualizado = $this->clienteModel->atualizarCliente($id, $dadosCliente);

                if ($atualizado) {
                    $_SESSION['mensagem'] = "Cliente atualizado com sucesso!";
                    $_SESSION['tipo-msg'] = "Sucesso";
                    header('location: http://localhost/kioficina/public/clientes/listar');
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao atualizar o cliente";
                    $dados['tipo-msg'] = "Erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios!";
                $dados['tipo-msg'] = "Erro";
            }
        }

        // Buscar cliente existente
        $cliente = $this->clienteModel->getClienteById($id);
        $dados['cliente'] = $cliente;

        // Buscar Funcionário
        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);

        // Buscar Estados
        $estado = new Estado();
        $dados['estados'] = $estado->getTodosEstados();

        $dados['conteudo'] = 'dash/cliente/editar';
        $dados['func'] = $dadosFunc;

        $this->carregarViews('dash/dashboard', $dados);
    }

    // 3 - metodo upload das fotos
    private function uploadFoto($file)
    {

        $dir = '../public/uploads/cliente/';

        // Verifica se o diretório existe, caso contrário cria o diretório
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        // Obter a extensão do arquivo
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

        // Gera um nome único para o arquivo
        $nome_arquivo = uniqid() . '.' . $ext;

        // Caminho completo para salvar o arquivo
        $caminho_arquivo = $dir . $nome_arquivo;

        // Move o arquivo para o diretório
        if (move_uploaded_file($file['tmp_name'], $caminho_arquivo)) {
            return 'cliente/' . $nome_arquivo; // Caminho relativo
        }

        // Retorna falso caso o upload falhe
        return false;
    }


    // Método para desativar o cliente via API
    public function desativar($id = null)
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            http_response_code(400);
            echo json_encode(["Sucesso" => false, "Mensagem" => "Acesso Negado."]);
            exit;
        }

        if ($id === null) {
            http_response_code(400);
            echo json_encode(["Sucesso" => false, "Mensagem" => "ID Invalido."]);
            exit;
        }

        $resultado = $this->clienteModel->desativarCliente($id);
        header('Content-Type: application/json');
        if ($resultado) {
            $_SESSION['mensagem'] = "Cliente Desativado com SUCESSO!";
            $_SESSION['tipo-msg'] = 'sucesso';

            echo json_encode(['sucesso' => true]);
        } else {
            $_SESSION['mensagem'] = "Falha ao Desativar o Cliente!";
            $_SESSION['tipo-msg'] = 'erro';

            echo json_encode(['sucesso' => false, 'mensagem' => "Falha ao Desativar o Cliente"]);
        }
    }
} //FIM DA CLASSE
