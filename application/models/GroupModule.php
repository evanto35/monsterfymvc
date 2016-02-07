<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "group_module"
 * in 2016-01-25
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package models
 *
 */

class GroupModule extends Lumine_Base {

    
    public $moduleId;
    public $groupId;
    public $favorite;
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('group_module');
        $this->metadata()->setPackage('models');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('moduleId', 'module_id', 'int', 10, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Module'));
        $this->metadata()->addField('groupId', 'group_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Groups'));
        $this->metadata()->addField('favorite', 'favorite', 'boolean', 1, array('notnull' => true, 'default' => '0'));

        
    }

    #### END AUTOCODE
}
