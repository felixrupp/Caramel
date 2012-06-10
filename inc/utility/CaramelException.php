<?php

/**
 * @package inc
 * @subpackage utility
 */


require_once BASEDIR.'/inc/model/ConfigurationModel.php';

/**
 *
 * CaramelException class
 *
 * @author Felix Rupp <kontakt@felixrupp.com>
 * @version $Id$
 * @copyright Copyright (c) 2011, Felix Rupp, Nicole Reinhardt
 * @license http://www.opensource.org/licenses/mit-license.php MIT-License
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 * 
 * @package inc
 * @subpackage utility
 */
class CaramelException extends Exception {
	
	
	/**
	 * @var Array $_codeArray Array which assigns messages to errorcodes 
	 */
	private $_codeArray = array(
		10 => "XML-Error!",
		11 => "XML-file could not be loaded!",
		66 => "Bcrypt is not supported on this server!"
	);
	
	/**
	 * @var String $_adminEmail eMail adress of the admin
	 */
	private $_adminEmail = "";
	
	
	/**
	 * Constructor for CaramelException
	 * 
	 * @param int $caramelCode Errorcode
	 * @return void
	 */
	public function __construct($caramelCode) {
		
		# Get Configurator
		$this->_config = ConfigurationModel::getConfigurationModel();
	
		$this->_adminEmail = $this->_config->getAdminConfigStringAction("ADMIN_EMAIL");
		
		$this->code = $caramelCode;
		$this->message = $this->_codeArray[$caramelCode];
		
	} // End of constructor declaration
	
	
	
	/**
	 * Method to print exception details
	 * 
	 * @return void
	 */
	public function getDetails() {
		
		print("<div style=\"margin: 20px auto; width: 80%; padding:12px 16px; border: 2px solid #ec4040; background-color: #fb8b8b; color:white; font-weight: bold; font-family: 'Courier New', Courier, monospace; font-size: 1.2em;\"><p>Error:</p><p>".$this->message."<br>raised in file: ".$this->file." at line: ".$this->line."</p><p>Please contact the administrator of this page via ".$this->_adminEmail.".</p></div>");
		
	} // End of method declaration
		
}

?>