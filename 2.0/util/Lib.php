<?php

class Lib {
	public static function formatToDateBR(&$date) {
	    $dateToFormat       = str_replace('/', '-', $date);                                                             
	    $dateBeginInstance  = new DateTime($dateToFormat);                                                  
	    $date               = $dateBeginInstance->format('d/m/Y'); 
	    
	    return $date;
	}	
}