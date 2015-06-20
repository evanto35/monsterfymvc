<?php

final class HomeController extends ControllerBase {
    public static $view = 'home';

	public function goHome($forceRefresh = false) {
        $data = array();

        $PageContent = new PageContent(static::$view,
        							   'Home',
        							   $data,
        							   true,
        							   true);
        
        self::loadPage($PageContent);
    }
}