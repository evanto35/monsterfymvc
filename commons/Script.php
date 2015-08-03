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
 * <h1>Classe Script</h1>
 * 
 * <p>Classe para executar scripts no banco de dados
 * baseado na estrutura de um DTO.</p>
 *
 * @package commons
 * @author  Leandro Medeiros
 * @since   2015-07-08
 * @link    http://bitbucket.org/leandro_medeiros/monsterfymvc
 */
final class Script {
    /**
     * Argumentos do script
     * @var array
     */
    private $args   = array();

    /**
     * Dataset com retorno do script
     * @var array
     */
    public  $dataset = array();

    /**
     * Tabela
     * @var string
     */
    public $table;

    /**
     * Chave primária
     * @var string
     */
    public $primaryKey = 'id';

    /**
     * Define se os registros devem ser apagados ou desativados
     * @var boolean
     */
    public $deactiveOnDelete = true;

    /**
     * Atributos correspondentes na tabela de origem
     * @var array
     */
    public $fields = array();

    /**
     * SQL que será executado
     * @var string
     */
    public $sql;

    /**
     * <h1>Construtor</h1>
     *
     * @method __construct
     * @param  BaseDTO $Dto Objeto DTO para configurar os campos da tabela 
     * @author Leandro Medeiros
     * @since  2015-07-08
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    final public function __construct(BaseDTO $Dto) {
		$this->fields = array_keys(get_object_vars($Dto));
    }

    /**
     * <h1>Obter script SELECT</h1>
     *
     * @method getSelect
     * @return Script própria instância
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
	public function getSelect() {
		$this->sql = "SELECT `" . implode('`, `', $this->fields) . "` FROM {$this->table} ";

		return $this;
	}

    /**
     * <h1>Adicionar uma condição</h1>
     *
     * @method where
     * @return Script própria instância
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function where($conditions = '', $link = 'AND') {
        if (strpos(strtoupper($this->sql), 'WHERE')) {
            $this->sql .= $link;
        }
        else {
            $this->sql .= ' WHERE ';
        }

        if (!empty($conditions)) {
            if (is_array($conditions)) {
                foreach ($conditions as $field => $value) {
                    $this->sql .= " {$link} ({`$field`} = {$value} ";
                }
            }
            else {
                $this->sql .= " ({$conditions}) ";
            }
        }
        else if (!empty($this->{$this->primaryKey})) {
            $this->sql .= " (({$this->table}.{$this->primaryKey} = :id) AND {$this->table}.active) ";
        }
        else {
            $this->sql .= " ({$this->table}.active) ";
        }
            
        return $this;
    }

    /**
     * <h1>Adicionar cláusula ORDER</h1>
     *
     * @method order
     * @return Script própria instância
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function order($conditions) {
        if (!empty($conditions)) {
            $this->sql .= " ORDER BY {$conditions} ";
        }
        return $this;
    }

    /**
     * <h1>Adiciona cláusula LIMIT</h1>
     *
     * @method limit
     * @return Script própria instância
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function limit($max = 1) {
        if (!empty($max)) {
            $this->sql .= " LIMIT {$max} ";
        }
        return $this;
    }

    /**
     * <h1>Obter script UPDATE</h1>
     *
     * @method getUpdate
     * @return Script própria instância
     * @author Leandro Medeiros
     * @since  2015-07-08
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function getUpdate() {
		$this->sql = "UPDATE {$this->table}
				         SET ({implode(', ', $this->fields)})
				       WHERE {$this->table}.{$this->primaryKey} = :id ";
        return $this;
	}

    /**
     * <h1>Obter script INSERT</h1>
     *
     * @method getUpdate
     * @return Script própria instância
     * @author Leandro Medeiros
     * @since  2015-07-08
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
	public function getInsert() {
		$this->sql = "INSERT INTO {$this->table} (" . implode(', ', $this->args) . ") 
 				           VALUES (:" . implode(', :', $this->args) . ")";
        return $this;
	}

	/**
	 * <h1>Obter script DELETE</h1>
	 *
	 * @method getDelete
	 * @return Script própria instância
	 * @author Leandro Medeiros
	 * @since  2015-07-08
	 * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
	 */
	public function getDelete() {
		if ($this->deactiveOnDelete) {
			$this->sql = "UPDATE {$this->table}
					         SET (active = false) 
					       WHERE {$this->table}.{$this->primaryKey} = :id";
        }
		else {
			$this->sql = "DELETE FROM {$this->table} WHERE {$this->table}.{$this->primaryKey}ß = :id";
        }

        return $this;
	}

    /**
     * <h1>Serializar</h1>
     *
     * @method __sleep
     * @return array Atributos que devem ser serializados
     * @author Leandro Medeiros
     * @since  2015-07-08
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function __sleep() {
        return array('args', 'dataset');
    }

    /**
     * <h1>Limpa Argumentos</h1>
     *
     * @method clearArguments
     * @return Script própria instância
     * @author Leandro Medeiros
     * @since  2015-07-08
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function clearArguments() {
        unset($this->args);
        $this->args = array();
        return $this;
    }

    /**
     * <h1>Adicionar Parâmetro</h1>
     * 
     * <p>Adiciona um argumento aos parâmetros do script.</p>
     *
     * @method addArgument
     * @param  string $argument Nome do argumento
     * @param  mixed  $value	Valor do argumetno
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function addArgument($argument, $value) {
        $argument = ':' . $argument;
        
        if (strpos($this->sql, $argument) !== false) {
            $this->args[$argument] = $value;
        }

        return $this;
    }
    
    /**
     * <h1>Definir Parâmetros</h1>
     * 
     * <p>Define os argumentos do script a partir de um DTO.</p>
     *
     * @method setArguments
     * @param  BaseDTO $Dto DTO preenchido
     * @return Script própria instância
     * @author Leandro Medeiros
     * @since  2015-07-08
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function setArguments(BaseDTO $Dto) {
        $this->clearArguments();

        foreach ($Dto as $arg => $value) {
            $this->addArgument($arg, $value);
        }

        return $this;
    }

    /**
     * <h1>Executar Script</h1>
     *
     * @method execute
     * @param  boolean $keepArguments Manter Argumentos após execução do script
     * @return boolean Sucesso
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function execute($keepArguments = false) {
        try {
            if (!empty($this->args)) {
                $statement     = Database::prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $this->dataset = $statement->execute($this->args);
            }

            else {
                $statement     = Database::prepare($this->sql);
                $this->dataset = $statement->execute();
            }
            
            if (!Lib::startsWith(strtoupper(trim($this->sql)), 'SELECT')) {
                return true;
            }
            else if (!empty($this->dataset)) {
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

    /**
     * <h1>Obter BLOB</h1>
     *
     * <p>Executa uma consulta na tabela e retorna o binário do registro.<p>
     *
     * @method getBlob
     * @param  string $field Campo que contém dados binários
     * @param  string $where Condições da consulta
     * @return mixed  Binário
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function getBlob($field, $where) {
        $query = "SELECT {$field} FROM {$this->Script->table} WHERE {$where}";

        $statement = Database::prepare($query);
        $statement->execute();
        $statement->bindColumn(1, $blob, PDO::PARAM_LOB);
        $statement->fetch(PDO::FETCH_BOUND);

        return $blob;
    }
}