<?php

class HomeItem {
	public $module;
	public $title;
	public $imageName;

	public function __construct($module, $title) {
		$this->module 	 = $module;
		$this->title 	 = $title;
		$this->imageName = APP_LOCAL_IMAGE_PATH . strtolower($module) . '.png';
	}
}