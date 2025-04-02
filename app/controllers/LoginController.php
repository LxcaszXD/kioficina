<?php
class LoginController extends Controller{

    public function index(){
        
        $dados = array();
        $dados ['titulo'] = 'KiOficina - Login';

        $this->carrgarViews('login', $dados);

    }
}

?>