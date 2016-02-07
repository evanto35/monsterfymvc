<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "module"
 * in 2016-01-25
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package models
 *
 */

class Module extends Lumine_Base {

    
    public $id;
    public $active;
    public $title;
    public $name;
    public $menuOrder;
    public $icon;
    public $action = array();
    public $groupmodules = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('module');
        $this->metadata()->setPackage('models');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 10, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->metadata()->addField('active', 'active', 'boolean', 1, array('notnull' => true, 'default' => '1'));
        $this->metadata()->addField('title', 'title', 'varchar', 100, array('notnull' => true));
        $this->metadata()->addField('name', 'name', 'varchar', 45, array('notnull' => true, 'default' => 'module'));
        $this->metadata()->addField('menuOrder', 'menu_order', 'int', 10, array('notnull' => true));
        $this->metadata()->addField('icon', 'icon', 'varchar', 45, array('notnull' => true, 'default' => ''));

        
        $this->metadata()->addRelation('action', Lumine_Metadata::ONE_TO_MANY, 'Action', 'moduleId', null, null, null);
        $this->metadata()->addRelation('groupmodules', Lumine_Metadata::ONE_TO_MANY, 'GroupModule', 'moduleId', null, null, null);
    }

    #### END AUTOCODE

    /**
     * Recupera registros da tabela
     *
     * @author Leandro Medeiros <leandro.medeiros@live.com>
     * @since  2016-01-29
     * 
     * @param  array      $filters  Filtros
     * @return array
     */
    public function getList(array $filters = null) {
        if (!empty($filters)) Lib::applyFilters($this, $filters);

        $result = array();

        $this->alias('l')
             ->selectAs()
             ->order('menuOrder')
             ->find();

        while ($this->fetch()) {
            $result[$this->id] = $this->toObject('%s', null, true);
        }

        return $result;
    }
}
