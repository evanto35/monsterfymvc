<?php
/**
 * **********************************************************************
 * Classe de contexto para arquiteturas MVC
 * 
 * Para utilizar com frameworks, como por exemplo, CodeIgniter.
 * Inicializa todas as configuracoes necessarias para utilizacao de
 * Lumine.
 * 
 * Esta classe deve ser incluida
 * 
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br
 * @package Lumine
 * 
 * **********************************************************************
 */ 
// inclui os arquivos necessarios
$luminebootstrap = PATH_APP . 'libraries' . DIRECTORY_SEPARATOR . 'lumine' . DIRECTORY_SEPARATOR . 'Lumine.php';

require_once ($luminebootstrap);

class ApplicationContextLumine extends Lumine_EventListener {
	
	/**
	 * Construtor
	 * 
	 * @author Hugo Ferreira da Silva
	 * @link http://www.hufersil.com.br
	 * @return Lumine_ApplicationContext
	 */
	public function __construct(){
		
		include 'ConfigLumine.php';
		$cfg = new Lumine_Configuration($lumineConfig);
		
		register_shutdown_function(array($cfg->getConnection(),'close'));
		spl_autoload_register(array('Lumine','import'));
		spl_autoload_register(array('Lumine','loadModel'));
		
	}
	
}