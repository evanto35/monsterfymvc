<?php

final class System extends Base {
	public $clientTypes	  = array();
	public $eventTypes	  = array();
	public $products	  = array();
	public $prompters	  = array();
	public $salesChannels = array();
	public $users		  = array();

	public function __construct() {
		parent::__construct();

		$this->refreshAll();
		$this->selfStore();
	}

	protected function refreshAll() {
		try {
			$this->refreshClientTypes();
			$this->refreshEventTypes();
			$this->refreshProducts();
			$this->refreshPrompters();
			$this->refreshSalesChannels();
			$this->refreshUsers();

			return true;
		}
		catch(Exception $e) {
			Lib::log($e);
		}
	}

	public function refreshClientTypes() {
		if ($this->DB->execute(Query::SYSTEM_GET_CLIENT_TYPES)) {
			foreach($this->DB->dataset as $record)
				$this->clientTypes[$record['id']] = $record;
		}
	}

	public function refreshEventTypes() {
		if ($this->DB->execute(Query::SYSTEM_GET_EVENT_TYPES)) {
			foreach($this->DB->dataset as $record)
				$this->eventTypes[$record['id']] = $record;
		}
	}

	public function refreshProducts() {
		if ($this->DB->execute(Query::SYSTEM_GET_PRODUCTS)) {
			foreach($this->DB->dataset as $record)
				$this->products[$record['id']] = $record;
		}
	}

	public function refreshPrompters() {
		if ($this->DB->execute(Query::SYSTEM_GET_PROMPTERS)) {
			foreach($this->DB->dataset as $record)
				$this->prompters[$record['id']] = $record;
		}
	}

	public function refreshSalesChannels() {
		if ($this->DB->execute(Query::SYSTEM_GET_SALES_CHANNELS)) {
			foreach($this->DB->dataset as $record)
				$this->salesChannels[$record['id']] = $record;
		}
	}

	public function refreshUsers() {
		if ($this->DB->execute(Query::SYSTEM_GET_USERS)) {
			foreach($this->DB->dataset as $record)
				$this->users[$record['id']] = $record;
		}
	}

	protected function selfStore() {
		$_SESSION[BaseController::IDX_SYSTEM] = serialize($this);
	}

	public static function get() {
		if (isset($_SESSION[BaseController::IDX_SYSTEM]))
			return unserialize($_SESSION[BaseController::IDX_SYSTEM]);
		else
			return new System();
	}
} 