<?php

class FileDownload {
	private $name;
	private $size;
	private $content;

	public function __construct($name, $content) {
		$this->name 	= $name;
		$this->content 	= $content;
		$this->size    	= sizeof($content);
	}

	public function saveToFile($path) {
	    $handle = @fopen($path . '/' . $this->name, "w");
	    @fputs($handle, $this->content);
	    fclose($handle);
	}

	public function download() {
	    header('Content-Length:' . $this->size);
	    header('Content-Type:text/plain');
	    header('Content-Disposition:download;filename=' . $this->name);
	    header('Content-Transfer-Encoding: binary');
		
		exit($this->content);
	}
}