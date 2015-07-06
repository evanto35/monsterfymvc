<?php

class Tab {
    public $active = false;
    public $title;
    public $action;
    public $module;

    public function __construct($active, $title, $action = null, $module = null) {
        $this->active = $active;
        $this->title  = $title;
        $this->action = $action;
        $this->module = $module;
    }
}