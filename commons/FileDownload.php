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
 * Baixar Arquivo
 * 
 * <p>Responsável por fazer o download de um arquivo via PHP.</p>
 *
 * @package commons
 * @author 	Leandro Medeiros
 * @since   2015-07-08
 * @link    http://bitbucket.org/leandro_medeiros/monsterfymvc
 */
class FileDownload {
	/**
	 * Nome do Arquivo
	 * @var string
	 */
	private $name;

	/**
	 * Tamanho do Arquivo
	 * @var integer
	 */
	private $size;

	/**
	 * Conteúdo do Arquivo
	 * @var mixed
	 */
	private $content;

	/**
	 * Construtor
	 *
	 * @method __construct
	 * @param  string $name    Nome do Arquivo
	 * @param  mixed  $content Conteúdo do Arquivo
	 * @author Leandro Medeiros
	 * @since  2015-07-09
	 * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
	 */
	public function __construct($name, $content) {
		$this->name 	= $name;
		$this->content 	= $content;
		$this->size    	= sizeof($content);
	}

	/**
	 * Salvar em Arquivo
	 *
	 * @method saveToFile
	 * @param  string $path Diretório
	 * @return null
	 * @author Leandro Medeiros
	 * @since  2015-07-09
	 * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
	 */
	public function saveToFile($path) {
	    $handle = @fopen($path . '/' . $this->name, "w");
	    @fputs($handle, $this->content);
	    fclose($handle);
	}

	/**
	 * Baixar Arquivo
	 *
	 * @method download
	 * @return mixed Conteúdo do Arquivo
	 * @author Leandro Medeiros
	 * @since  2015-07-09
	 * @link   http:/bitbucket.org/leandro_medeiros/monsterfymvc
	 */
	public function download() {
	    header('Content-Length:' . $this->size);
	    header('Content-Type:text/plain');
	    header('Content-Disposition:download;filename=' . $this->name);
	    header('Content-Transfer-Encoding: binary');
		
		exit($this->content);
	}
}