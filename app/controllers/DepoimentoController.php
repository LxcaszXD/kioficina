<?php

class DepoimentoController extends Controller
{
    private $depoimentoModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->depoimentoModel = new Depoimento();
    }

    public function listar()
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            header('Location:' . BASE_URL);
            exit;
        }

        $dados = array();
        $dados['conteudo'] = 'dash/depoimento/listar';

        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);
        $dados['func'] = $dadosFunc;

        $dadosdepoimento = $this->depoimentoModel->getTodosDepoimentos();
        $dados['depoimento'] = $dadosdepoimento;

        $this->carregarViews('dash/dashboard', $dados);
    }

    public function adicionar()
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            header('Location:' . BASE_URL);
            exit;
        }

        $dados = array();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_cliente = filter_input(INPUT_POST, 'id_cliente', FILTER_SANITIZE_NUMBER_INT);
            $descricao_depoimento = filter_input(INPUT_POST, 'descricao_depoimento', FILTER_SANITIZE_SPECIAL_CHARS);
            $nota_depoimento = filter_input(INPUT_POST, 'nota_depoimento', FILTER_SANITIZE_NUMBER_INT);
            $status_depoimento = filter_input(INPUT_POST, 'status_depoimento', FILTER_UNSAFE_RAW);

            if ($id_cliente && $descricao_depoimento && $nota_depoimento && $status_depoimento) {
                $dadosDepoimento = [
                    'id_cliente' => $id_cliente,
                    'descricao_depoimento' => $descricao_depoimento,
                    'nota_depoimento' => $nota_depoimento,
                    'status_depoimento' => $status_depoimento
                ];

                if ($this->depoimentoModel->addDepoimento($dadosDepoimento)) {
                    $_SESSION['mensagem'] = "Depoimento cadastrado com sucesso!";
                    $_SESSION['tipo-msg'] = "sucesso";
                } else {
                    $_SESSION['mensagem'] = "Erro ao cadastrar depoimento.";
                    $_SESSION['tipo-msg'] = "erro";
                }

                header('Location:' . BASE_URL . '/depoimento/listar');
                exit;
            } else {
                $_SESSION['mensagem'] = "Preencha todos os campos corretamente!";
                $_SESSION['tipo-msg'] = "erro";
            }
        }

        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);

        $cliente = new DepoimentoCliente();
        $dados['cliente'] = $cliente->getDepoimentoCliente();

        $dados['conteudo'] = 'dash/depoimento/adicionar';
        $dados['func'] = $dadosFunc;

        $this->carregarViews('dash/dashboard', $dados);
    }
}
