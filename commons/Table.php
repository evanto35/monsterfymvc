<?php

class Table extends Base {
	public $name;
	public $fields = array();

	public function __construct() {
		parent::__construct();

		$this->name = $name;
		$this->getFields();
	}

	protected function getFields() {
		$this->DB->addArgument('schema', Config::DB_NAME);
		$this->DB->addArgument('table', $this->name);

		if ($this->DB->execute(Query::TABLE_GET_FIELDS)) {
			foreach($this->DB->dataset as $element) {
				$this->fields[] = $element['column_name'];
			}
		}
	}
}