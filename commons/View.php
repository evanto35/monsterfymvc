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
 * <h1>View</h1>
 * 
 * <p>Retorno de qualquer requisicão à Controller.</p>
 *
 * @package commons
 * @author  Leandro Medeiros
 * @since   2015-07-08
 * @link    http://bitbucket.org/leandro_medeiros/monsterfymvc
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
     * Aba Atual
     * @var integer
     */
    public $tab = 1;

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
    public function __construct(ModuleDTO $Module) {
        $this->CurrentUser = User::getLogged();
        $this->System      = System::getStored();
        $this->module      = $Module->name;
        $this->menu        = isset($this->System->tabs[$Module->id]) ? $this->System->tabs[$Module->id] : array();

        $this->setTitle($Module->title);
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
     * @param  boolean $jsonResponse Retornar JSON
     * @return null
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function load($data = null, $jsonResponse = false) {
        if (!empty($data)) {
            $this->data = $data;
        }
        if ($jsonResponse || Config::JSON_RESPONSE) {
            BaseController::clearLastArgs();
            echo json_encode($this);
        }
        else {
            require("modules/header.php");
            require("modules/{$this->module}/content.php");
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
}