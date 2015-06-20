<?php

final class Calls extends EntiteBase
{
	private $id;
	private $userId;
	private $dtTmStart;
	private $paxName;
	private $booking;
	private $clientTypeId;
	private $salesChannelId;
	private $summary;
	private $resolution;
	private $eventTypeId;
	private $productId;
	private $prompterId;
	private $dtTmEnd;
	
	public function __construct(DBConnection $DB, User $User, $arrData = array() {
		$this->dtTmStart = date("Y-m-d H:i:s");

		parent::__construct($DB, $User, $arrData);
	}

	public function __set($attribute, $newvalue) {
		/*switch ($attribute) {
			case 'userId' :
				$newvalue = (!isset($newvalue) || !$newvalue) ? DEFAULT : $newvalue;
				break;
			case 'dtTmStart' :
				$newvalue = (!isset($newvalue) || !$newvalue) ? DEFAULT : $newvalue;
				break;
			case 'paxName' :
				$newvalue = (!isset($newvalue) || !$newvalue) ? DEFAULT : $newvalue;
				break;
			case 'booking' :
				$newvalue = (!isset($newvalue) || !$newvalue) ? DEFAULT : $newvalue;
				break;
			case 'clientTypeId' :
				$newvalue = (!isset($newvalue) || !$newvalue) ? DEFAULT : $newvalue;
				break;
			case 'salesChannelId' :
				$newvalue = (!isset($newvalue) || !$newvalue) ? DEFAULT : $newvalue;
				break;
			case 'summary' :
				$newvalue = (!isset($newvalue) || !$newvalue) ? DEFAULT : $newvalue;
				break;
			case 'resolution' :
				$newvalue = (!isset($newvalue) || !$newvalue) ? DEFAULT : $newvalue;
				break;
			case 'eventTypeId' :
				$newvalue = (!isset($newvalue) || !$newvalue) ? DEFAULT : $newvalue;
				break;
			case 'productId' :
				$newvalue = (!isset($newvalue) || !$newvalue) ? DEFAULT : $newvalue;
				break;
			case 'prompterId' :
				$newvalue = (!isset($newvalue) || !$newvalue) ? DEFAULT : $newvalue;
				break;
			case 'dtTmEnd' :
				$newvalue = (!isset($newvalue) || !$newvalue) ? DEFAULT : $newvalue;
				break;
		} */

        if (property_exists(self, $attribute)) $this->$attribute = $newValue;
	}

	public static function getMyCalls() {
		$DB->fetch(Table::VW_CALLS, '*', 'userId')
	}
}