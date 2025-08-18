<?php

class FornecedoresController extends Controller
{
    private $fornecedorModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instanciar o modelo Fornecedor
        $this->fornecedorModel = new Fornecedor();
    }

    // 1- Método para listar todos os fornecedores
    public function listar()
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            header('Location:' . BASE_URL);
            exit;
        }

        $dados = array();
        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);

        $dados['listaFornecedor'] = $this->fornecedorModel->getListarFornecedor();
        $dados['conteudo'] = 'dash/fornecedor/listar';
        $dados['func'] = $dadosFunc;
        $this->carregarViews('dash/dashboard', $dados);
    }

    // 2- Método para adicionar fornecedores
    public function adicionar()
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            header('Location:' . BASE_URL);
            exit;
        }

        $dados = array();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Captura e sanitiza os dados
            $nome_fornecedor      = filter_input(INPUT_POST, 'nome_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);
            $tipo_fornecedor      = filter_input(INPUT_POST, 'tipo_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);
            $cpf_cnpj_fornecedor  = filter_input(INPUT_POST, 'cpf_cnpj_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);
            $data_cad_fornecedor  = filter_input(INPUT_POST, 'data_cad_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);
            $email_fornecedor     = filter_input(INPUT_POST, 'email_fornecedor', FILTER_SANITIZE_EMAIL);
            $site_fornecedor      = filter_input(INPUT_POST, 'site_fornecedor', FILTER_SANITIZE_URL);
            $telefone_fornecedor  = filter_input(INPUT_POST, 'telefone_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);
            $endereco_fornecedor  = filter_input(INPUT_POST, 'endereco_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);
            $bairro_fornecedor    = filter_input(INPUT_POST, 'bairro_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);
            $cidade_fornecedor    = filter_input(INPUT_POST, 'cidade_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);
            $id_uf               = filter_input(INPUT_POST, 'id_uf', FILTER_SANITIZE_NUMBER_INT);
            $status_fornecedor   = filter_input(INPUT_POST, 'status_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($nome_fornecedor && $email_fornecedor && !empty($telefone_fornecedor)) {
                $dadosFornecedor = array(
                    'nome_fornecedor'      => $nome_fornecedor,
                    'tipo_fornecedor'      => $tipo_fornecedor,
                    'cpf_cnpj_fornecedor'  => $cpf_cnpj_fornecedor,
                    'data_cad_fornecedor'  => $data_cad_fornecedor,
                    'email_fornecedor'     => $email_fornecedor,
                    'site_fornecedor'      => $site_fornecedor,
                    'telefone_fornecedor'  => $telefone_fornecedor,
                    'endereco_fornecedor'  => $endereco_fornecedor,
                    'bairro_fornecedor'    => $bairro_fornecedor,
                    'cidade_fornecedor'    => $cidade_fornecedor,
                    'id_uf'               => $id_uf,
                    'status_fornecedor'   => $status_fornecedor,
                );

                $id_fornecedor = $this->fornecedorModel->addFornecedor($dadosFornecedor);

                if ($id_fornecedor) {
                    $_SESSION['mensagem'] = "Fornecedor adicionado com sucesso!";
                    $_SESSION['tipo-msg'] = "Sucesso";
                    header('location: ' . BASE_URL . 'fornecedores/listar');
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao adicionar o fornecedor";
                    $dados['tipo-msg'] = "Erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios!";
                $dados['tipo-msg'] = "Erro";
            }
        }

        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);

        $estado = new Estado();
        $dados['estados'] = $estado->getTodosEstados();

        $dados['conteudo'] = 'dash/fornecedor/adicionar';
        $dados['func'] = $dadosFunc;

        $this->carregarViews('dash/dashboard', $dados);
    }

    // 3 - Método para adicionar fornecedor
    public function editar($id = null)
    {
        $dados = array();

        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            header('Location: http://localhost/kioficina/public/fornecedores/listar');
            exit;
        }

        if ($id === null) {
            header('Location: http://localhost/kioficina/public/fornecedores/listar');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Captura e sanitiza os dados
            $nome_fornecedor      = filter_input(INPUT_POST, 'nome_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);
            $tipo_fornecedor      = filter_input(INPUT_POST, 'tipo_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);
            $cpf_cnpj_fornecedor  = filter_input(INPUT_POST, 'cpf_cnpj_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);
            $data_cad_fornecedor  = filter_input(INPUT_POST, 'data_cad_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);
            $email_fornecedor     = filter_input(INPUT_POST, 'email_fornecedor', FILTER_SANITIZE_EMAIL);
            $site_fornecedor      = filter_input(INPUT_POST, 'site_fornecedor', FILTER_SANITIZE_URL);
            $telefone_fornecedor  = filter_input(INPUT_POST, 'telefone_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);
            $endereco_fornecedor  = filter_input(INPUT_POST, 'endereco_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);
            $bairro_fornecedor    = filter_input(INPUT_POST, 'bairro_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);
            $cidade_fornecedor    = filter_input(INPUT_POST, 'cidade_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);
            $id_uf                = filter_input(INPUT_POST, 'id_uf', FILTER_SANITIZE_NUMBER_INT);
            $status_fornecedor    = filter_input(INPUT_POST, 'status_fornecedor', FILTER_SANITIZE_SPECIAL_CHARS);

            // Verifica se os campos obrigatórios estão preenchidos
            if ($nome_fornecedor && $email_fornecedor && !empty($telefone_fornecedor)) {
                $dadosFornecedor = array(
                    'nome_fornecedor'     => $nome_fornecedor,
                    'tipo_fornecedor'     => $tipo_fornecedor,
                    'cpf_cnpj_fornecedor' => $cpf_cnpj_fornecedor,
                    'data_cad_fornecedor' => $data_cad_fornecedor,
                    'email_fornecedor'    => $email_fornecedor,
                    'site_fornecedor'     => $site_fornecedor,
                    'telefone_fornecedor' => $telefone_fornecedor,
                    'endereco_fornecedor' => $endereco_fornecedor,
                    'bairro_fornecedor'   => $bairro_fornecedor,
                    'cidade_fornecedor'   => $cidade_fornecedor,
                    'id_uf'               => $id_uf,
                    'status_fornecedor'   => $status_fornecedor,
                );

                // Atualiza os dados no banco
                $atualizado = $this->fornecedorModel->atualizarFornecedor($id, $dadosFornecedor);

                if ($atualizado) {
                    $_SESSION['mensagem'] = "Fornecedor atualizado com sucesso!";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('location: http://localhost/kioficina/public/fornecedores/listar');
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao atualizar o fornecedor";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios!";
                $dados['tipo-msg'] = "erro";
            }
        }

        // Buscar fornecedor existente
        $fornecedor = $this->fornecedorModel->getFornecedorById($id);
        $dados['fornecedor'] = $fornecedor;

        // Buscar Estados
        $estado = new Estado();
        $dados['estados'] = $estado->getTodosEstados();

        // Buscar Funcionarios 
        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);

        $dados['conteudo'] = 'dash/fornecedor/editar';
        $dados['func'] = $dadosFunc;

        $this->carregarViews('dash/dashboard', $dados);
    }

    // 4- Método para desativar o fornecedor
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

        $resultado = $this->fornecedorModel->desativarFornecedor($id);
        header('Content-Type: application/json');
        if ($resultado) {
            $_SESSION['mensagem'] = "Fornecedor Desativado com SUCESSO!";
            $_SESSION['tipo-msg'] = 'sucesso';

            echo json_encode(['sucesso' => true]);
        } else {
            $_SESSION['mensagem'] = "Falha ao Desativar o Fornecedor!";
            $_SESSION['tipo-msg'] = 'erro';

            echo json_encode(['sucesso' => false, 'mensagem' => "Falha ao Desativar o Fornecedor"]);
        }
    }
}
