<?php
class ListarAgendamentosController extends Controller{

    public function index(){
        
        $dados = array();
        $dados ['titulo'] = 'KiOficina - Agendamento';

        $this->carregarViews('listarAgendamentos', $dados);

    }
}

?>