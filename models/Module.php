<?php

/**
 * <h1>DAO do Módulo</h1>
 *
 * @author Leandro Medeiros
 * @since  2015-07-08
 * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc 
 */
class Module extends BaseDAO {
    /**
     * <h1>Construtor</h1>
     *
     * @method __construct
     * @param  ModuleDTO $Dto
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public function __construct(ModuleDTO $Dto) {
        parent::__construct($Dto);
    }

    /**
     * <h1>Obter Lista (override)</h1>
     *
     * @method getList
     * @return array Lista
     * @author Leandro Medeiros
     * @since  2015-07-09
     * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
     */
    public static function getList() {
    	return parent::getList(new ModuleDTO);
    }
}