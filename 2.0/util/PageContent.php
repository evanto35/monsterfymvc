<?php

class PageContent {
    public $module;
    public $title;
    public $data;
    public $CurrentUser;
    public $currentModule;

    public function __construct($module, $title, $data) {
        $this->module      = $module;
        $this->title       = $title;
        $this->data        = $data;
        $this->CurrentUser = User::getLogged();
    }
}