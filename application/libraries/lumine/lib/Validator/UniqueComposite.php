<?php

/**
 * Verifica se já existe ou não outro registro com o mesmo valor de campos
 * no banco de dados. Utilizado geralmente em campos compostos (dois ou mais campos).
 * 
 *
 * @example new Lumine_Validator_UniqueComposite('campo1,campo2,campo3','Já exite outro registro com estes dados');
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Lumine_Validator
 */
class Lumine_Validator_UniqueComposite extends Lumine_Validator_AbstractValidator {
	/**
	 * @see Lumine_Validator_AbstractValidator::execute()
	 */
	public function execute(Lumine_Base $obj){
		$fieldName = $this->getField();
		$fields = !is_array($fieldName) ? explode(',',$fieldName) : $fieldName;
		
		$values = array();
		foreach($fields as $field){
			$method = 'get'.ucfirst($field);
			$values[$field] = method_exists($obj, $method) ? call_user_func_array(array($this,$method),array()) : $obj->$field;
		}
		
		$reflection = new ReflectionClass( $obj->metadata()->getClassname() );
		
		/* @var $objeto Lumine_Base */
		$objeto = $reflection->newInstance();
		$objeto->populateFrom( $values );
		$objeto->find();
		
		$pks = $objeto->metadata()->getPrimaryKeys();
		$result = true;
		
		while ($objeto->fetch()) {
			foreach( $pks as $def ) {
				if( $objeto->$def['name'] != $obj->$def['name']) {
					$result = false;
					break;
				}
			}
			
			if(!$result){
				break;
			}
		}
		
		$objeto->destroy();
		unset($objeto, $reflection);
		
		return $result;
	}

}