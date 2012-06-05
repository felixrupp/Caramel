<?php

/**
 * @package inc
 * @subpackage utility
 */

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
		10 => "XML-Error",
		11 => "XML-file could not be loaded",
		66 => "Bcrypt is not supported on this server!"
	);
	
	
	/**
	 * Constructor for CaramelException
	 * 
	 * @param int $caramelCode Errorcode
	 * @return void
	 */
	public function __construct($caramelCode) {
		
		$this->code = $caramelCode;
		$this->message = $this->_codeArray[$caramelCode];
		
	} // End of constructor declaration
	
	
	
	/**
	 * Method to print exception details
	 * 
	 */
	public function getDetails() {
		
		print($this->message."<br>in file: ".$this->file." at line: ".$this->line."<br><br>Please contact the administrator of this page.");
		exit;
		
	} // End of method declaration
		
}

?>