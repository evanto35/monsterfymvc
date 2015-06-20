<?php

abstract class Base {
	//Classe da instância
	protected $instanceClass;
    //Conexão com o Banco
	protected $DB;
	//Usuário atual
	protected $CurrentUser;

    public function __construct(DBConnection $DB, User $CurrentUser, $arrData = null) {
        $this->DB 		   = $DB;
        $this->CurrentUser = $CurrentUser;
        $this->instanceClass   = get_class($this);

        if (is_array($arrData) && !empty($arrData)) {
        	foreach ($arrData as $attribute => $value) {
                if (property_exists($this->instanceClass, $attribute))
        		  $this->$attribute = $value;
        		//cast(self::$instanceClass, $this)->$attribute = $value;
        	}
        }
    }

    /**
     * Class casting
     *
     * @param string|object $destination
     * @param object $sourceObject
     * @return object
     */
    function cast($destination, $sourceObject)
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
}