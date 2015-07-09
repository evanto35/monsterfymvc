<?php
    /* Iniciar Sessão */
    session_start();

    /* Diretórios */
    define('APP_LOCAL_PATH', dirname(__FILE__));
    define('APP_LOCAL_PATH', dirname(__FILE__) + '/assets/images/');
    define('APP_REMOTE_PATH', '../..');

    /* Fuso-horário */
    date_default_timezone_set('America/Sao_Paulo');

    /* Loader */
    function loadMonsterfy($classe) {
        $path   = array();
        $path[] = 'commons';
        $path[] = 'controllers';
        $path[] = 'models';

        foreach ($path as $subdir) {
            $arquivo = APP_LOCAL_PATH . "/$subdir/$classe.php";
            
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