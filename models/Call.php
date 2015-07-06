<?php

final class Call extends BaseModel
{
	private $id;
	public  $userId;
	public  $dtTmStart;
	public  $paxName;
	public  $booking;
	public  $clientTypeId;
	public  $salesChannelId;
	public  $summary;
	public  $eventTypeId;
	public  $productId;
	public  $prompterId;
	public  $resolution;
	public  $dtTmEnd;
	
	public function getRequiredFields() {
		$required['paxName'] 		= 'PAX';
		$required['booking'] 		= 'Reserva';
		$required['clientTypeId']	= 'Tipo do Cliente';
		$required['salesChannelId'] = 'Canal de Vendas';
		$required['summary']		= 'Resumo';
		$required['eventTypeId']	= 'Tipo de Ocorrência';
		$required['productId'] 		= 'Produto';
		$required['prompterId']		= 'Causador';

		return $required;
	}

	public function __construct($id = 0) {
		parent::__construct();

		$this->id 		 = $id;
		$this->userId    = User::getLogged()->id;
		$this->dtTmStart = date("Y-m-d H:i:s");
	}

	public function register() {
		$this->DB->addArgument('userId',		 $this->userId);
		$this->DB->addArgument('dtTmStart',		 $this->dtTmStart);
		$this->DB->addArgument('paxName',		 $this->paxName);
		$this->DB->addArgument('booking',		 $this->booking);
		$this->DB->addArgument('clientTypeId',	 $this->clientTypeId);
		$this->DB->addArgument('salesChannelId', $this->salesChannelId);
		$this->DB->addArgument('summary',		 $this->summary);
		$this->DB->addArgument('eventTypeId',	 $this->eventTypeId);
		$this->DB->addArgument('productId',		 $this->productId);
		$this->DB->addArgument('prompterId',	 $this->prompterId);

		return $this->DB->execute(Query::CALL_INSERT);
	}

	public function finish($resolution) {
		if (!$this->id)
			return false;
		else {
			$this->DB->addArgument('id', $this->id);
			$this->DB->addArgument('dtTmEnd', date("Y-m-d H:i:s"));
			$this->DB->addArgument('resolution', $resolution);
			
			return $this->DB->execute(Query::CALL_UPDATE);
		}
	}

	public static function getUserCalls($userId) {
		$DB = new Database();
		$DB->addArgument('userId', $userId);

		if ($DB->execute(Query::CALL_GET_ALL_BY_USER))
			return $DB->dataset;
		else
			return array();
	}

	public static function getAllCalls() {
		$DB = new Database();
		if ($DB->execute(Query::CALL_GET_ALL))
			return $DB->dataset;
		else
			return array();
	}
}