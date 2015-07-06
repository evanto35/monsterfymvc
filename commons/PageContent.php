<?php

class PageContent {
    public $module;
    public $title;
    public $data;
    public $CurrentUser;
    public $System;
    public $currentModule;
    public $navigator = array();
    public $menu      = array();

    public function __construct($module, $title, $data) {
        $this->module      = $module;
        $this->title       = $title;
        $this->data        = $data;
        $this->CurrentUser = User::getLogged();
        $this->System      = System::get();
    }
}