<?php
class ModuleDTO {

	public $_explicitType = 'dto.ModuleDTO';

	public $id;
	public $active;
	public $title;
	public $name;
	public $menuOrder;
	public $icon;
	public $action = array();
	public $groupmodules = array();
}