<?php

/**
 * <h1>Controller do Dashboard</h1>
 * 
 * @author Leandro Medeiros
 * @since  2015-07-09
 * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
 */
class DashboardController extends BaseController {	
    /**
     * Exibir Navegador (override)
     * @var boolean
     */
    protected static $showNavigator = false;

    /**
     * <h1>Exibir HomePage (override)</h1>
     *
     * @method goHome
     * @param  boolean $forceRefresh Forçar atualização dos Dados
     * @return mixed Página
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
	public function goHome($forceRefresh = false) {
        return $this->setTabs($this->getView(Module::getList()))->load();
    }

    /**
     * <h1>Configurar Abas</h1>
     *
     * @method setTabs
     * @param  View $View por referência
     * @return View view atualizada
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function setTabs(View &$View) {
        $View->addTab(new Tab('Módulos', 'goHome', true));

        return $View;
    }
}