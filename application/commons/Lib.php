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

abstract class Lib {
	public static function formatToDateBR(&$date) {
	    $dateToFormat       = str_replace('/', '-', $date);
	    $dateBeginInstance  = new DateTime($dateToFormat);
	    $date               = $dateBeginInstance->format('d/m/Y');

	    return $date;
	}

	public static function startsWith($haystack, $needle) {
	    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
	}

	public static function endsWith($haystack, $needle) {
	    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
	}

    public static function mkdir_r($dirName, $rights=0777){
        $dirs = explode('/', $dirName);
        $dir  = '';

        foreach ($dirs as $part) {
            $dir .= $part . '/';
            if (!is_dir($dir) && strlen($dir) > 0)
                mkdir($dir, $rights);
        }
    }    

	public static function log($data, $clear = false, $customFileName = '') {
	    $path = PATH_APP.'log/';
	    
        if (!is_dir($path)) mkdir($path, 0777);
	    // if (!is_dir($path)) Lib::mkdir_r($path, 0755);

	    $filename = $path . date('Y-m-d') . $customFileName . '.log';

        if ($clear && is_file($filename)) unlink($filename);
        
	    $fp = @fopen($filename, "a+");

	    if ($fp !== false) {
		    if (!is_string($data)) {
		        $data = print_r($data, true);
		    }

		    $str  = "\r\n###########################################################################################################\r\n";
		    $str .= "Log registrado às " . date("H:i:s") . "\r\n";
		    $str .= "Navegador: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
		    $str .= "IP: " . $_SERVER['REMOTE_ADDR'];
		    $str .= "\r\n" . $data . "\r\n\r\n";
            // $str .= "\r\n" . $data . "\r\n###########################################################################################################\r\n";

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

    public static function arrayToDto(array $source, $dtoClass) {
        $dto        = new $dtoClass();
        $properties = get_object_vars($dto);

        foreach ($properties as $property) {
            $dto->$property = array_key_exists($dao, $source);
        }

        return $dto;
    }

    /**
     * Aplica filtros padrao ao objeto Lumine_Base
     *
     * @author Leandro Medeiros <leandro.medeiros@live.com>
     * @since  2016-01-29
     * 
     * @param  Lumine_Base $obj     Objeto que será filtrado
     * @param  array      $filters Filtros
     * @return null
     */
    public static function applyFilters(Lumine_Base $obj, array $filters) {

        foreach ($filters as $key => $value) {
            if (is_array($value) || is_object($value)) {
                continue;
            }

            try {

                $value = trim($value);

                if ($value !== '' && !is_null($value)) {
                    $field = $obj->_getField($key);

                    switch (strtolower($field['type'])) {
                    case 'numeric':
                    case 'float':
                    case 'date':
                    case 'datetime':
                    case 'timestamp':
                    case 'int':
                    case 'smallint':
                    case 'bigint':
                    case 'integer':
                        $obj->where('{' . $key . '} = ?', $value);
                        break;

                    case 'boolean':
                        $value = $value == 't' || $value === true || $value == '1' ? 1 : 0;
                        $obj->where('{' . $key . '} = ?', $value);
                        break;

                    default:
                        $obj->where('{' . $key . '} ilike ?', $value);
                    }
                }
            } catch (Exception $e) { /* so para nao dar problema na hora de encontrar o campo. */
            }
        }
    }
}