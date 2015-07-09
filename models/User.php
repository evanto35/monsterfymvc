<?php

/**
 * <h1>DAO do Usuário</h1>
 * 
 * @author Leandro Medeiros
 * @since  2015-07-08
 * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
 */
class User extends BaseDAO {
    //Status do usuário 
    const USR_INACTIVE   = -2;
    const USR_UNKNOW     = -1;
    const USR_LOGGED     =  0;
    const USR_PW_INVALID = -3;
    const USR_TIMEOUT    = 55;

    final public function __construct(UserDTO $Dto) {
        parent::__construct($Dto);
    }

    final static function login($user, $passwd) {   
        $passwd = md5($passwd);
        $Script = new Script(new UserDTO());
        $Script->table = 'user';
        
        try {
            $Script->getSelect()
                   ->where('email = :user')
                   ->where('password = :passwd')
                   ->addArgument('user', $user)
                   ->addArgument('passwd', $passwd);

            if ($Script->execute())
                return self::handleLoginResult($Script);
            else
                return self::USR_UNKNOW;
        }
        catch (Exception $e) {
            self::logout($e->getMessage());
        }
    }
    
    final private static function handleLoginResult(Script $Script) {
        $Dto = new UserDTO();

        Lib::datasetToDto($Dto, $Script->dataset[0]);
        
        if (empty($Dto->id)) {
            return self::USR_UNKNOW;
        }

        $Logged = new User($Dto);

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
        return $this->Dto->name;
    }
}