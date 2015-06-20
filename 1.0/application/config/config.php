<?php

abstract class Config {
    const DB_DRIVER    		= 'mysql';
    const DB_HOST      		= 'localhost';
    const DB_NAME      		= 'MedeirosMVC';
    const DB_USER 	   		= 'root';
    const DB_PASSWORD 		= 'Develop!10';
    const CONNECTION_STRING = "%s:host=%s;dbname=%s;charset=utf8";

    public static function getConnectionString() {
    	return sprintf(self::CONNECTION_STRING,
    				   self::DB_DRIVER,
    				   self::DB_HOST,
    				   self::DB_NAME);
    }
}