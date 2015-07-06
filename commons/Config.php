<?php

abstract class Config {
    const APP_TITLE          = 'Monsterfy MVC';
    const DEFAULT_MODULE     = 'calls';
    const DB_DRIVER          = 'mysql';
    const DB_HOST            = '127.0.0.1';
    const DB_PORT            = 3306;
    const DB_NAME            = 'incidentmaster';
    const DB_USER            = 'root';
    const DB_PASSWORD        = 'Develop#23';
    const CONNECTION_STRING  = '%s:host=%s;dbname=%s;charset=utf8;port=%d';

    public static function getConnectionString() {
    	return sprintf(self::CONNECTION_STRING,
    				   self::DB_DRIVER,
    				   self::DB_HOST,
    				   self::DB_NAME,
                       self::DB_PORT);
    }
}