<?php
class AgendamentoController extends Controller{

    public function index(){
        
        $dados = array();
        $dados ['titulo'] = 'KiOficina - Agendamento';

        $this->carregarViews('agendamento', $dados);

    }
}

?>