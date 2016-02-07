<?php
#############################################################################
##   MonsterfyMVC - MVC Framework for PHP + MySQL                          ##
##   Copyright (C) 2012  Leandro Medeiros                                  ##
##                                                                         ##
##   This program is free software: you can redistribute it and/or modify  ##
##   it under the terms of the GNU General Public License as published by  ##
##   the Free Software Foundation, either version 3 of the License, or     ##
##   (at your option) any later version.                                   ##
##                                                                         ##
##   This program is distributed in the hope that it will be useful,       ##
##   but WITHOUT ANY WARRANTY; without even the implied warranty of        ##
##   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         ##
##   GNU General Public License for more details.                          ##
##                                                                         ##
##   You should have received a copy of the GNU General Public License     ##
##   along with this program.  If not, see <http://www.gnu.org/licenses/>. ##
#############################################################################

    ##################
    # Iniciar Sessão #
    ##################
    session_start();

    ##############
    # Diretórios #
    ##############
    
    # Raiz
    define('BASEDIR', $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'cortex'.DIRECTORY_SEPARATOR);

    # Raiz (HTTP)
    define('HTTP_ROOT', sprintf('http://%s/cortex/', $_SERVER['HTTP_HOST']));

    # PHP
    define('PATH_APP', BASEDIR.'application/');

    # Módulos
    define('PATH_MODULE', BASEDIR.'modules/');

    # Endereços relacionais (para o frontend)
    define('PATH_MODULE_VIEW', HTTP_ROOT.'modules/');
    define('PATH_PLUGIN',      HTTP_ROOT.'plugins/');
    define('PATH_CSS',         HTTP_ROOT.'assets/css/');
    define('PATH_FONT',        HTTP_ROOT.'assets/fonts/');
    define('PATH_IMAGE',       HTTP_ROOT.'assets/images/');
    define('PATH_JS',          HTTP_ROOT.'assets/js/');

    chdir(BASEDIR);

    /* Fuso-horário */
    date_default_timezone_set('America/Sao_Paulo');

    # Loader
    function loadMonsterfy($classe) {
        $path = array(
            'commons',
            'controllers',
            'models',
            'models/dto',
        );

        foreach ($path as $subdir) {
            $arquivo = PATH_APP."$subdir/$classe.php";
            
            if (file_exists($arquivo)) {
                require_once($arquivo);
                return true;
            }
        }
    }

    # Registrar Loaders
    spl_autoload_register('loadMonsterfy');

    # Logoff via GET
    if (isset($_GET['action']) && $_GET['action'] == 'flush') {
        unset($_GET);
        session_destroy();

        foreach (glob('log/*') as $file) {
            unlink($file);
        }
    }

    new ApplicationContextLumine();

    /* Ambiente Dev // Logs e erros */
    if(!empty($_SERVER['HTTP_HOST']) && in_array($_SERVER['HTTP_HOST'], array('127.0.0.1','localhost'))) {
        ini_set('display_errors', 'On');
        error_reporting(E_ERROR | E_PARSE | E_NOTICE);
        //error_reporting(E_ALL ^ E_DEPRECATED);E_WARNING
        // Lumine_Log::setLevel(Lumine_Log::ERROR);
    }
