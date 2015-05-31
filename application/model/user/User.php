<?php

class User {
    //Status do usuário 
    const USR_INACTIVE   = -2;
    const USR_UNKNOW     = -1;
    const USR_LOGGED     =  0;
    const USR_PW_INVALID = -3;
    const USR_TIMEOUT    = 55;

    //Conexão com o Banco
	protected $DB;

    public $id = 0;
    public $name;

    public function __construct($id, $name) {
        $this->id   = $id;
        $this->name = $name;
        $this->DB   = DBConnection::getInstance();
        $this->getClients();
    }

    final static function login($user, $passwd) {   
        $passwd = md5($passwd);
        $DB     = DBConnection::getInstance();
        
        try {
        	$result = $DB->fetch(Table::USER, 'id, name', "(login = '$user' or email = '$user') AND password = '$passwd'");

            if (empty($result)) return false;
            else                return (is_array($result))
                                        ? self::handleLoginResult($result[0])
                                        : self::USR_TIMEOUT;
        }
        catch (Exception $e) {
            self::logout($e->getMessage());
        }
    }

    final private static function handleLoginResult($result) {
        if (!isset($result['id']) || $result['id'] == '') {
            return self::USR_UNKNOW;
        }                
        else {
            $Logged = new User($result['id'], $result['nome']);

            if (isset($_SESSION[Controller::IDX_LAST_LOGGED]) &&
                ($Logged->id != $_SESSION[Controller::IDX_LAST_LOGGED]))
            {
                session_unset();
            }

            self::setLogged($Logged);
            $_SESSION[Controller::IDX_LAST_LOGGED] = $Logged->id;

            return self::USR_LOGGED;
        }
    }

    final static function logout($loginMsg = null, $redirect = true) {
        session_unset();

        if ($loginMsg) $_SESSION[Controller::IDX_LOGIN_MSG] = $loginMsg;

        if ($redirect) header('Location: index.php');
    }

    final static function setLogged($User) {
        $_SESSION[Controller::IDX_LOGGED] = serialize($User);
    }

    final static function hasLogged() {
        return isset($_SESSION[Controller::IDX_LOGGED]);
    }	

    final static function getLogged() {
        if (!self::hasLogged()) return false;
        
        return unserialize($_SESSION[Controller::IDX_LOGGED]);
    }    
   
    public function __toString() {
        return $this->name;
    }

    public function __sleep() {
        return array('id', 'name');
    }

    public function __wakeup() {
        $this->DB = DBConnection::getInstance();
    }
}