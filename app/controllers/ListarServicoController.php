<?php
class ListarServicoController extends Controller{

    public function index(){
        
        $dados = array();
        $dados ['titulo'] = 'KiOficina - Serviços';

        $this->carregarViews('listarServico', $dados);

    }
}

?>