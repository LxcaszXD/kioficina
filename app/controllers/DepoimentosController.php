<?php
class DepoimentosController extends Controller{

    public function index(){
        
        $dados = array();
        $dados ['titulo'] = 'KiOficina - Depoimentos';

        $this->carregarViews('depoimentos', $dados);

    }
}

?>