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
 * <h1>Classe base para uma DAO</h1>
 * 
 * <p>Todas as models da aplicação devem estender esta.</p>
 *
 * @package commons
 * @author  Leandro Medeiros
 * @since   2015-07-08
 * @link    http://bitbucket.org/leandro_medeiros/monsterfymvc
 */
abstract class BaseDAO {
	/**
     * Classe da instância
     * @var string
     */
    protected $instanceClass;
    /**
     * Scripts correspondentes ao DAO
     * @var Script
     */
	protected $Script;
	/**
     * Usuário Autenticado
     * @var User
     */
	private $CurrentUser;
    /**
     * DTO Base
     * @var BaseDTO
     */
    protected $Dto;

    /**
     * <h1>Construtor</h1>
     *
     * @method __construct
     * @param  BaseDTO $Dto Instância de DTO para configurar o DAO
     * @return null
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function __construct(BaseDTO $Dto, $tableName = '') {
        $this->instanceClass   = get_class($this);
        $this->Script          = new Script($Dto);

        if (empty($tableName)) {
            $this->Script->table = strtolower($this->instanceClass);
        }
        else {
            $this->Script->table = $tableName;
        }

        $this->setDto($Dto);

        if (!$this instanceof User) {
            $this->CurrentUser = User::getLogged();
        }
    }

    /**
     * <h1>Setter</h1>
     * 
     * <p>Valida antes de atribuir as propriedades privadas</p>
     *
     * @method __set
     * @param  string $property Nome da Propriedade
     * @param  mixed  $newValue Valor da Propriedade
     * @return Própria instância
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function __set($property, $newValue) {
        switch ($property) {
            case 'Script':
                if (!$newValue instanceof Script) {
                    throw new Exception("Objeto inválido");
                }
                $this->$property = $newValue;
                break;
            
            case 'CurrentUser':
                if (!$newValue instanceof User) {
                    throw new Exception("Objeto inválido");
                }
                $this->$property = $newValue();
                break;

            case 'Dto':
                $this->setDto($newValue);
                break;
            
            default:
                break;
        }

        return $this;
    }

    public function __get($property) {
        if (property_exists($this->instanceClass, $property)) {
            return $this->$property;
        }

        else if (property_exists(get_class($this->Dto), $property)) {
            return $this->Dto->$property;
        }
    }

    /**
     * <h1>Setter do DTO</h1>
     *
     * @method setDto
     * @param  BaseDTO $Dto DTO correspondente ao DAO
     * @return BaseDAO Própria instância
     * @author Leandro Medeiros
     * @since  2015-07-08
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function setDto($Dto) {
        if (get_class($Dto) === (get_class($this) . 'DTO')) {
            $this->Dto = $Dto;
        }

        return $this;
    }

    /**
     * <h1>Inserir novo registro</h1>
     *
     * @method insert
     * @return boolean Sucesso
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    protected function insert() {
        return $this->Script->getInsert()
                            ->setArguments($this->Dto)
                            ->execute();
    }

    /**
     * <h1>Atualizar Registro</h1>
     *
     * @method update
     * @return boolean Sucesso
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    protected function update() {
        return $this->Script->getUpdate()
                            ->setArguments($this->Dto)
                            ->execute();
    }

    /**
     * <h1>Salvar</h1>
     * 
     * <p>Salva os dados obtidos do DTO no banco de dados. Se
     * a chave primária estiver setada executa um UPDATE, senão
     * executa um INSERT.</p>
     *
     * @method save
     * @return boolean Sucesso
     * @author Leandro Medeiros
     * @since  2015-07-08
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function save() {
        if (empty($this->Dto->id)) {
            return $this->insert();
        }
        else {
            return $this->update();
        }
    }

    /**
     * <h1>Select</h1>
     *
     * <p>Executa uma consulta na tabela correspondente ao DAO.</p>
     *
     * @method select
     * @param  string $conditions Condições para WHERE
     * @return array Resultado da consulta
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function select($conditions) {
        $resetDto = false;

        $this->Script->getSelect();

        if (!empty($conditions)) {
            $this->Script->where($conditions);
        }

        else if (!empty($this->Dto->id)) {
            $resetDto = true;
            $this->Script->where()
                         ->limit(1);
        }

        else {
            $this->Script->where("$this->Script->table.active");
        }

        $result = $this->Script->setArguments($this->Dto)
                               ->execute();

        if ($result && $resetDto) {
            Lib::datasetToDto($this->Dto, $this->Script->dataset[0]);
        }

        return $result;
    }

    /**
     * <h1>Obter Lista</h1>
     *
     * @method getList
     * @param  BaseDTO $Dto         Instância DTO
     * @param  string  $conditions  Condições para a consulta
     * @return array Lista
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public static function getList(BaseDTO $Dto, $conditions = '', $order = '', $resultIndex = 'id') {
        $dtoClass      = get_class($Dto);
        $Script        = new Script($Dto);
        $Script->table = strtolower(preg_replace('/DTO$/', '', $dtoClass));
        $list          = array();
        
        if ($Script->getSelect()->where($conditions)->order($order)->execute()) {
            foreach($Script->dataset as $element) {
                $idx = $element[$resultIndex];

                if ($resultIndex != 'id') {
                    $list[$idx][] = Lib::datasetToDto(new $dtoClass(), $element);
                }
                else {
                    $list[$idx] = Lib::datasetToDto(new $dtoClass(), $element);
                }
            }
        }

        return $list;
    }
}