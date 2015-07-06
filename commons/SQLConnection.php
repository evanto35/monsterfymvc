<?php

class SQLConnection {
    private static $instance;
    public $connection;

    private function connect() {
        try {
            $this->connection = new PDO(Config::getConnectionString(),
                                        Config::DB_USER,
                                        Config::DB_PASSWORD,
                                        array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
        }
        catch (Exception $e) {
            echo '<pre>';
            print_r($e);
            echo '</pre>';            
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new SQLConnection();
            self::$instance->connect();
        }

        return self::$instance;
    }
}