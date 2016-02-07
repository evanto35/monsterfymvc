<?php

/**
 * Classe que verifica se um valor de telefone brasileiro
 * 
 *
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Lumine_Validator
 */
class Lumine_Validator_Phone extends Lumine_Validator_AbstractValidator
{
	/**
	 * @see Lumine_Validator_AbstractValidator::execute()
	 */
	public function execute( Lumine_Base $target )
	{
		$value = $this->getFieldValue($target);
		$value = preg_replace('@\D@','',$value);
		
		return preg_match('@^\d{10,11}$@', $value);
	}
}
