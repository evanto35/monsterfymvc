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

    /* Iniciar Sessão */
    session_start();

    /* Diretórios */
    define('APP_LOCAL_PATH', dirname(__FILE__));
    define('APP_LOCAL_IMAGES_PATH', dirname(__FILE__) + '/assets/images/');
    define('APP_REMOTE_PATH', '../..');

    /* Fuso-horário */
    date_default_timezone_set('America/Sao_Paulo');

    /* Loader */
    function loadMonsterfy($classe) {
        $path   = array();
        $path[] = 'commons';
        $path[] = 'controllers';
        $path[] = 'models/dao';
        $path[] = 'models/dto';

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