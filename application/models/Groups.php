<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "groups"
 * in 2016-01-25
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package models
 *
 */

class Groups extends Lumine_Base {

    
    public $id;
    public $name;
    public $description;
    public $groupmodules = array();
    public $useres = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('groups');
        $this->metadata()->setPackage('models');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->metadata()->addField('name', 'name', 'varchar', 45, array('notnull' => true));
        $this->metadata()->addField('description', 'description', 'varchar', 200, array('notnull' => true));

        
        $this->metadata()->addRelation('groupmodules', Lumine_Metadata::ONE_TO_MANY, 'GroupModule', 'groupId', null, null, null);
        $this->metadata()->addRelation('useres', Lumine_Metadata::ONE_TO_MANY, 'User', 'groupId', null, null, null);
    }

    #### END AUTOCODE


}
