<?php
    /* Iniciar Sessão */
    session_start();

    define("APP_ROOT", dirname(__FILE__));
    

    /* Fuso-horário */
    date_default_timezone_set('America/Sao_Paulo');

    /* Configurações */
    require_once(APP_ROOT . "/config/Config.php");
    
    /* Implementar Loaders */
    function loadController($classe) {
        $arquivo = APP_ROOT . "/controller/$classe.php";
        
        if (file_exists($arquivo)) {
            require_once($arquivo);
            return true;
        }
    }   

    function loadModel($classe) {
        $models   = array();
        $models[] = 'entities';
        $models[] = 'util';

        foreach ($models as $subdir) {
            $arquivo = APP_ROOT . "/$subdir/$classe.php";
            
            if (file_exists($arquivo)) {
                require_once($arquivo);
                return true;
            }
        }
    }

    /* Registrar Loaders */
    spl_autoload_register('loadController');
    spl_autoload_register('loadModel');


    if (isset($_GET['action']) && $_GET['action'] == 'flush') {
        session_unset();
    }