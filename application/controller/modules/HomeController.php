<?php

class HomeController extends SubController {
    public static $MODULE = Module::SCHEDULE;

	public function showMainPage($forceRefresh = false) {
        $data = array();

        $PageContent = new PageContent($this->getView('home'),
        							   'Home',
        							   $data,
        							   true,
        							   true);
        
        View::loadPage($PageContent);
    }
}