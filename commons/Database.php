<?php

class Database {
	protected $SQLConnection;
    private   $tables   = array();
    private   $args 	= array();
    public    $dataset;
    private   $script;

    public function __sleep() {
        return array('tables', 'args', 'dataset', 'script');
    }

	public function __construct() {
		$this->SQLConnection = SQLConnection::getInstance();
        //$this->getTables();
	}

    public function addArgument($argument, $value) {
        $this->args[':' . $argument] = $value;
    }

    public function execute($script, $keepArguments = false) {
        $this->script = $script;
    
        try {
            if (!empty($this->args)) {
                $statement     = $this->SQLConnection->connection->prepare($this->script, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $this->dataset = $statement->execute($this->args);
            }

            else {
                $statement     = $this->SQLConnection->connection->prepare($this->script);
                $this->dataset = $statement->execute();
            }
            
            if (!Lib::startsWith(strtoupper(trim($this->script)), 'SELECT')) {
                return true;
            }
            else if ($this->dataset) {
                $this->dataset = $statement->fetchAll(PDO::FETCH_ASSOC);
                return (count($this->dataset) > 0);
            }

            if (!$keepArguments) $this->clearArguments();
        }

        catch (Exception $e) {
            Lib::log($e);
        }

        return false;
    }

    public function clearArguments() {
        unset($this->args);
        $this->args = array();
    }

    public function printArguments() {
        print_r($this->arguments);
        Lib::log($this);
    }

    public function message($message) {
        // echo '<pre>';
        // echo "Executar script {$this->script} com os argumentos <br>";
        // print_r($this->args);
        // echo "<br>disparou a mensagem<br>";
        // print_r($message);
        // echo '</pre>';
    }

    public function getBlob($table, $field, $where) {
        $query = "SELECT $field FROM $table WHERE $where";

        $statement = $this->SQLConnection->connection->prepare($query);
        $statement->execute();
        $statement->bindColumn(1, $blob, PDO::PARAM_LOB);
        $statement->fetch(PDO::FETCH_BOUND);

        return $blob;
    }
}