<?php

/**
 * <h1>Banco de Dados</h1>
 * 
 * <p>Responsável pela comunicação com o banco de dados.</p>
 * 
 * @author Leandro Medeiros
 * @since  2015-07-08
 * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
 */
final class Database {
    /**
     * Conexão ao Banco de Dados
     * @var PDO
     */
    private static $connection;

    /**
     * <h1>Obter Conexão</h1>
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
            static::$connection = new PDO(Config::getConnectionString(),
                                          Config::DB_USER,
                                          Config::DB_PASSWORD,
                                          array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
        }

        return static::$connection;
    }

    /**
     * <h1>Preparar Script</h1>
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