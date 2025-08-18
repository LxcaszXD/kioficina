<?php

class ServicosController extends Controller
{

    private $servicoModel;

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instaciar o modelo Servico
        $this->servicoModel = new Servico();
    }

    // FRONT-END: Carregar a lista de serviços
    public function index()
    {

        $dados = array();
        $dados['titulo'] = 'Serviços - Ki Oficina';

        // Obter todos os servicos
        $todosServico = $this->servicoModel->getTodosServicos();

        // Passa os serviços para a página
        $dados['servicos'] = $todosServico;
        $this->carregarViews('servicos', $dados);
    }

    // FRONT-END: Carregar o detalhe do serviços
    public function detalhe($link)
    {
        //var_dump("Link: ".$link);

        $dados = array();

        $detalheServico = $this->servicoModel->getServicoPorLink($link);

        //var_dump($detalheServico);

        if ($detalheServico) {

            $dados['titulo'] = $detalheServico['nome_servico'];
            $dados['detalhe'] = $detalheServico;
            $this->carregarViews('detalhe-servicos', $dados);
        } else {
            $dados['titulo'] = 'Serviços Ki Oficina';
            $this->carregarViews('servicos', $dados);
        }
    }




    // ###############################################
    // BACK-END - DASHBOARD
    #################################################//

    // 1- Método para listar todos os serviços
    public function listar()
    {

        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {

            header('Location:' . BASE_URL);
            exit;
        }

        $dados = array();
        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);

        $dados['listaServico'] = $this->servicoModel->getListarServicos();
        $dados['conteudo'] = 'dash/servico/listar';
        $dados['func'] = $dadosFunc;
        $this->carregarViews('dash/dashboard', $dados);
    }

    // 2- Método para adicionar serviços
    public function adicionar()
    {

        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {

            header('Location:' . BASE_URL);
            exit;
        }

        $dados = array();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            // TBL SERVICO
            $nome_servico                   = filter_input(INPUT_POST, 'nome_servico', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao_servico              = filter_input(INPUT_POST, 'descricao_servico', FILTER_SANITIZE_SPECIAL_CHARS);
            $preco_base_servico             = filter_input(INPUT_POST, 'preco_base_servico', FILTER_SANITIZE_NUMBER_FLOAT);
            $tempo_estimado_servico         = filter_input(INPUT_POST, 'tempo_estimado_servico');
            $id_especialidade               = filter_input(INPUT_POST, 'id_especialidade', FILTER_SANITIZE_NUMBER_INT);
            $status_servico                 = filter_input(INPUT_POST, 'status_servico', FILTER_SANITIZE_SPECIAL_CHARS);

            $nova_especialidade             = filter_input(INPUT_POST, 'nova_especialidade', FILTER_SANITIZE_SPECIAL_CHARS);



            if ($nome_servico && $descricao_servico && $preco_base_servico !== false) {



                //1 Verificar a especialidade 
                if (empty($id_especialidade) && !empty($nova_especialidade)) {
                    // Criar e obter a especialidade Nova 
                    $id_especialidade = $this->servicoModel->obterOuCriarEspecialidade($nova_especialidade);
                }

                if (empty($id_especialidade)) {
                    $dados['mensagem'] = "É necessario escolher ou criar uma especialidade!!";
                    $dados['tipo-msg'] = "Erro!";
                    $this->carregarViews('dash/servico/adicionar', $dados);
                    return;
                }

                // 2 Link do Servico 
                $link_servico = $this->gerarLinkServico($nome_servico);


                // 3 Preparar Dados 

                $dadosServico = array(

                    'nome_servico'             => $nome_servico,
                    'descricao_servico'         => $descricao_servico,
                    'preco_base_servico'       => $preco_base_servico,
                    'tempo_estimado_servico'    => $tempo_estimado_servico,
                    'id_especialidade'          => $id_especialidade, // ESSE ID_ESPECIALIDADE PODE VIM DA LISTA OU DE UMA NOVA.
                    'status_servico'            => $status_servico,
                    'link_servico'              => $link_servico
                );

                // 4 Inserir Servico 


                $id_servico = $this->servicoModel->addServico($dadosServico);


                if ($id_servico) {

                    // Se foi enviada a foto
                    if (isset($_FILES['foto_galeria']) && $_FILES['foto_galeria']['error'] == 0) {

                        $arquivo = $this->uploadFoto($_FILES['foto_galeria'], $link_servico);

                        if ($arquivo) {
                            // Inserir na galeria 
                            $this->servicoModel->addFotoGaleria($id_servico, $arquivo, $nome_servico);
                        } else {
                            //Definir uma mensagem informado que a foto nao pode ser salva
                        }
                    }

                    //Mensagem de sucesso
                    $_SESSION['mensagem'] = "Serviço Adicionado Com Sucesso!";
                    $_SESSION['tipo-msg'] = "Sucesso";
                    header('location: http://localhost/kioficina/public/servicos/listar');
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao adiocionar o Serviço";
                    $dados['tipo-msg'] = "Erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos OBRIGATORIOS";
                $dados['tipo-msg'] = "Erro";
            }
        }


        // Buscar Funcionarios 
        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);


        // Buscar Especialidades 
        $especialidades = new Especialidades();
        $dados['especialidades'] = $especialidades->getTodasEspecialidades();



        $dados['conteudo'] = 'dash/servico/adicionar';
        $dados['func'] = $dadosFunc;

        $this->carregarViews('dash/dashboard', $dados);
    }

    // 3- Método para editar
    public function editar($id = null)
{
    $dados = array();
 
    if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
        header('Location:https://localhost/kioficina/public/');
        exit;
    }
 
    if ($id === null) {
        header('Location:https://localhost/kioficina/public/servicos/listar');
        exit;
    }
 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome_servico = filter_input(INPUT_POST, 'nome_servico', FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao_servico = filter_input(INPUT_POST, 'descricao_servico', FILTER_SANITIZE_SPECIAL_CHARS);
        $preco_base_servico = filter_input(INPUT_POST, 'preco_base_servico', FILTER_SANITIZE_NUMBER_FLOAT);
        $tempo_estimado_servico = filter_input(INPUT_POST, 'tempo_estimado_servico');
        $alt_foto_servico = $nome_servico;
        $id_especialidade = filter_input(INPUT_POST, 'id_especialidade', FILTER_SANITIZE_NUMBER_INT);
        $status_servico = filter_input(INPUT_POST, 'status_servico', FILTER_SANITIZE_SPECIAL_CHARS);
        $nova_especialidade = filter_input(INPUT_POST, 'nova_especialidade', FILTER_SANITIZE_SPECIAL_CHARS);
 
        if ($nome_servico && $descricao_servico && $preco_base_servico !== false) {
            if(empty($id_especialidade) && !empty($nova_especialidade)){
                $id_especialidade = $this->servicoModel->obterOuCriarEspecialidade($nova_especialidade);
            }
 
            if(empty($id_especialidade)){
                $_SESSION['mensagem'] = "É necessário escolher ou criar uma especialidade!";
                $_SESSION['tipo-msg'] = "Erro!";
                header('Location: http://localhost/kioficina/public/servicos/editar/' . $id);
                exit;
            }
 
            $link_servico = $this->gerarLinkServico($nome_servico);
 
            $dadosServico = array(
                'nome_servico' => $nome_servico,
                'descricao_servico' => $descricao_servico,
                'preco_base_servico' => $preco_base_servico,
                'tempo_estimado_servico' => $tempo_estimado_servico,
                'alt_foto_servico' => $nome_servico,
                'id_especialidade' => $id_especialidade,
                'status_servico' => $status_servico,
                'link_servico' => $link_servico
            );
 
            $id_servico = $this->servicoModel->atualizarServico($id, $dadosServico);
 
            if ($id_servico) {
                if (isset($_FILES['foto_galeria']) && $_FILES['foto_galeria']['error'] == 0) {
                    $arquivo = $this->uploadFoto($_FILES['foto_galeria'], $link_servico);
                    if ($arquivo) {
                        $this->servicoModel->atualizarFotoGaleria($id, $arquivo, $nome_servico);
                    }
                }
 
                $_SESSION['mensagem'] = "Serviço Atualizado Com Sucesso!";
                $_SESSION['tipo-msg'] = "Sucesso";
                header('location: http://localhost/kioficina/public/servicos/listar');
                exit;
            } else {
                $dados['mensagem'] = "Erro ao atualizar o Serviço";
                $dados['tipo-msg'] = "Erro";
            }
        } else {
            $dados['mensagem'] = "Preencha todos os campos OBRIGATÓRIOS";
            $dados['tipo-msg'] = "Erro";
        }
    }
 
    $servico = $this->servicoModel->getServicoById($id);
    $dados['servico'] = $servico;
 
    $func = new Funcionario();
    $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);
 
    $especialidades = new Especialidades();
    $dados['especialidades'] = $especialidades->getTodasEspecialidades();
 
    $dados['conteudo'] = 'dash/servico/editar';
    $dados['func'] = $dadosFunc;
 
    $this->carregarViews('dash/dashboard', $dados);
}

    // 4- Método para desativar o serviço
    public function desativar($id = null){
 
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            http_response_code(400);
            echo json_encode(["Sucesso" => false, "Mensagem" => "Acesso Negado."]);
            exit;
        }
 
        if($id === null){
            http_response_code(400);
            echo json_encode(["Sucesso" => false, "Mensagem" => "ID Invalido."]);
            exit;
        }
 
        $resultado = $this->servicoModel->desativarServico($id);
        header('Content-Type: application/json');
        if($resultado){
            $_SESSION['mensagem'] = "Serviço Desativado com SUCESSO!";
            $_SESSION['tipo-msg'] = 'sucesso';
 
            echo json_encode(['sucesso' => true]);
        }else{
            $_SESSION['mensagem'] = "Falha ao Desativar o Serviço!";
            $_SESSION['tipo-msg'] = 'erro';
 
            echo json_encode(['sucesso' => false, 'mensagem' => "Falha ao Desativar o Serviço"]);
        }
 
       
    }

    // 5 metodo upload das fotos
    private function uploadFoto($file)
    {

        $dir = '../public/uploads/servico/';

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
            return 'servico/' . $nome_arquivo; // Caminho relativo
        }

        // Retorna falso caso o upload falhe
        return false;
    }

    // Método para gerar link serviço 
    public function gerarLinkServico($nome_servico)
    {


        //Remover os acentos

        $semAcento = iconv('UTF-8', 'ASCII//TRANSLIT', $nome_servico);

        // Substituir qualquer caracter que não seja letra ou numero por hifen

        $link = strtolower(trim(preg_replace('/[^a-zA-Z0-9]/', '-', $semAcento)));

        // var_dump($link);


        // Verifica se ja existe no banco

        $contador = 1;
        $link_original = $link;
        while ($this->servicoModel->existeEsseServico($link)) {

            $link = $link_original . '-' . $contador;
            //troca-de-bateria-1
            $contador++;
        }

        return $link;
    }
} //FIM DA CLASSE
