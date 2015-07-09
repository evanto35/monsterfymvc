<?php

/**
 * <h1>Baixar Arquivo</h1>
 * 
 * <p>Responsável por fazer o download de um arquivo via PHP.</p>
 * 
 * @author Leandro Medeiros
 * @since  2015-07-08
 * @link   http://bitbucket.org/leandro_medeiros/monsterfymvc
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
	 * <h1>Construtor</h1>
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
	 * <h1>Salvar em Arquivo</h1>
	 *
	 * @method saveToFile
	 * @param  string $path Diretório
	 * @return void
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
	 * <h1>Baixar Arquivo</h1>
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