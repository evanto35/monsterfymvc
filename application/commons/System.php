<?php
#############################################################################
##                                                                         ##
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
    public $modules;

    /**
     * Módulos do usuário autenticado
     * @var array
     */
    public $userModules;

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
            return new System(User::getLogged());
    }
    
    /**
     * Construtor
     *
     * @author Leandro Medeiros <leandro.medeiros@live.com>
     * @since  2016-01-27
     * 
     * @param  User       $Logged   Usuário autenticado
     */
    final public function __construct(UserDTO $Logged) {
        $this->CurrentUser = $Logged;
        $this->refreshAll();
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
                    ->refreshActions()
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
        $this->modules = new Module;
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
    public function refreshActions() {
        $this->actions = new Action;
        $this->actions = $this->actions->getList();

        return $this;
    }

    /**
     * Atualiza as permissões
     *
     * @author Leandro Medeiros <leandro.medeiros@live.com>
     * @since  2016-01-29
     * @return System   Própria Instância
     */
    protected function refreshUserModules() {
        $Dao = new GroupModule;

        $Dao->alias('gm')
            ->join(new Action, 'LEFT', 'a', 'moduleId', 'moduleId')
            ->select('gm.moduleId')
            ->select('a.id AS actionId')
            ->where('gm.groupId = ?', $this->CurrentUser->groupId)
            ->find();

        while ($Dao->fetch()) {
            $moduleId = $Dao->moduleId;
            $actionId = $Dao->actionId;

            if (!array_key_exists($moduleId, $this->userModules))
                $this->userModules[$moduleId] = $this->modules[$moduleId];

            if (!empty($actionId))
                $this->userModules[$moduleId]->action[$actionId] = $this->actions[$actionId];
        }

        return $this;
    }
}