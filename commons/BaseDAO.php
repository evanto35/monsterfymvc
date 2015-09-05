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
 * Classe base para uma DAO
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
     * Construtor
     *
     * @method __construct
     * @param  BaseDTO $Dto Instância de DTO para configurar o DAO
     * @return null
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function __construct(BaseDTO $Dto, $tableName = '') {
        $this->instanceClass = get_class($this);

        if (empty($tableName)) {
            $tableName = strtolower($this->instanceClass);
        }

        $this->Script = new Script($tableName);
        $this->setDto($Dto);

        if (!$this instanceof User) {
            $this->CurrentUser = User::getLogged();
        }
    }

    /**
     * Setter
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

        else {
            return null;
        }
    }

    /**
     * Setter do DTO
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
     * Inserir novo registro
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
     * Atualizar Registro
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
     * Salvar
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
     * Obter Lista
     *
     * @method getList
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   Repositório http:/bitbucket.org/leandro_medeiros/monsterfymvc
     * 
     * @param  BaseDTO $Dto         Instância DTO
     * @param  string  $conditions  Condições para a consulta
     * @return array
     */
    public function getList($conditions = null, $order = null, $resultIndex = 'id') {
        if (!empty($conditions)) {
            $this->Script->where($conditions);
        }

        if (!empty($order)) {
            $this->Script->order($order);
        }
        
        if (!$this->Script->execute()) {
            return array();
        }
        
        $list = array();
        foreach($this->Script->dataset as $element) {
            $idx = $element[$resultIndex];
            $dto = get_class($this->Dto);
            $dto = new $dto;

            if ($resultIndex != 'id') {
                $list[$idx][] = Lib::datasetToDto($dto, $element);
            }
            else {
                $list[$idx] = Lib::datasetToDto($dto, $element);
            }
        }

        return $list;
    }
}