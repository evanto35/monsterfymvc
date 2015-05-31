<?php
/**
 * @author  leandromedeiros
 * @package /aplication/model/
 */
class Alert {
    
    /**
     * Constantes referentes aos tipos de tratamento de erro do sistema
     */
    const ERROR   = "-error";
    const WARNING = "";
    const SUCCESS = "-success";
    const OTHER   = "-info";
    const SESSION_INDEX = 'alert';

    /**
     * Constantes referentes aos alertas relacionados ao sistema interno
     */
    const MSG_SYSTEM_ERROR           = '';
    const MSG_SYSTEM_ATTEMPTS        = '';
    const MSG_SYSTEM_LOGIN_ERROR     = 'Sessão inválida/expirada';
    const MSG_SYSTEM_EXPIRED_SESSION = 'Sua sessão expirou, faça login novamente';
    const MSG_SYSTEM_CONNECTION_OUT  = 'Erro de conexão ao servidor. Tente novamente dentro de instantes';
    const MSG_SYSTEM_METHOD_FAIL     = 'Falha ao processar requisição: O método <strong>%s->%s</strong> não existe.';

    /**
     * Constantes referentes aos alertas relacionados ao login
     */
    const MSG_LOGIN_UNKNOWN_ERROR    = 'Ocorreu um erro e não foi possivel prosseguir';
    const MSG_LOGIN_INVALID_USER     = 'Tipo de usuário inválido.';
    const MSG_LOGIN_INACTIVE         = 'Seu usuário foi desativado. Entre em contato com o administrador do sistema';
    const MSG_LOGIN_WRONG_PASS       = 'Usuário/senha incorreto';
    const MSG_LOGIN_TIMEOUT          = 'Tempo limite excedido, tente novamente em instantes';

    /**
     * Constantes referentes aos alertas relacionados aos usuários
     */
    const MSG_USER_EMPTY            = 'Não há usuários cadastrados';
    const MSG_USER_FIELDS           = 'Informe os campos corretamente';
    const MSG_USER_GET_INFO_FAIL    = 'Falha ao obter dados do usuário autenticado. Por favor tente novamente.';
    const MSG_USER_INVALID_TYPE     = 'Tipo de usuário inválido.';

    /**
     * @var integer
     * identificador do alerta
     */
    public $id;

    /**
     * @var string
     * mensagem que será exibida no alerta
     */
    public $text;

    /**
     * @var string
     * tipo do alerta (erro, sucesso, info...)
     */
    public $type;

    /**
     * @var boolean
     * flag utilizada para saber se o ícone para fechar o alerta será exibido ou não
     */
    public $showIcon;

    public function __construct($text, $type = self::OTHER, $id = 0, $showIcon = true) {
        $this->text = $text;
        $this->type = $type;
        $this->showIcon = $showIcon;
        
        if ($id) $this->id = $id; 
        else     $this->id = '';

        $_SESSION[self::SESSION_INDEX][] = serialize($this);
    }

    private function __sleep() {
        return array('text', 'type', 'id', 'showIcon');
    }

    public static function echoAlert($text, $type, $id, $showIcon) {
        echo "<div style='height: 20px;' id='{$id}' class='alert alert" 
             . $type 
             . " fade in'>"
             . $text 
             . ($showIcon ? "<button class='close' data-dismiss='alert' href='#'>&times;</a>" : "")
             . "</div>";
    }

    public static function echoAll($unset = true) {
        if (isset($_SESSION[self::SESSION_INDEX])) {

            foreach($_SESSION[self::SESSION_INDEX] as $Alert) {
                $Alert = unserialize($Alert);
                self::echoAlert($Alert->text, $Alert->type, $Alert->id, $Alert->showIcon);
            }       
        }

        if ($unset) unset($_SESSION[self::SESSION_INDEX]);
    }
}