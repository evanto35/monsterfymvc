<?php
#############################################################################
##																		   ##
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
	 * Armazenar
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
	 * Obter Armazenado
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
	 * Construtor
	 *
	 * @method __construct
	 * @return System Nova Instância
	 * @author Leandro Medeiros
	 * @since  2015-07-10
	 * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
	 */
	protected function __construct() {
		$this->CurrentUser = User::getLogged();
		$this->refreshAll();

		return $this;
	}
	
	/**
	 * Atualizar Tudos
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

	/**
	 * Atualiza os Módulos
	 *
	 * @method refreshModules
	 * @return System Própria Instância
	 * @author Leandro Medeiros
	 * @since  2015-07-10
	 * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
	 */
	public function refreshModules() {
		$this->modules = new Module(new ModuleDTO);
		$this->modules = $this->modules->getList();

		return $this;
	}

	/**
	 * Atualiza as Abas
	 *
	 * @method refreshTabs
	 * @return System Própria Instância
	 * @author Leandro Medeiros
	 * @since  2015-07-10
	 * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
	 */
	public function refreshTabs() {
		$this->tabs = new Tab(new TabDTO);
		$this->tabs = $this->tabs->getList();

		return $this;
	}

	protected function refreshUserModules() {
		$Script = new Script('user_module');
		
		$Script->select('module_id')
			   ->where('user_id = :userId', $this->CurrentUser->id)
			   ->execute();

		foreach($Script->dataset as $element) {
			$id = $element['module_id'];
			$this->userModules[$id] = $this->modules[$id];
		}

		return $this;
	}
}