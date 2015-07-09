<?php

/**
 * <h1>Classe base para uma DTO</h1>
 * 
 * <p>Todas as DTO da aplicação devem estender esta.</p>
 * 
 * @author Leandro Medeiros
 * @since  2015-07-08
 * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
 */
abstract class BaseDTO {
    /**
     * Chave primária
     * @var integer
     */
    public $id = 0;
    /**
     * Registro ativo ou não
     * @var boolean
     */
    public $active = true;
}