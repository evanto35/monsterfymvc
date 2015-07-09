<?php

/**
 * <h1>DTO do Usuário</h1>
 * 
 * @author Leandro Medeiros
 * @since  2015-07-08
 * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
 */
class UserDTO extends BaseDTO {
	/**
	 * Nome do usuário
	 * @var string
	 */
    public $name;

    /**
     * Endereço de E-mail
     * @var string
     */
    public $email;
}