<?php

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

// Definir uma URL BASE
define('BASE_URL','http://localhost/kioficinaMobile/public/');

// Definir uma API Base
define('BASE_API', 'https://360criativo.com.br/api/');

// Sistema para carregamento automático das classes geradas
spl_autoload_register(function ($class){

    if(file_exists('../app/controllers/'.$class.'.php')){
        require_once '../app/controllers/'.$class.'.php';
    }
    
    if(file_exists('../rotas/'.$class.'.php')){
        require_once '../rotas/'.$class.'.php';
    }
    

});