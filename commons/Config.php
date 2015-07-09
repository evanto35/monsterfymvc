<?php

/**
 * <h1>Configurações</h1>
 * 
 * <p>Contém constantes de parametrização da aplicação. Modifique à vontade.</p>
 * 
 * @author Leandro Medeiros
 * @since  2015-07-08
 * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
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