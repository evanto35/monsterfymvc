<?php

class Tab {
    public $active = false;
    public $title;
    public $action;

    public function __construct($title, $action = null, $active = false) {
        $this->title  = $title;
        $this->action = (empty($action) ? 'goHome' : $action);
        $this->active = $active;
    }
}