<?php
    /* Iniciar Sessão */
    session_start();

    /* Fuso-horário */
    date_default_timezone_set('America/Sao_Paulo');

    /* Configurações */
    $APP_ROOT = dirname(__FILE__);
    require_once("$APP_ROOT/application/config/Config.php");

    /* Implementar Loaders */
    function loadController($classe) {
        global $APP_ROOT;

        $arquivo = "$APP_ROOT/application/controller/$classe.php";
        
        if (file_exists($arquivo)) {
            require_once($arquivo);
            return true;
        }
    }    

    function loadModuleController($classe) {
        global $APP_ROOT;

        $arquivo = "$APP_ROOT/application/controller/modules/$classe.php";
        
        if (file_exists($arquivo)) {
            require_once($arquivo);
            return true;
        }
    }    

    function loadModel($classe) {
        global $APP_ROOT;

        $models   = array();
        $models[] = 'other';
        $models[] = 'util';
        $models[] = 'schedule';
        $models[] = 'user';

        foreach ($models as $subdir) {
            $arquivo = "$APP_ROOT/application/model/$subdir/$classe.php";
            
            if (file_exists($arquivo)) {
                require_once($arquivo);
                return true;
            }
        }
    }

    /* Registrar Loaders */
    spl_autoload_register('loadController');
    spl_autoload_register('loadModuleController');
    spl_autoload_register('loadModel');
