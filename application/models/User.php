<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "user"
 * in 2016-01-25
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package models
 *
 */

class User extends Lumine_Base {

    
    public $id;
    public $corporationId;
    public $groupId;
    public $active;
    public $email;
    public $password;
    public $name;
    public $annotation = array();
    public $client = array();
    public $clientaddress = array();
    public $clientphones = array();
    public $services = array();
    public $services1 = array();
    public $action = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('user');
        $this->metadata()->setPackage('models');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 10, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->metadata()->addField('corporationId', 'corporation_id', 'int', 11, array('notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Corporation'));
        $this->metadata()->addField('groupId', 'group_id', 'int', 11, array('notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Groups'));
        $this->metadata()->addField('active', 'active', 'boolean', 1, array('notnull' => true, 'default' => '1'));
        $this->metadata()->addField('email', 'email', 'varchar', 100, array('notnull' => true));
        $this->metadata()->addField('password', 'password', 'char', 32, array('notnull' => true));
        $this->metadata()->addField('name', 'name', 'varchar', 45, array('notnull' => true));

        
        $this->metadata()->addRelation('annotation', Lumine_Metadata::ONE_TO_MANY, 'Annotation', 'userIdInsert', null, null, null);
        $this->metadata()->addRelation('client', Lumine_Metadata::ONE_TO_MANY, 'Client', 'userIdInsert', null, null, null);
        $this->metadata()->addRelation('clientaddress', Lumine_Metadata::ONE_TO_MANY, 'ClientAddress', 'userIdInsert', null, null, null);
        $this->metadata()->addRelation('clientphones', Lumine_Metadata::ONE_TO_MANY, 'ClientPhone', 'userIdInsert', null, null, null);
        $this->metadata()->addRelation('services', Lumine_Metadata::ONE_TO_MANY, 'Service', 'userIdFinished', null, null, null);
        $this->metadata()->addRelation('services1', Lumine_Metadata::ONE_TO_MANY, 'Service', 'userIdInsert', null, null, null);
        $this->metadata()->addRelation('action', Lumine_Metadata::MANY_TO_MANY, 'Action', 'id', 'user_action', 'user_id', null);
    }

    #### END AUTOCODE

    # Status do usuário 
    const INACTIVE   = -2;
    const UNKNOW     = -1;
    const LOGGED     =  0;
    const PW_INVALID = -3;
    const TIMEOUT    = 55;

    final static function login($user, $passwd) {   
        $passwd = md5($passwd);
        
        try {
            $Dao = new self;

            $Dao->where('{email}    = ?', $user)
                ->where('{password} = ?', $passwd)
                ->where('{active}');

            if ($Dao->find(true))
                return self::handleLoginResult($Dao);
            else
                return self::UNKNOW;
        }
        catch (Exception $e) {
            self::logout($e->getMessage());
        }
    }
    
    final private static function handleLoginResult(User $User) {
        if (empty($User->id)) {
            return self::UNKNOW;
        }

        if (isset($_SESSION[Config::IDX_LAST_LOGGED]) &&
            ($User->id != $_SESSION[Config::IDX_LAST_LOGGED]))
        {
            session_unset();
        }

        self::setLogged($User);

        return self::LOGGED;
    }

    final static function logout($loginMsg = '', $redirect = true) {
        session_unset();

        if ($loginMsg) new Alert($loginMsg);

        if ($redirect) Config::home();
    }

    final static function setLogged(User $User) {
        $User = $User->toObject();
        $_SESSION[Config::IDX_LAST_LOGGED] = $User->id;
        $_SESSION[Config::IDX_LOGGED]      = serialize($User);
    }

    final static function hasLogged() {
        return isset($_SESSION[Config::IDX_LOGGED]);
    }   

    final static function getLogged() {
        if (!self::hasLogged()) return false;
        
        return unserialize($_SESSION[Config::IDX_LOGGED]);
    }    
   
    public function __toString() {
        return $this->name;
    }

    /**
     * Recupera registros da tabela
     *
     * @author Leandro Medeiros <leandro.medeiros@live.com>
     * @since  2016-01-29
     * 
     * @param  array      $filters  Filtros
     * @return array
     */
    public function getList(array $filters = null) {
        $Dao = new self;

        if (!empty($filters)) Lib::applyFilters($Dao, $filters);

        $result = array();

        $Dao->alias('l')
            ->selectAs()
            ->order('name')
            ->find();

        while ($Dao->fetch()) {
            $result[$Dao->id] = $Dao->toObject();
        }

        return $result;
    }
}
