<?php

class Controller {
    /**
     * @var object
     * responsável por armazenar a instância do Usuário atual logado
     */
    public $User;

    /**
     * @var object 
     * responsável por armazenar a instância de SubController correta,
     * seja de um médico ou operador
     */
    public $Module;    

    /**
     * Indices de sessão
     */
    const IDX_LAST_ARGS   = 'idx_00';
    const IDX_LOGGED      = 'idx_01';
    const IDX_LAST_LOGGED = 'idx_02';
    const IDX_LOGIN_MSG   = 'idx_03';


    /**
     * Construtor
     */
    public function __construct() {
        if (!User::hasLogged()) $this->handleLoginRequest();
        else                    $this->managePost();
    }

    private function managePost() {
        if ($_POST and isset($_POST['action'])) $_SESSION[self::IDX_LAST_ARGS] = serialize($_POST);
        unset($_POST);

        $arguments = self::getLastArgs();
        $hasAction = isset($arguments['action']) && ($arguments['action'] != '');

        $this->defineSubController($arguments);
        
        if ($hasAction) $this->Module->action($arguments);
        else            $this->Module->showMainPage();
    }	

    public static function getLastArgs() {
        return isset($_SESSION[self::IDX_LAST_ARGS]) ? unserialize($_SESSION[self::IDX_LAST_ARGS]) : array();
    }

    public static function clearLastArgs() {
        unset($_SESSION[self::IDX_LAST_ARGS]);
    }

    private function handleLoginRequest() {

        if (!$_POST && !isset($_POST['action'])) {
            View::loadLogin();
        }

        else {
            switch ($_POST['action']) {              
                case 'login':                                                                                       
                    $this->login($_POST);                                                         
                break;
                
                default:                                                                                            
                    $_SESSION[self::IDX_LOGIN_MSG] = Alert::MSG_SYSTEM_LOGIN_ERROR;
                   
                    unset($_POST);
                    View::loadLogin();                                                          
                break;
            }

            unset($_POST);
        }
    }

    private function login($args) {

        if (!isset($args['username']) || !isset($args['password'])) {
            $_SESSION[self::IDX_LOGIN_MSG] = Alert::MSG_USER_FIELDS;
        }
        else {
            $status = User::login($args['username'], $args['password']);

            switch ($status) {
                case User::USR_LOGGED:                     
                break;
                
                case User::USR_INACTIVE:
                    $_SESSION[self::IDX_LOGIN_MSG] = Alert::MSG_LOGIN_INACTIVE;
                break;
                        
                case User::USR_UNKNOW:
                case User::USR_PW_INVALID:
                    $_SESSION[self::IDX_LOGIN_MSG] = Alert::MSG_LOGIN_WRONG_PASS;
                break;

                case User::USR_TIMEOUT:
                    $_SESSION[self::IDX_LOGIN_MSG] = Alert::MSG_LOGIN_TIMEOUT;
                break;
                
                default:
                    $_SESSION[self::IDX_LOGIN_MSG] = Alert::MSG_SYSTEM_CONNECTION_OUT;
                break;
            }
        }
     
        header('Location: index.php');
    }

    private function defineSubController($arguments) {
        $this->User = User::getLogged();

        if (isset($arguments['module'])) {
            if ($arguments['module'] == '' || !class_exists($arguments['module'] . 'Controller')) {
                unset($arguments['module']);
                $_SESSION[self::IDX_LAST_ARGS] = serialize($arguments);
            }
            else {                
                $module = $arguments['module'] . 'Controller';
            }
        }

        if (!is_object($this->User))    User::logout(Alert::MSG_LOGIN_UNKNOWN_ERROR);
        else if (isset($module))        $this->Module = new $module($this->User);  
        else                            $this->Module = new ScheduleController($this->User); 
    }        
}