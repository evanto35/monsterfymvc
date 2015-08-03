<?php

class TabDTO extends BaseDTO {
	/**
	 * ID do módulo pai
	 * @var integer
	 */
	public $module_id;

	/**
	 * Ordem no TabControl
	 * @var integer
	 */
	public $menu_order;

	/**
	 * Título da Aba
	 * @var string
	 */
	public $title;

	/**
	 * Ação Padrão
	 * @var string
	 */
	public $action;
}