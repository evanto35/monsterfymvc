<?php

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
	    $path = APP_ROOT . '/log/';
	    
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
}