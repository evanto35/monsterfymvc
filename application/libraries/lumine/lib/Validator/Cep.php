<?php

/**
 * Validator que verifica se um valor está no formato de CEP.
 * 
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Lumine_Validator
 */
class Lumine_Validator_Cep extends Lumine_Validator_AbstractValidator
{
	/**
	 * @see Lumine_Validator_AbstractValidator::execute()
	 */
	public function execute( Lumine_Base $target )
	{
		$value = $this->getFieldValue($target);
		return preg_match('@^(\d{5})-?(\d{3})$@',$value);
	}
}


