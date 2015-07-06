<?php

class User extends BaseModel {
    //Status do usuário 
    const USR_INACTIVE   = -2;
    const USR_UNKNOW     = -1;
    const USR_LOGGED     =  0;
    const USR_PW_INVALID = -3;
    const USR_TIMEOUT    = 55;

    public $id = 0;
    public $name;
    public $email;
    public $admin = false;

    final static function login($user, $passwd) {   
        $passwd = md5($passwd);
        $DB     = new Database();
        
        try {
            $DB->addArgument('user', $user);
            $DB->addArgument('passwd', $passwd);

            if ($DB->execute(Query::USER_GEY_BY_LOGIN))
                return self::handleLoginResult($DB);
            else
                return self::USR_UNKNOW;
        }
        catch (Exception $e) {
            self::logout($e->getMessage());
        }
    }

    final private static function handleLoginResult(Database $DB) {
        $DB->dataset = $DB->dataset[0];
        
        if (!isset($DB->dataset['id']) || $DB->dataset['id'] == '') {
            return self::USR_UNKNOW;
        }

        $Logged = new User();
        $Logged->id     = $DB->dataset['id'];
        $Logged->name   = $DB->dataset['name'];
        $Logged->email  = $DB->dataset['email'];
        $Logged->admin  = $DB->dataset['admin'];

        if (isset($_SESSION[BaseController::IDX_LAST_LOGGED]) &&
            ($Logged->id != $_SESSION[BaseController::IDX_LAST_LOGGED]))
        {
            session_unset();
        }

        self::setLogged($Logged);

        return self::USR_LOGGED;
    }

    final static function logout($loginMsg = '', $redirect = true) {
        session_unset();

        if ($loginMsg) new Alert($loginMsg);

        if ($redirect) header('Location: ./');
    }

    final static function setLogged(User $User) {
        $_SESSION[BaseController::IDX_LAST_LOGGED] = $User->id;
        $_SESSION[BaseController::IDX_LOGGED] = serialize($User);
    }

    final static function hasLogged() {
        return isset($_SESSION[BaseController::IDX_LOGGED]);
    }	

    final static function getLogged() {
        if (!self::hasLogged()) return false;
        
        return unserialize($_SESSION[BaseController::IDX_LOGGED]);
    }    
   
    public function __toString() {
        return $this->name;
    }
}