<?php

/**
 * Classe abastrata que é extendida pelas controladoras de tipo de usuário.
 * Ou seja, todos os métodos aqui implementados serão acessados pelas controladoras filhas (Exemplo: self, self)
 */

abstract class SubController {

    /**
     * Constantes referentes as paginas que serao chamadas nas Actions()
     */
    const PAGE_LIST = 'home';

    protected $CurrentUser;
    protected $currentAction;   

    public static $MODULE = Module::DEFAULT_MODULE;

    public function __construct($User) {
        $this->CurrentUser = $User;
    }

    protected function getView($fileName) {
        return strtolower(static::$MODULE) . '/' . $fileName;
    }

    protected function refreshLoggedUser() {
        User::setLogged($this->CurrentUser);
    }

    protected function returnPage($arguments) {
        return false;   
    }

    /**
     * @author Leandro Medeiros
     *
     * Método responsável por fazer a chamada das funções.
     * Pelo fato do método ser genérico, existe 3 possíveis tipos de retorno, são eles:
     * Booleano, objeto PageContent, string JSON.
     * O retorno booleano ocorre quando não é preciso realizar mudança de estado da view, apenas atualizá-la
     * O retorno objeto PageContent ocorre quando, após a execução da função, haverá uma chamada de uma view.
     * O retorno JSON ocorre quando a requisição é feita em ajax, e após sua execução, precisamos manipular a view.
     *
     * @var string $postAction 
     * recebe o valor armazenanado na variável de sessão 'POST', contendo o método solicitado, sendo uma requisição AJAX ou não.
     *
     * @var string $page recebe o retorno da chamada de função
     */
    final public function action($arguments) {
        
        $postAction = isset($arguments['action']) ? $arguments['action'] : null;

        if (!method_exists($this, $postAction)) {
            if ($postAction) new Alert(sprintf(Alert::MSG_SYSTEM_METHOD_FAIL, get_class($this), $postAction), Alert::ERROR);
            $this->showMainPage();
        }

        else {
            $page = $this->$postAction($arguments);

            try {
                if (is_string($page)) {
                    Controller::clearLastArgs();
                    echo $page;
                }
                
                else if (is_bool($page)) {
                    Controller::clearLastArgs();
                    $this->showMainPage($page);
                }
                
                else if (get_class($page) == 'PageContent') {
                    $page->CurrentUser = $this->CurrentUser;
                    View::loadPage($page);
                }

                else if (get_class($page) == 'FileDownload') {
                    Controller::clearLastArgs();
                    $page->download();
                }
            }
            catch (Exception $e) {
                $this->showMainPage(true);
            }
        }
    }    

    abstract public function showMainPage();

    protected function logout($arguments) {
        User::logout(); 
    } 
}