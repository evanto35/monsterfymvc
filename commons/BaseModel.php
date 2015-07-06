<?php

abstract class Base {
	//Classe da instância
	protected $instanceClass;
    //Conexão com o Banco
	protected $DB;
	//Usuário atual
	protected $CurrentUser;

    public function __construct() {
        $this->DB 		       = new Database();
        $this->CurrentUser     = User::getLogged();
        $this->instanceClass   = get_class($this);

        // if (is_array($arrData) && !empty($arrData)) {
        // 	foreach ($arrData as $attribute => $value) {
        //         if (property_exists($this->instanceClass, $attribute))
        // 		  $this->$attribute = $value;
        // 		//cast(self::$instanceClass, $this)->$attribute = $value;
        // 	}
        // }
    }

    public function __wakeup() {
        $this->DB = new Database();
    }
}