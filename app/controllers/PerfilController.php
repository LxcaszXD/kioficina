<?php
class PerfilController extends Controller{

    public function index(){
        
        $dados = array();
        $dados ['titulo'] = 'KiOficina - Perfil';

        $this->carrgarViews('perfil', $dados);

    }
}

?>