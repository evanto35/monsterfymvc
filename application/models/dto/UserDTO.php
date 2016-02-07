<?php
class UserDTO {

	public $_explicitType = 'dto.UserDTO';

	public $id;
	public $corporationId;
	public $groupId;
	public $active;
	public $email;
	public $password;
	public $name;
	public $annotation = array();
	public $client = array();
	public $clientaddress = array();
	public $clientphones = array();
	public $services = array();
	public $services1 = array();
	public $action = array();
}