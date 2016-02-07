<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "action"
 * in 2016-01-25
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package models
 *
 */

class Action extends Lumine_Base {

    
    public $id;
    public $active;
    public $moduleId;
    public $title;
    public $action;
    public $menuOrder;
    public $useres = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('action');
        $this->metadata()->setPackage('models');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 10, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->metadata()->addField('active', 'active', 'boolean', 1, array('notnull' => true, 'default' => '1'));
        $this->metadata()->addField('moduleId', 'module_id', 'int', 10, array('notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'CASCADE', 'linkOn' => 'id', 'class' => 'Module'));
        $this->metadata()->addField('title', 'title', 'varchar', 45, array('notnull' => true));
        $this->metadata()->addField('action', 'action', 'varchar', 45, array('notnull' => true));
        $this->metadata()->addField('menuOrder', 'menu_order', 'int', 10, array('notnull' => true));

        
        $this->metadata()->addRelation('useres', Lumine_Metadata::MANY_TO_MANY, 'User', 'id', 'user_action', 'action_id', null);
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
