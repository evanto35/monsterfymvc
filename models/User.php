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
 * <h1>DAO do Usuário</h1>
 *
 * @package models
 * @author  Leandro Medeiros
 * @since   2015-07-08
 * @link    http://bitbucket.org/leandro_medeiros/monsterfymvc
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