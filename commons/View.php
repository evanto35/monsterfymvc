<?php

/**
 * <h1>View</h1>
 * 
 * <p>Retorno de qualquer requisicão à Controller.</p>
 * 
 * @author Leandro Medeiros
 * @since  2015-07-08
 * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
 */
final class View {
    /**
     * Usuário Autenticado
     * @var User
     */
    private $CurrentUser;

    /**
     * Dados do Sistema
     * @var System
     */
    private $System;

    /**
     * Título da Página
     * @var string
     */
    private $title;

    /**
     * Módulo de Origem
     * @var string
     */
    private $module;

    /**
     * Itens da barra de navegação
     * @var array
     */
    private $navigator = array();

    /**
     * Abas do Menu do Módulo
     * @var array
     */
    private $menu = array();

    /**
     * Dados complementares
     * @var mixed
     */
    public $data;

    /**
     * <h1>Getter</h1>
     *
     * @method __get
     * @param  string $property Nome da Propriedade
     * @return mixed Valor da Propriedade (null caso não exista)
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function __get($property) {
        if (property_exists(View, $property)) {
            return $this->$property;
        }

        return null;
    }

    /**
     * <h1>Construtor</h1>
     *
     * @method __construct
     * @param  string $module Módulo de Origem
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function __construct($module) {
        $this->CurrentUser = User::getLogged();
        $this->System      = System::get();
        $this->module      = $module;
    }

    /**
     * <h1>Setter do Título</h1>
     *
     * @method setTitle
     * @param  string $title Título desejado
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function setTitle($title) {
        $this->title = Config::APP_TITLE . (!empty($title) ? (' - ' . $title) : '');            
    }

    /**
     * <h1>Carregar Página</h1>
     *
     * @method load
     * @param  boolean $headerContent Carregar conteúdo do cabeçalho
     * @return void
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function load($headerContent = true) {
        if (Config::JSON_RESPONSE) {
            BaseController::clearLastArgs();
            echo json_encode($this);
        }
        else {
            $View = $this;

            require("modules/header.php");
            if ($headerContent) {
                require("modules/header-content.php");
            }
            require("modules/{$View->module}/view.php");
            require("modules/footer.php");
        }
    }

    /**
     * <h1>Definir Barra de Navegação</h1>
     *
     * @method setNavigator
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function setNavigator($navigator) {
        $this->navigator = $navigator;
    }

    /**
     * <h1>Adicionar Aba</h1>
     *
     * @method addTab
     * @param  Tab $Tab Nova Aba
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function addTab(Tab $Tab) {
        $this->menu[] = $Tab;
    }
}