<?php
class DepoimentosController extends Controller{

    public function index(){
        
        $dados = array();
        $dados ['titulo'] = 'KiOficina - Depoimentos';

        $this->carrgarViews('depoimentos', $dados);

    }
}

?>