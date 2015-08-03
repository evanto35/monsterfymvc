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

class System {
	/**
	 * Usuário autenticado atualmente
	 * @var User
	 */
	protected $CurrentUser;

	/**
	 * Módulos do Sistema
	 * @var array
	 */
	public $modules = array();

	/**
	 * Abas dos módulos
	 * @var array
	 */
	public $tabs = array();

	/**
	 * Módulos do usuário autenticado
	 * @var array
	 */
	public $userModules = array();

	/**
	 * <h1>Armazenar</h1>
	 *
	 * @method selfStore
	 * @return System Própria Instância
	 * @author Leandro Medeiros
	 * @since  2015-07-10
	 * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
	 */
	protected function selfStore() {
		$_SESSION[Config::IDX_SYSTEM] = serialize($this);

		return $this;
	}

	/**
	 * <h1>Obter Armazenado</h1>
	 *
	 * @author Leandro Medeiros
	 * @since  2015-07-10
	 * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
	 * 
	 * @method get
	 * @param  boolean $forceRefresh Forçar Atualização
	 * @return System Própria Instância
	 */
	public static function getStored($forceRefresh = false) {
		if (!$forceRefresh && isset($_SESSION[Config::IDX_SYSTEM]))
			return unserialize($_SESSION[Config::IDX_SYSTEM]);
		else
			return new System();
	}
	
	/**
	 * <h1>Construtor</h1>
	 *
	 * @method __construct
	 * @return System Nova Instância
	 * @author Leandro Medeiros
	 * @since  2015-07-10
	 * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
	 */
	protected function __construct() {
		$this->CurrentUser = User::getLogged();

		return $this->refreshAll();
	}
	
	/**
	 * <h1>Atualizar Tudo</h1>s
	 *
	 * @method refreshAll
	 * @return System Própria Instância
	 * @author Leandro Medeiros
	 * @since  2015-07-10
	 * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
	 */
	protected function refreshAll() {
		return $this->refreshModules()
					->refreshTabs()
					->refreshUserModules()
					->selfStore();
	}

	protected function refreshUserModules() {
		$Script = new Script(new BaseDTO());
		$Script->sql = 'SELECT user_module.module_id
						  FROM user_module
						  JOIN module ON (user_module.module_id = module.id)
						 WHERE user_module.user_id = :userId
					  ORDER BY module.menu_order';
		$Script->addArgument('userId', $this->CurrentUser->id);
		$Script->execute();

		foreach($Script->dataset as $element) {
			$id = $element['module_id'];
			$this->userModules[$id] = $this->modules[$id];
		}

		return $this;
	}

	/**
	 * <h1>Atualiza os Módulos</h1>
	 *
	 * @method refreshModules
	 * @return System Própria Instância
	 * @author Leandro Medeiros
	 * @since  2015-07-10
	 * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
	 */
	public function refreshModules() {
		$this->modules = Module::getList();
		return $this;
	}

	/**
	 * <h1>Atualiza as Abas</h1>
	 *
	 * @method refreshTabs
	 * @return System Própria Instância
	 * @author Leandro Medeiros
	 * @since  2015-07-10
	 * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
	 */
	public function refreshTabs() {
		$this->tabs = Tab::getList();
		return $this;
	}
}