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
 * Classe Script
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
    private $args = array();

    /**
     * Dataset com retorno do script
     * @var array
     */
    public  $dataset = array();

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
     * SQL que será executado
     * @var string
     */
    public $sql;

    private $_alias;
    private $_select = array();
    private $_from;
    private $_where = array();
    private $_join  = array();
    private $_order = array();
    private $_limit;

    /**
     * Construtor
     *
     * @method __construct
     * @param  BaseDTO $Dto Objeto DTO para configurar os campos da tabela 
     * @author Leandro Medeiros
     * @since  2015-07-08
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    final public function __construct($mainTable, $alias = null) {
        if (!is_string($mainTable)) {
            throw new Exception('Nome de tabela inválido');
        }

        $this->_from   = $mainTable;
        $this->_alias  = !empty($alias) ? $alias : $this->_from;
    }

///////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// MÉTODOS PROTEGIDOS /////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

    /**
     * Obter campos selecionados
     *
     * @method getFields
     * @return string Campos com apelidos
     * @author Leandro Medeiros
     * @since  2015-08-26
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    protected function getFields() {
        $result = array();

        if (empty($this->_select)) {
            $this->selectAs();
        }

        foreach($this->_select as $field) {
            if (preg_match('@(.+)\.(.+)@', $field, $matches))
                $result[] = sprintf('`%s`.`%s`', $matches[1], $matches[2]);
            else
                $result[] = sprintf('`%s`.`%s`', $this->_alias, $field);
        }

        $result = (empty($result) ? '*' : implode(',' . PHP_EOL . "       ", $result));

        return $result . PHP_EOL;
    }

    /**
     * Obter cláusula "FROM"
     *
     * @method getFrom
     * @return string Cláusula
     * @author Leandro Medeiros
     * @since  2015-08-26
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    protected function getFrom() {
        $result = "  FROM `{$this->_from}` ";

        if ($this->_from != $this->_alias) {
            $result .= "`{$this->_alias}` ";
        }

        return $result . PHP_EOL;
    }

    /**
     * Obter os joins
     *
     * @method getJoin
     * @return string Cláusulas
     * @author Leandro Medeiros
     * @since  2015-08-26
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    protected function getJoin() {
        $result = '';

        foreach($this->_join as $join) {
            $result .= sprintf('  %s JOIN `%s` `%s` ON (`%s`.`%s` = `%s`.`%s`)',
                        $join['type'],
                        $join['toTable'],
                        $join['linkAlias'],
                        $this->_alias,
                        $join['linkBy'],
                        $join['toTable'],
                        $join['linkTo']
                    ) . PHP_EOL;
        }

        return $result;
    }

    /**
     * Obter cláusula WHERE
     *
     * @method getWhere
     * @return string Cláusula
     * @author Leandro Medeiros
     * @since  2015-08-26
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    protected function getWhere() {
        $result = '';

        if (!empty($this->_where)) {
            $result = implode(')' . PHP_EOL . "   AND (", $this->_where);
            $result = " WHERE ({$result})" . PHP_EOL;
        }

        return $result;
    }

    public function getOrder() {
        $result = array();

        foreach($this->_order as $field) {
            if (preg_match('@^`{0,1}(.+)`{0,1}\.`{0,1}(\w+)`{0,1}(.+)$@', $field, $matches)) {
                $result[] = sprintf("`%s`.`%s`%s", $matches[1], $matches[2], $matches[3]);
            }

            else {
                $vars = explode(' ', $field);
                $result[] = sprintf("`%s`.`%s`%s", $this->_alias, $vars[0], $vars[1]);
            }
        }

        $result = implode(', ', $result);

        if (!empty($result))
            $result = " ORDER BY " . $result;

        return $result;
    }

///////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////// MÉTODOS PÚBLICOS //////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

    /**
     * Atribui um alias à tabela principal da busca
     *
     * @method alias
     * @param  string $alias Apelido Desejado
     * @return Script Própria Instância
     * @author Leandro Medeiros
     * @since  2015-08-26
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function alias($alias) {
        if (empty($alias)) {
            throw new Exception('Apelido não pode ser vazio!');
        }

        $this->_alias = $alias;

        return $this;
    }

    /**
     * Inclui um campo na seleção
     *
     * @method select
     * @param  string $select Campo
     * @return Script Própria Instância
     * @author Leandro Medeiros
     * @since  2015-08-26
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function select($select) {
        $this->_select[] = $select;

        return $this;
    }

    public function selectAs() {
        $this->_select = array();

        $dtoclass = BaseDTO::getClassForTable($this->_from);

        if (!class_exists($dtoclass)) {
            throw new Exception(sprintf('Classe DTO para a tabela "%s" não existe!', $dtoclass));
        }

        $fields = get_class_vars($dtoclass);

        foreach ($fields as $property => $value) {
            $this->select($property);
        }

        return $this;
    }

    public function from($table) {
        $this->_from = $table;

        return $this;
    }

    /**
     * Inclui uma clásula JOIN
     *
     * @method join
     * @author Leandro Medeiros
     * @since  2015-08-26
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     * 
     * @param  string $toTable Nome da tabela que se deseja juntar
     * @param  string $linkBy Campo local que será usado para juntar as tabelas
     * @param  string $linkAlias Apelido para a tabela de pesquisa
     * @param  string $linkTo Campo da tabela de pesquisa que será usado na junção
     * @param  string $linkType Tipo da junção
     * 
     * @return Script Própria Instância
     */
    final public function join($toTable, $linkBy, $linkAlias = '', $linkTo = 'id', $linkType = 'INNER') {
        # Validação tipo de união
        if (!preg_match('@^(INNER|LEFT|CROSS|RIGHT)$@i', $linkType)) {
            throw new Exception('União Inválida: ' . $linkType);
        }

        $dtoclass = BaseDTO::getClassForTable($toTable);

        # Validação campo da tabela de pesquisa
        if (!property_exists($dtoclass, $linkTo)) {
            throw new Exception("Propriedade '{$linkTo}' não existe na tabela de pesquisa");
        }

        # Salvando o join
        $join = array(
            'type'      => $type,
            'toTable'   => $toTable,
            'linkAlias' => empty($linkAlias) ? $toTable : $linkAlias,
            'linkBy'    => $linkBy,
            'linkTo'    => $linkTo
        );
        $this->_join[$toTable] = $join;

        return $this;
    }

    /**
     * Adicionar uma condição
     *
     * @method where
     * @return Script própria instância
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function where($conditions) {
        if (!is_array($conditions)) {
            $conditions = array($conditions);
        }

        foreach($conditions as $condition) {
            if (preg_match('@`{0,1}(.+)`{0,1}\.`{0,1}(\w+)`{0,1}(.*)@', $condition, $matches)) {
                $this->_where[] = sprintf('`%s`.`%s`%s', $matches[1], $matches[2], $matches[3]);
            }
            else {
                $this->_where[] = $condition;
            }

            $args = func_get_args();
            
            if (count($args) > 1) {
                $count = preg_match_all('@(:\w+)@', $condition, $placeholders);

                array_shift($args);
                array_shift($placeholders);

                if (count($args) != $count) {
                    throw new Exception('Contagem de argumentos e valores não conferem!');
                }

                foreach($args as $idx => $value) {
                    $this->addArgument($placeholders[$idx][0], $value);
                }
            }
        }

        return $this;
    }

    public function order($field) {
        $this->_order[] = $field;
        
        return $this;
    }

    /**
     * Executar Script
     *
     * @method execute
     * @param  boolean $keepArguments Manter Argumentos após execução do script
     * @return mixed   Contagem de registros obtidos em caso de select ou booleano indicando sucesso
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function execute($script = '', $keepArguments = false) {
        try {
            if (!empty($script)) {
                $this->sql = $script;
            }
            else if (empty($this->sql)) {
                $this->getSelect();
            }

            if (empty($this->args)) {
                $statement     = Database::prepare($this->sql);
                $this->dataset = $statement->execute();
            }
            else {
                $statement     = Database::prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $this->dataset = $statement->execute($this->args);
            }
            
            $fetch = Lib::startsWith(strtoupper(trim($this->sql)), 'SELECT');

            if (!$fetch) {
                $result = true;
            }
            else if (!empty($this->dataset)) {
                $this->dataset = $statement->fetchAll(PDO::FETCH_ASSOC);
                $result = count($this->dataset);
            }
        }
        catch (Exception $ex) {
            Lib::log($ex, true);
            $result = false;
        }

        if (!is_array($this->dataset)) {
            $this->dataset = array();
        }

        $this->log();
        $this->sql = null;
        
        if (!$keepArguments) $this->clearArguments();

        return $result;
    }    

    /**
     * Adicionar Parâmetro
     * 
     * <p>Adiciona um argumento aos parâmetros do script.</p>
     *
     * @method addArgument
     * @param  string $argument Nome do argumento
     * @param  mixed  $value    Valor do argumetno
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function addArgument($argument, $value) {
        if (!preg_match('@^:\w+$@', $argument)) {
            $argument = ':' . $argument;
        }

        $this->args[$argument] = $value;

        return $this;
    }

    /**
     * Definir Parâmetros
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
            if (isset($value)) {
                $this->addArgument($arg, $value);
            }
        }

        return $this;
    }

    /**
     * Limpa Argumentos
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

    public function reset() {
        $this->_select = array();
        $this->_where  = array();
        $this->_join   = array();
        $this->_order  = array();
        $this->_limit  = '';
    }

    /**
     * Obter script SELECT
     *
     * @method getSelect
     * @return Script própria instância
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function getSelect() {
        $this->sql  = 'SELECT '
                    . $this->getFields() # Campos selecionados
                    . $this->getFrom()   # Tabela principal na consulta
                    . $this->getJoin()   # Joins
                    . $this->getWhere()  # Where
                    . $this->getOrder()  # Order
                    . ';';

        return $this;
    }

    /**
     * Obter script UPDATE
     *
     * @method getUpdate
     * @return Script própria instância
     * @author Leandro Medeiros
     * @since  2015-07-08
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function update() {
		$this->sql = "UPDATE {$this->table}
				         SET ({implode(', ', $this->fields)})
				       WHERE {$this->table}.{$this->primaryKey} = :id;";
        return $this->execute();
	}

    /**
     * Obter script INSERT
     *
     * @method getUpdate
     * @return Script própria instância
     * @author Leandro Medeiros
     * @since  2015-07-08
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
	public function insert() {
		$this->sql = "INSERT INTO {$this->table} (" . implode(', ', $this->args) . ") 
 				           VALUES (:" . implode(', :', $this->args) . ");";
        return $this->execute();
	}

	/**
	 * Obter script DELETE
	 *
	 * @method getDelete
	 * @return Script própria instância
	 * @author Leandro Medeiros
	 * @since  2015-07-08
	 * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
	 */
	public function delete() {
		if ($this->deactiveOnDelete) {
			$this->sql = "UPDATE {$this->table}
					         SET (active = false) 
					       WHERE {$this->table}.{$this->primaryKey} = :id;";
        }
		else {
			$this->sql = "DELETE FROM {$this->table} WHERE {$this->table}.{$this->primaryKey} = :id;";
        }

        return $this->execute();
	}

    /**
     * Obter BLOB
     *
     * <p>Executa uma consulta na tabela e retorna o binário do registro.<p>
     *
     * @method getBlob
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     * 
     * @param  string $field Campo que contém dados binários
     * @param  string $where Condições da consulta
     * @return mixed  Binário
     */
    public function getBlob($field, $where) {
        $query = "SELECT {$field} FROM {$this->Script->table} WHERE {$where};";

        $statement = Database::prepare($query);
        $statement->execute();
        $statement->bindColumn(1, $blob, PDO::PARAM_LOB);
        $statement->fetch(PDO::FETCH_BOUND);

        return $blob;
    }

    protected function log() {
        if (Config::LOG_QUERIES) {
            $log = sprintf("\nScript:\n%s\n\nParametros:\n%s", $this->sql, print_r($this->args, true));
            Lib::log($log, false, '_script');
        }
    }
}