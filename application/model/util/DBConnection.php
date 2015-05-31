<?php

class DBConnection {
    private static $instance;
    private $connection;

    private function connect() {
        $this->connection = new PDO(Config::getConnectionString(),
                                    Config::DB_USER,
                                    Config::DB_PASSWORD);
        
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new DBConnection();
            self::$instance->connect();
        }

        return self::$instance;
    }

    private function execute($sql, $params = null) {
        $statement = $this->connection->prepare($sql);
        $statement->execute($params);
        
        // SÓ RETORNA PARA OPERAÇÕES DE CONSULTA
        // (nas quais não há dados de entrada)
        if (empty($params)) {
            return $statement->fetchAll(PDO::FETCH_ASSOC); 
        }
    }

    public function fetch($table, $fields, $where = null, $filter = null, $order = null, $limit = null) {
        /**
         * @todo Transformar $fields em array e separar campos e valores do $where
         */

        $query = "SELECT $fields FROM $table";

        if (!empty($where))  $query .= " WHERE $where";
        if (!empty($filter)) $query .= " LIKE '$filter'";
		if (!empty($order))  $query .= " ORDER BY $order";
		if (!empty($limit))  $query .= " LIMIT $limit";

		return $this->execute($query);
    }

    public function getBlob($table, $field, $where) {
        $query = "SELECT $field FROM $table WHERE $where";

        $statement = $this->connection->prepare($query);
        $statement->execute();
        $statement->bindColumn(1, $blob, PDO::PARAM_LOB);
        $statement->fetch(PDO::FETCH_BOUND);

        return $blob;
    }
}