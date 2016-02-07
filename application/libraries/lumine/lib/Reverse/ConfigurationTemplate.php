<?php

Lumine::load('Reverse_ClassTemplate');

class Lumine_Reverse_ConfigurationTemplate 
{

	public $author       = 'Hugo Ferreira da Silva';
	public $date         = null;
	public $generator    = "Lumine_Reverse";
	public $link         = 'http://www.hufersil.com.br/lumine';
	public $conf         = null;
	public $ident        = '    ';
	public $database     = '';
	
	function __construct(array $conf)
	{
		$this->date = date("Y-m-d");
		$this->conf = $conf;
		$this->database = $conf['database'];
	}
	
	public function getGeneratedFile()
	{
		$ds = DIRECTORY_SEPARATOR;
		$modelo  = LUMINE_INCLUDE_PATH . "{$ds}lib{$ds}Templates{$ds}config.txt";
		$props   = array();
		$options = array();
		
		foreach($this->conf as $key => $val)
		{
			if($key == 'options')
			{
				foreach($val as $k => $v)
				{
					if( !is_array($v) ){
						$options[] = $this->ident . $this->ident . "'$k' => '$v'";
					} else {
						$optionsString = $this->ident . $this->ident . "'$k' => array(" . PHP_EOL;
						
						foreach($v as $kv => $vv){
							$optionsString .= $this->ident . $this->ident . $this->ident . "'$kv' => '$vv'," . PHP_EOL;
						}
						
						$optionsString .= $this->ident . $this->ident . ")";
						$options[] = $optionsString;
					}
				}
				continue;
			}
			
			$props[] = $this->ident .  "'$key' => '$val'";
		}
		
		$str_props   = implode(', '.PHP_EOL, $props) . ', '.PHP_EOL;
		$str_options = implode(', '.PHP_EOL, $options);
		
		if(!file_exists($modelo))
		{
			Lumine_Log::error('O arquivo '.$modelo.' não existe');
			exit;
		}
		
		$me = $this;
	
		$file = file_get_contents($modelo);
		$file = str_replace('{properties}', $str_props,   $file);
		$file = str_replace('{options}'   , $str_options, $file);
		$file = preg_replace_callback('@\{(\w+)\}@', function($match) use ($me) {
			return $me->$match[1];
		}, $file);
		
		return $file;
	}
}

?>