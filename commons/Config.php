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
##                                                                         ##
#############################################################################

/**
 * <h1>Configurações</h1>
 * 
 * <p>Contém constantes de parametrização da aplicação. Modifique à vontade.</p>
 *
 * @package commons
 * @author  Leandro Medeiros
 * @since   2015-07-08
 * @link    http://bitbucket.org/leandro_medeiros/monsterfymvc
 */
abstract class Config {
    /**
     * Título da Aplicação
     * @var string
     */
    const APP_TITLE = 'Monsterfy MVC';

    /**
     * Versão da Aplicação
     * @var string
     */
    const APP_VERSION = '2.2';

    /**
     * Módulo Padrão
     * @var string
     */
    const DEFAULT_MODULE = 'dashboard';

    /**
     * Controllers devem retornar os objetos View codificados em JSON
     * @var boolean
     */
    const JSON_RESPONSE = false;

    /**
     * Driver do Banco de Dados
     * @var string
     */
    const DB_DRIVER = 'mysql';
    
    /**
     * Host do Banco de Dados
     * @var string
     */
    const DB_HOST = '127.0.0.1';
    
    /**
     * Porta do Banco de Dados
     * @var string
     */
    const DB_PORT = 3306;

    /**
     * Nome do Banco de Dados
     * @var string
     */
    const DB_NAME = 'monsterfymvc';

    /**
     * Usuário do Banco de Dados
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Senha do Banco de Dados
     * @var string
     */
    const DB_PASSWORD = 'Develop#23';

    /**
     * String de conexão ao Banco de Dados
     * @var string
     */
    const CONNECTION_STRING = '%s:host=%s;dbname=%s;charset=utf8;port=%d';

    /* Últimos parâmetros */
    const IDX_LAST_ARGS = 'idx_00';

    /* Usuário Logado */
    const IDX_LOGGED = 'idx_01';

    /* ID do último usuário logado */
    const IDX_LAST_LOGGED = 'idx_02';

    /* Instância do System */
    const IDX_SYSTEM = 'idx_03';

    /* Variáveis para depuração */
    const IDX_DEBUGGING = 'idx_04';

    /**
     * <h1>Obter String de Conexão</h1>
     *
     * @method getConnectionString
     * @return string String para conexão ao banco no formato de PDO
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public static function getConnectionString() {
    	return sprintf(self::CONNECTION_STRING,
    				   self::DB_DRIVER,
    				   self::DB_HOST,
    				   self::DB_NAME,
                       self::DB_PORT);
    }
}