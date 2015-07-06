<?php
    /* Iniciar Sessão */
    session_start();

    /* Diretórios */
    define("APP_LOCAL_PATH", dirname(__FILE__));
    define("APP_REMOTE_PATH", $_SERVER['HTTP_ROOT']);

    /* Dados da Aplicação */
    define("APP_TITLE", "Monsterfy MVC");
    define("APP_VERSION", "2.1");
    
    /* Fuso-horário */
    date_default_timezone_set('America/Sao_Paulo');

    /* Configurações */
    //require_once(APP_ROOT . "/config/Config.php");

    function loadMonsterfy($classe) {
        $path   = array();
        $path[] = 'commons';
        $path[] = 'controllers';
        $path[] = 'models';

        foreach ($path as $subdir) {
            $arquivo = APP_ROOT . "/$subdir/$classe.php";
            
            if (file_exists($arquivo)) {
                require_once($arquivo);
                return true;
            }
        }
    }

    /* Registrar Loaders */
    spl_autoload_register('loadMonsterfy');

    /* Logoff via GET */
    if (isset($_GET['action']) && $_GET['action'] == 'flush') {
        session_destroy();
    }