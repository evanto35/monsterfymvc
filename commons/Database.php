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
 * Banco de Dados
 * 
 * <p>Responsável pela comunicação com o banco de dados.</p>
 *
 * @package commons
 * @author  Leandro Medeiros
 * @since   2015-07-08
 * @link    http://bitbucket.org/leandro_medeiros/monsterfymvc
 */
final class Database {
    /**
     * Conexão ao Banco de Dados
     * @var PDO
     */
    private static $connection;

    /**
     * Obter Conexão
     *
     * <p>Faz o controle do singleton.</p>
     *
     * @method getConnection
     * @return PDO instância da conexão
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    private static function getConnection() {
        if (!static::$connection) {
            try {
                static::$connection = new PDO(Config::getConnectionString(),
                                              Config::DB_USER,
                                              Config::DB_PASSWORD,
                                              array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
            }
            catch (PDOException $e) {
                static::$connection = null;

                Lib::log($e->getCode() . ": " . $e->getMessage());

                new Alert(sprintf(Alert::MSG_DB_CONNECTION_FAIL, $e->getMessage()), Alert::ERROR);

                throw $e;
            }
        }

        return static::$connection;
    }

    /**
     * Preparar Script
     *
     * @method prepare
     * @param  string $script Script que será executado
     * @param  array $options Opções Extras
     * @return PreparedStatment
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public static function prepare($script, $options = array()) {
        return self::getConnection()->prepare($script, $options);
    }
}