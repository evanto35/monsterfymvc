<?php

class PageContent {

    public $file;
    public $title;
    public $data;
    public $CurrentUser;
    public $currentModule;
    public $appRoot;

    public function __construct($file, $title, $data) {
        global $APP_ROOT;
        
        $this->file        = $file;
        $this->title       = $title;
        $this->data        = $data;
        $this->CurrentUser = User::getLogged();
        $this->appRoot     = $APP_ROOT;
    }
}