<?php


class ApiController extends Controller
{

    private $servicoModel;
    private $clienteModel;
    private $veiculoModel;
    private $agendamentoModel;


    public function __construct()
    {

        $this->servicoModel = new Servico();
        $this->clienteModel = new Cliente();
        $this->veiculoModel = new Veiculo();
        $this->agendamentoModel = new Agendamento();
    }

    // Listar Serviços - API
    public function ListarServico()
    {

        $servico = $this->servicoModel->getTodosServicos();
        if (empty($servico)) {
            http_response_code(404);
            echo json_encode(["mensagem" => "Nenhum registro encontrado"]);
            exit;
        }
        echo json_encode($servico, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }


    /** CLIENTE API */

    //** LOGIN */
    public function login()
    {

        $email = $_GET['email_cliente'] ?? null;
        $senha = $_GET['senha_cliente'] ?? null;

        //var_dump($email);
        //var_dump($senha);

        if (!$email || !$senha) {
            http_response_code(400);
            echo json_encode(['erro' => 'E-mail ou senha são obrigatórios'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }


        $cliente = $this->clienteModel->buscarCliente($email);

        //var_dump($cliente);

        if (!$cliente || $senha != $cliente["senha_cliente"]) {
            http_response_code(401);
            echo json_encode(['erro' => 'E-mail e senha inválido'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        //Gerar um token
        $token = base64_encode(json_encode(['id' => $cliente['id_cliente'], 'email' => $cliente['email_cliente']]));

        //var_dump($token);

        echo json_encode([
            'mensagem'  => 'Login realizado com sucesso',
            'token'     => $token
        ]);
    }

    // Retonar os dados do cliente pelo ID
    public function cliente($id)
    {
        $cliente = $this->clienteModel->getClienteById($id);

        if (!$cliente) {
            http_response_code(404);
            echo json_encode(["erro" => "Cliente não encontrado"]);
            exit;
        }

        echo json_encode($cliente, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // Atualizar dados do Cliente
    public function atualizarCliente($id)
    {
        // Verifica se a requisição é PATCH
        if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
            http_response_code(405);
            echo json_encode(["erro" => "Método não permitido"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }
    
        // Para receber dados via JSON ou via parâmetros (form-data)
        $dados = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        
    
        // Verifica se os dados foram recebidos corretamente
        if (!is_array($dados) || empty($dados)) {
            http_response_code(400);
            echo json_encode(["erro" => "Nenhum dado enviado"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }
    
        // Obtém os dados atuais do cliente no banco
        $clienteAtual = $this->clienteModel->getClienteById($id);
        if (!$clienteAtual) {
            http_response_code(404);
            echo json_encode(["erro" => "Cliente não encontrado"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }
    
        // Atualiza apenas os campos enviados, mantendo os existentes se não forem alterados
        $dadosAtualizados = array_merge($clienteAtual, $dados);
    
        // Verifica se um arquivo de imagem foi enviado
        if (!empty($_FILES['foto_cliente']['name'])) {
            $foto_cliente = $this->uploadFoto($_FILES['foto_cliente'], $clienteAtual['nome_cliente'], $clienteAtual['id_cliente']);
            if ($foto_cliente) {
                $dadosAtualizados['foto_cliente'] = $foto_cliente;
                $dadosAtualizados['alt_foto_cliente'] = $dadosAtualizados['nome_cliente'];
            }
        }
    
        // Atualiza no banco de dados
        $atualizado = $this->clienteModel->atualizarCliente($id, $dadosAtualizados);
    
        if ($atualizado) {
            echo json_encode(["mensagem" => "Cliente atualizado com sucesso"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(500);
            echo json_encode(["erro" => "Erro ao atualizar os dados"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }
    

     /** Método para Upload da Foto */
     private function uploadFoto($file, $nome_cliente, $id_cliente)
     {
         $dir = '../public/uploads/cliente/';
 
         // Remover os acentos caracteres em caixa baixa
         $semAcento = iconv('UTF-8', 'ASCII//TRANSLIT', $nome_cliente);
 
         /** Subtituir qualquer caracater que não seja letra ou número por hífen */
         $novoNome = strtolower(trim(preg_replace('/[^a-zA-Z0-9]/', '-', $semAcento)));
 
 
         if (!file_exists($dir)) {
             mkdir($dir, 0755, true);
         }
 
         $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
         $novoNome = $nome_cliente . '-' . $id_cliente . '.' . $ext;
 
         if (move_uploaded_file($file['tmp_name'], $dir . $novoNome)) {
             return 'cliente/' . $novoNome; 
         }
 
         return false;  // Caso o upload falhe
     }
    

    // Retonar os dados do Veículo do Cliente pelo ID CLIENTE
    public function veiculo($id)
    {
        $veiculo = $this->veiculoModel->getVeiculoIdCliente($id);

        if (!$veiculo) {
            http_response_code(404);
            echo json_encode(["erro" => "Veículo não encontrado"]);
            exit;
        }

        echo json_encode($veiculo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // Retonar os Serviços executados no(s) veículo(s) do cliente pelo ID
    public function servicoExecutadoPorCliente($id)
    {

        $executado = $this->clienteModel->servicoExecutadoPorIdCliente($id);

        if (!$executado) {
            http_response_code(404);
            echo json_encode(["erro" => "Serviço(s) não encontrado"]);
            exit;
        }

        echo json_encode($executado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // Agendamento do cliente
    public function agendamentosPorCliente($id)
    {
        $agendamentos = $this->clienteModel->getAgendamentosPorCliente($id);

        if (!$agendamentos) {
            http_response_code(404);
            echo json_encode(["erro" => "Nenhum agendamento encontrado"]);
            exit;
        }

        echo json_encode($agendamentos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }


}
