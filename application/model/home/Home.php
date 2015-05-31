<?php

class Home {
    //Conexão com o Banco
	protected $DB;
	protected $CurrentUser;

    public function __construct() {
        $this->DB 		   = DBConnection::getInstance();
        $this->CurrentUser = User::getLogged();
    }
}