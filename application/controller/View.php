<?php

class View {
    public static function loadPage(PageContent $PageContent, $headerContent = true) {
        global $APP_ROOT;

        require($APP_ROOT . '/application/view/header.php');
        if ($headerContent)
        	require($APP_ROOT . '/application/view/header-content.php');
        require($APP_ROOT . '/application/view/' . $PageContent->file . '.php');
        require($APP_ROOT . '/application/view/footer.php');
    }

    public static function loadLogin() {
        View::loadPage(new PageContent('login', 'Login', null), false);
    }
}