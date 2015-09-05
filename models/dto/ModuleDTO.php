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

/**
 * DTO do Módulo
 *
 * @package models
 * @author 	Leandro Medeiros
 * @since  	2015-07-08
 * @link   	http://bitbucket.org/leandro_medeiros/monsterfymvc
 */
final class ModuleDTO extends BaseDTO {
	/**
	 * Título
	 * @var string
	 */
	public $title;

	/**
	 * Módulo (diretório)
	 * @var string
	 */
	public $name;

	/**
	 * Ordem no menu
	 * @var integer
	 */
	public $menu_order;
	
	/**
	 * Ícone (arquivo)
	 * @var string
	 */
	public $icon;
}