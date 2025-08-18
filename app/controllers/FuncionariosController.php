<?php

class FuncionariosController extends Controller
{

    private $funcionarioModel;

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instaciar o modelo Funcionario
        $this->funcionarioModel = new Funcionario();
    }

    // ###############################################
    // BACK-END - DASHBOARD
    #################################################//

    // 1- Método para listar todos os funcionarios
    public function listar()
    {

        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {

            header('Location:' . BASE_URL);
            exit;
        }

        $dados = array();
        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);

        $dados['listaFuncionario'] = $this->funcionarioModel->getListarFuncionarios();
        $dados['conteudo'] = 'dash/funcionario/listar';
        $dados['func'] = $dadosFunc;
        $this->carregarViews('dash/dashboard', $dados);
    }

    // 2- Método para adicionar funcionarios
    public function adicionar()
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            header('Location:http://localhost/kioficina/public/');
            exit;
        }

        $dados = array();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // TBL FUNCIONARIO
            $nome_funcionario                 = filter_input(INPUT_POST, 'nome_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $tipo_funcionario                 = filter_input(INPUT_POST, 'tipo_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $cpf_cnpj_funcionario             = filter_input(INPUT_POST, 'cpf_cnpj_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $data_adm_funcionario             = filter_input(INPUT_POST, 'data_adm_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $email_funcionario                = filter_input(INPUT_POST, 'email_funcionario', FILTER_SANITIZE_EMAIL);
            $senha_funcionario                = filter_input(INPUT_POST, 'senha_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $alt_foto_funcionario             = filter_input(INPUT_POST, 'alt_foto_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $telefone_funcionario             = filter_input(INPUT_POST, 'telefone_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $endereco_funcionario             = filter_input(INPUT_POST, 'endereco_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $bairro_funcionario               = filter_input(INPUT_POST, 'bairro_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $cidade_funcionario               = filter_input(INPUT_POST, 'cidade_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $id_uf                            = filter_input(INPUT_POST, 'id_uf', FILTER_SANITIZE_NUMBER_INT);
            $id_especialidade                 = filter_input(INPUT_POST, 'id_especialidade', FILTER_SANITIZE_NUMBER_INT);
            $cargo_funcionario                = filter_input(INPUT_POST, 'cargo_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $salario_funcionario              = filter_input(INPUT_POST, 'salario_funcionario', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $facebook_funcionario             = filter_input(INPUT_POST, 'facebook_funcionario', FILTER_SANITIZE_URL);
            $instagram_funcionario            = filter_input(INPUT_POST, 'instagram_funcionario', FILTER_SANITIZE_URL);
            $linkedin_funcionario             = filter_input(INPUT_POST, 'linkedin_funcionario', FILTER_SANITIZE_URL);
            $status_funcionario               = filter_input(INPUT_POST, 'status_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);

            // Se foi enviada a foto
            $foto_funcionario = $this->uploadFoto($_FILES['foto_funcionario']);

            // Verificar se os campos obrigatórios foram preenchidos
            if ($nome_funcionario && $cpf_cnpj_funcionario && $email_funcionario && $senha_funcionario) {

                // Preparar Dados para o Funcionário
                $dadosFuncionario = array(
                    'nome_funcionario'      => $nome_funcionario,
                    'tipo_funcionario'      => $tipo_funcionario,
                    'cpf_cnpj_funcionario'  => $cpf_cnpj_funcionario,
                    'data_adm_funcionario'  => $data_adm_funcionario,
                    'email_funcionario'     => $email_funcionario,
                    'senha_funcionario'     => password_hash($senha_funcionario, PASSWORD_DEFAULT),
                    'foto_funcionario'      => $foto_funcionario,
                    'alt_foto_funcionario'  => $alt_foto_funcionario,
                    'telefone_funcionario'  => $telefone_funcionario,
                    'endereco_funcionario'  => $endereco_funcionario,
                    'bairro_funcionario'    => $bairro_funcionario,
                    'cidade_funcionario'    => $cidade_funcionario,
                    'id_uf'                 => $id_uf,
                    'id_especialidade'      => $id_especialidade,
                    'cargo_funcionario'     => $cargo_funcionario,
                    'salario_funcionario'   => $salario_funcionario,
                    'facebook_funcionario'  => $facebook_funcionario,
                    'instagram_funcionario' => $instagram_funcionario,
                    'linkedin_funcionario'  => $linkedin_funcionario,
                    'status_funcionario'    => $status_funcionario,
                );

                // Chamar o modelo para adicionar o funcionário
                $id_funcionario = $this->funcionarioModel->addFuncionario($dadosFuncionario);

                if ($id_funcionario) {
                    // Mensagem de sucesso
                    $_SESSION['mensagem'] = "Funcionário Adicionado com Sucesso!";
                    $_SESSION['tipo-msg'] = "Sucesso";
                    header('Location: http://localhost/kioficina/public/funcionarios/listar');
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao adicionar o Funcionário";
                    $dados['tipo-msg'] = "Erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios";
                $dados['tipo-msg'] = "Erro";
            }
        }

        // Buscar dados do funcionário logado
        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);

        // Buscar especialidades
        $especialidades = new Especialidades();
        $dados['especialidades'] = $especialidades->getTodasEspecialidades();

        // Buscar estados
        $estado = new Estado();
        $dados['estados'] = $estado->getTodosEstados();

        $dados['conteudo'] = 'dash/funcionario/adicionar';
        $dados['func'] = $dadosFunc;

        $this->carregarViews('dash/dashboard', $dados);
    }

    // 3- Método para editar
    public function editar($id = null)
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            header('Location:' . BASE_URL);
            exit;
        }

        if ($id === null) {
            header('Location: http://localhost/kioficina/public/funcionarios/listar');
            exit;
        }

        $dados = array();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Captura e sanitiza os dados
            $nome_funcionario      = filter_input(INPUT_POST, 'nome_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $tipo_funcionario      = filter_input(INPUT_POST, 'tipo_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $cpf_cnpj_funcionario  = filter_input(INPUT_POST, 'cpf_cnpj_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $data_adm_funcionario  = filter_input(INPUT_POST, 'data_adm_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $email_funcionario     = filter_input(INPUT_POST, 'email_funcionario', FILTER_SANITIZE_EMAIL);
            $senha_funcionario     = filter_input(INPUT_POST, 'senha_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $telefone_funcionario  = filter_input(INPUT_POST, 'telefone_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $endereco_funcionario  = filter_input(INPUT_POST, 'endereco_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $bairro_funcionario    = filter_input(INPUT_POST, 'bairro_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $cidade_funcionario    = filter_input(INPUT_POST, 'cidade_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $id_uf                 = filter_input(INPUT_POST, 'id_uf', FILTER_SANITIZE_NUMBER_INT);
            $id_especialidade      = filter_input(INPUT_POST, 'id_especialidade', FILTER_SANITIZE_NUMBER_INT);
            $status_funcionario    = filter_input(INPUT_POST, 'status_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);

            // Verifica e faz upload da foto
            if (isset($_FILES['foto_funcionario']) && $_FILES['foto_funcionario']['error'] == 0) {
                $foto_funcionario = $this->uploadFoto($_FILES['foto_funcionario']);
                $alt_foto_funcionario = pathinfo($_FILES['foto_funcionario']['name'], PATHINFO_FILENAME);
            } else {
                $foto_funcionario = null;
                $alt_foto_funcionario = null;
            }

            // Verifica se os campos obrigatórios estão preenchidos
            if ($nome_funcionario && $email_funcionario && !empty($telefone_funcionario)) {
                $dadosFuncionario = array(
                    'nome_funcionario'     => $nome_funcionario,
                    'tipo_funcionario'     => $tipo_funcionario,
                    'cpf_cnpj_funcionario' => $cpf_cnpj_funcionario,
                    'data_adm_funcionario' => $data_adm_funcionario,
                    'email_funcionario'    => $email_funcionario,
                    'senha_funcionario'    => $senha_funcionario,
                    'telefone_funcionario' => $telefone_funcionario,
                    'endereco_funcionario' => $endereco_funcionario,
                    'bairro_funcionario'   => $bairro_funcionario,
                    'cidade_funcionario'   => $cidade_funcionario,
                    'id_uf'                => $id_uf,
                    'id_especialidade'     => $id_especialidade,
                    'status_funcionario'   => $status_funcionario,
                );

                // Atualiza a foto apenas se uma nova foi enviada
                if ($foto_funcionario) {
                    $dadosFuncionario['foto_funcionario'] = $foto_funcionario;
                    $dadosFuncionario['alt_foto_funcionario'] = $alt_foto_funcionario;
                }

                // Atualiza os dados no banco
                $atualizado = $this->funcionarioModel->atualizarFuncionario($id, $dadosFuncionario);

                if ($atualizado) {
                    $_SESSION['mensagem'] = "Funcionário atualizado com sucesso!";
                    $_SESSION['tipo-msg'] = "Sucesso";
                    header('location: http://localhost/kioficina/public/funcionarios/listar');
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao atualizar o funcionário";
                    $dados['tipo-msg'] = "Erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios!";
                $dados['tipo-msg'] = "Erro";
            }
        }

        // Buscar funcionário existente
        $funcionario = $this->funcionarioModel->getFuncionarioById($id);
        $dados['funcionario'] = $funcionario;

        // Buscar Funcionário
        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);

        // Buscar Estados
        $estado = new Estado();
        $dados['estados'] = $estado->getTodosEstados();

        $dados['conteudo'] = 'dash/funcionario/editar';
        $dados['func'] = $dadosFunc;

        $this->carregarViews('dash/dashboard', $dados);
    }

    // Método para desativar o funcionário via API
    public function desativar($id = null)
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            http_response_code(400);
            echo json_encode(["Sucesso" => false, "Mensagem" => "Acesso Negado."]);
            exit;
        }

        if ($id === null) {
            http_response_code(400);
            echo json_encode(["Sucesso" => false, "Mensagem" => "ID Inválido."]);
            exit;
        }

        $resultado = $this->funcionarioModel->desativarFuncionario($id);
        header('Content-Type: application/json');
        if ($resultado) {
            $_SESSION['mensagem'] = "Funcionário Desativado com SUCESSO!";
            $_SESSION['tipo-msg'] = 'sucesso';

            echo json_encode(['sucesso' => true]);
        } else {
            $_SESSION['mensagem'] = "Falha ao Desativar o Funcionário!";
            $_SESSION['tipo-msg'] = 'erro';

            echo json_encode(['sucesso' => false, 'mensagem' => "Falha ao Desativar o Funcionário"]);
        }
    }

    // 5 metodo upload das fotos
    private function uploadFoto($file)
    {

        $dir = '../public/uploads/funcionario/';

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
            return 'funcionario/' . $nome_arquivo; // Caminho relativo
        }

        // Retorna falso caso o upload falhe
        return false;
    }
} //FIM DA CLASSE