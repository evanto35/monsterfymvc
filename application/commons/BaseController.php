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
 * Controller base do Monsterfy
 * 
 * <p>Todas as Controllers da aplicação devem estender esta.</p>
 *
 * @package commons
 * @author  Leandro Medeiros
 * @since   2015-07-09
 * @link    http://bitbucket.org/leandro_medeiros/monsterfymvc
 */
abstract class BaseController {
    /**
     * Usuário loggado
     * @var User
     */
    protected $CurrentUser;

    /**
     * Dados comuns ao sistema
     * @var System
     */
    protected $System;

    /**
     * Instância da View correspondente
     * @var View
     */
    protected $View;

    /**
     * Id do módulo correspondente à Controller
     * @var string
     */
    public static $moduleId = 0;

    /**
     * Exibir Navegador
     * @var boolean
     */
    protected static $showNavigator = true;

    /**
     * Construtor
     *
     * <p>Se não houver usuário autenticado exibe a tela de login,
     * caso contrário processa a requisição.</p>
     *
     * @method __construct
     * @return null
     * @see    /commons/BaseController/handleRequest
     * @see    /commons/BaseController/handleLoginRequest
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function __construct() {
        $arguments = $this->getRequest();

        if (!User::hasLogged()) {
            $this->login($arguments);
        }
        else {
            $this->CurrentUser = User::getLogged();
            $this->System      = System::getStored();

            if ($this->setView()) {
                $this->action($arguments);
            }
            else {
                new Alert(Alert::MSG_MODULE_ACCESS_DENIED, Alert::ERROR);
                Config::home();
            }
        }
    }

    /**
     * Obter Requisição
     *
     * <p>Armazena na sesão os argumentos da requisição (para reprocessar
     * em caso de erro) e limpa superglobal.</p>
     *
     * @method handleRequest
     * @return array Dados da última requisição
     * @see    /commons/BaseController/getLastArgs
     * @see    /commons/BaseController/action
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    private function getRequest() {
        if (!empty($_POST)) {
            $_SESSION[Config::IDX_LAST_ARGS] = serialize($_POST);
            unset($_POST);
        }
        else if (!empty($_GET)) {
            $_SESSION[Config::IDX_LAST_ARGS] = serialize($_GET);
            unset($_GET);
        }
        else if (!empty($_REQUEST)) {
            $_SESSION[Config::IDX_LAST_ARGS] = serialize($_REQUEST);
            unset($_REQUEST);
        }

        return self::getLastArgs();
    }

    /**
     * Obter últimos parâmetros
     *
     * @method getLastArgs
     * @return array Parâmetros da requisição mais recente
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    protected static function getLastArgs() {
        return isset($_SESSION[Config::IDX_LAST_ARGS]) ? unserialize($_SESSION[Config::IDX_LAST_ARGS]) : array();
    }
    
    /**
     * Limpar últimos parâmetros
     *
     * <p>Limpa o histórico de requisicões.</p>
     *
     * @method clearLastArgs
     * @return null
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    protected static function clearLastArgs() {
        unset($_SESSION[Config::IDX_LAST_ARGS]);
    }

    final protected function refreshLoggedUser() {
        User::setLogged($this->CurrentUser);
    }

    /**
     * Exibir Home Page
     *
     * <p>Toda classe filha deve implementar este método para preencher um objeto
     * <code>View</code> e exibí-lo.</p>
     * 
     * @method goHome
     * @return null
     * @see /commons/View/load
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    abstract protected function goHome();

    /**
     * Ação
     *
     * <p>Executa um método da controller de acordo com "action" da requisição e exibe
     * a view. Se o método não existir exibe a Home Page com uma mensagem de erro.</p>
     *
     * @method action
     * @param  array $arguments Argumentos para o método
     * @return null
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    final protected function action($arguments) {
        $requestAction = !empty($arguments['action']) ? $arguments['action'] : null;

        if (!method_exists($this, $requestAction)) {
            if (!empty($requestAction)) {
                new Alert(sprintf(Alert::MSG_SYSTEM_METHOD_FAIL, get_class($this), $requestAction), Alert::ERROR);
            }
            $this->goHome();
        }

        else {
            try {
                $Page = $this->$requestAction($arguments);

                if ($Page instanceof View) {
                    $Page->load();
                }
                else if ($Page instanceof FileDownload) {
                    self::clearLastArgs();
                    $Page->download();
                }
                else if (is_array($Page)) {
                    self::clearLastArgs();
                    echo json_encode($Page);
                }
                else {
                    $this->goHome(true);
                }
            }
            catch (Exception $e) {
                $this->goHome(true);
            }
        }
    }

    /**
     * Obter View
     *
     * @method getView
     * 
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     * 
     * @return View objeto view parametrizado de acordo com instância da Controller
     */
    protected function setView() {
        if (!array_key_exists(static::$moduleId, $this->System->userModules)) {
            return false;
        }

        $Module     = $this->System->userModules[static::$moduleId];
        $this->View = new View($this->CurrentUser, $Module);

        if (static::$showNavigator) {
            $this->View->setNavigator($this->System->userModules);
        }

        return true;
    }

    /**
     * Exibir Tela de Login
     *
     * @method loadLogin
     * @param  string $message Alerta (opcional)
     * @return null
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    private static function loadLogin($message = null) {
        unset($_SESSION[Config::IDX_SYSTEM]);

        require(PATH_MODULE.'login/content.php');
    }

    /**
     * Login
     * 
     * <p>Se conseguir autenticar o usuário exibe a HomePage do
     * módulo, senão exibe a tela de login novamente.</p>
     * 
     * @method login
     * @param  array $args Parâmetros do login
     * @return null
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    protected function login($args) {
        if (empty($args['action']) || $args['action'] != 'login') {
            self::loadLogin();
            die();
        }

        if (!isset($args['username']) || !isset($args['password'])) {
            new Alert(Alert::MSG_USER_FIELDS, Alert::ERROR);
        }
        else {
            $status = User::login($args['username'], $args['password']);

            switch ($status) {
                case User::LOGGED:
                    Config::home();
                break;
                
                case User::INACTIVE:
                    new Alert(Alert::MSG_LOGIN_INACTIVE, Alert::ERROR);
                    self::loadLogin();
                break;
                        
                case User::UNKNOW:
                case User::PW_INVALID:
                    new Alert(Alert::MSG_LOGIN_WRONG_PASS, Alert::ERROR);
                    self::loadLogin();
                break;

                case User::TIMEOUT:
                    new Alert(Alert::MSG_LOGIN_TIMEOUT, Alert::ERROR);
                    self::loadLogin();
                break;
                
                default:
                    new Alert(Alert::MSG_SYSTEM_CONNECTION_OUT, Alert::ERROR);
                    self::loadLogin();
                break;
            }
        }
    }

    /**
     * Logout
     *
     * <p>Finaliza a sesão do usuário e exibe a tela de login.</p>
     *
     * @method logout
     * @return null
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    protected function logout() {
        User::logout(); 
    } 

    /**
     * Adicionar ao Depurador
     *
     * <p>Guarda uma variavél para ser exibido na View</p>
     * <p>Usar apenas para fins de depuração</p>
     *
     * @method debuggingAdd
     * @param  mixed $data Dados de depuração
     * @see    /commons/BaseController/debuggingEcho
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    protected static function debuggingAdd($data) {
        $_SESSION[Config::IDX_DEBUGGING][] = $data;
    }

    /**
     * "Depurar"
     *
     * <p>Exibe todos as variáveis guardadas para depuração</p>
     *
     * @method debuggingEcho
     * @see    /commons/BaseController/debuggingAdd
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public static function debuggingEcho() {
        if (isset($_SESSION[Config::IDX_DEBUGGING])) {
            echo '<pre>';
            print_r($_SESSION[Config::IDX_DEBUGGING]);
            echo '</pre>';
            
            unset($_SESSION[Config::IDX_DEBUGGING]);
        }
    }    
}