<?php

class Module {
    public $title;
    public $active;
    public $controller;
    public $itens;

    public function __construct($title, $currentController, $actionController) {
        $this->title 		= $title;
        $this->active 		= ($currentController === $actionController);
        $this->controller 	= $actionController;
    }
}