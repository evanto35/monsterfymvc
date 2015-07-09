<?php

/**
 * <h1>Classe base para uma DAO</h1>
 * 
 * <p>Todas as models da aplicação devem estender esta.</p>
 * 
 * @author Leandro Medeiros
 * @since  2015-07-08
 * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
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
     * @return void
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function __construct(BaseDTO $Dto) {
        $this->instanceClass   = get_class($this);
        $this->Script          = new Script($Dto);
        $this->Script->table   = strtolower($this->instanceClass);
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
            $this->Script->where()->limit(1);
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
    public static function getList(BaseDTO $Dto, $conditions = '') {
        $dtoClass      = get_class($Dto);
        $Script        = new Script($Dto);
        $Script->table = strtolower(preg_replace('/DTO$/', '', $dtoClass));
        $list          = array();
        
        if ($Script->getSelect()->where($conditions)->execute()) {
            foreach($Script->dataset as $element) {
                $list[] = Lib::datasetToDto(new $dtoClass(), $element);
            }
        }

        return $list;
    }
}