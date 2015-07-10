<?php
#############################################################################
##   MonsterfyMVC - MVC Framework for PHP + MySQL                          ##
##   Copyright (C) 2012  Leandro Medeiros                                  ##
##                                                                         ##
##   This program is free software: you can redistribute it and/or modify  ##
##   it under the terms of the GNU General Public License as published by  ##
##   the Free Software Foundation, either version 3 of the License, or     ##
##   (at your option) any later version.                                   ##
##                                                                         ##
##   This program is distributed in the hope that it will be useful,       ##
##   but WITHOUT ANY WARRANTY; without even the implied warranty of        ##
##   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         ##
##   GNU General Public License for more details.                          ##
##                                                                         ##
##   You should have received a copy of the GNU General Public License     ##
##   along with this program.  If not, see <http://www.gnu.org/licenses/>. ##
##                                                                         ##
#############################################################################

class Lib {
	public static function formatToDateBR(&$date) {
	    $dateToFormat       = str_replace('/', '-', $date);
	    $dateBeginInstance  = new DateTime($dateToFormat);
	    $date               = $dateBeginInstance->format('d/m/Y');

	    return $date;
	}

	public static function startsWith($haystack, $needle) {
	    // search backwards starting from haystack length characters from the end
	    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
	}

	public static function endsWith($haystack, $needle) {
	    // search forward starting from end minus needle length characters
	    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
	}

	public function log($data) {
	    $path = APP_LOCAL_PATH . '/log/';
	    
	    if (!is_dir($path)) mkdir($path, 0777, true);

	    $filename = $path . date('Y-m-d') . '.log';
	    $fp = @fopen($filename, "a+");

	    if ($fp !== false) {
		    if (!is_string($data)) {
		        $data = print_r($data, true);
		    }

		    $str      = "\r\n//\r\n";
		    $str     .= "Log registrado às " . date("H:i:s") . "\r\n";
		    $str     .= "Navegador: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
		    $str     .= "IP: " . $_SERVER['REMOTE_ADDR'];
		    $str 	 .= "\r\nRegistro: " . $data .  "\r\n//\r\n";

		    @fputs($fp, $str);
		    fclose($fp);
		}
	}

    /**
     * Class casting
     *
     * @param string|object $destination
     * @param object $sourceObject
     * @return object
     */
    public static function cast($destination, $sourceObject)
    {
        if (is_string($destination)) {
            $destination = new $destination();
        }
        $sourceReflection = new ReflectionObject($sourceObject);
        $destinationReflection = new ReflectionObject($destination);
        $sourceProperties = $sourceReflection->getProperties();
        foreach ($sourceProperties as $sourceProperty) {
            $sourceProperty->setAccessible(true);
            $name = $sourceProperty->getName();
            $value = $sourceProperty->getValue($sourceObject);
            if ($destinationReflection->hasProperty($name)) {
                $propDest = $destinationReflection->getProperty($name);
                $propDest->setAccessible(true);
                $propDest->setValue($destination,$value);
            } else {
                $destination->$name = $value;
            }
        }
        return $destination;
    }

    public static function printAndDie($info) {
		die("<pre>" . print_r($info, true) . "</pre>");
    }

    public static function datasetToDto(BaseDTO $Target, $source) {
        foreach($source as $property => $value) {
            $Target->$property = $value;
        }

        return $Target;
    }
}