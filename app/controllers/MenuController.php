<?php
class MenuController extends Controller{

    public function index(){
        
        $dados = array();
        $dados ['titulo'] = 'KiOficina - Menu';

        $this->carrgarViews('menu', $dados);

    }
}
 
?>