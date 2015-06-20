<?php

class User extends Base {
    //Status do usuário 
    const USR_INACTIVE   = -2;
    const USR_UNKNOW     = -1;
    const USR_LOGGED     =  0;
    const USR_PW_INVALID = -3;
    const USR_TIMEOUT    = 55;

    public $id = 0;
    public $name;
    public $email;

    public function __construct(DBConnection $DB, $arrData = null, $executeParent = true){
        if ($executeParent === true) {
            parent::__construct($DB, new User($DB, null, false), $arrData);
        }
    }

    final static function login($user, $passwd) {   
        $passwd = md5($passwd);
        $DB     = DBConnection::getInstance();
        
        try {
        	$result = $DB->fetch(Table::USER, 'id, name, email', "email = '$user' AND password = '$passwd'");

            if (empty($result)) return false;
            else                return (is_array($result))
                                        ? self::handleLoginResult($DB, $result[0])
                                        : self::USR_TIMEOUT;
        }
        catch (Exception $e) {
            self::logout($e->getMessage());
        }
    }

    final private static function handleLoginResult(DBConnection $DB, $result) {
        if (!isset($result['id']) || $result['id'] == '') {
            return self::USR_UNKNOW;
        }                
        else {
            $Logged = new User($DB, $result);

            if (isset($_SESSION[ControllerBase::IDX_LAST_LOGGED]) &&
                ($Logged->id != $_SESSION[ControllerBase::IDX_LAST_LOGGED]))
            {
                session_unset();
            }

            self::setLogged($Logged);
            $_SESSION[ControllerBase::IDX_LAST_LOGGED] = $Logged->id;

            return self::USR_LOGGED;
        }
    }

    final static function logout($loginMsg = null, $redirect = true) {
        if (!isset($_SESSION[ControllerBase::IDX_LOGIN_MSG]) && empty($loginMsg))
            $loginMsg = $_SESSION[ControllerBase::IDX_LOGIN_MSG];

        session_unset();

        if ($loginMsg) $_SESSION[ControllerBase::IDX_LOGIN_MSG] = $loginMsg;

        if ($redirect) header('Location: ./');
    }

    final static function setLogged($User) {
        $_SESSION[ControllerBase::IDX_LOGGED] = serialize($User);
    }

    final static function hasLogged() {
        return isset($_SESSION[ControllerBase::IDX_LOGGED]);
    }	

    final static function getLogged() {
        if (!self::hasLogged()) return false;
        
        return unserialize($_SESSION[ControllerBase::IDX_LOGGED]);
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