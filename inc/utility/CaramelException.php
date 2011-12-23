<?php


/**
*
* CaramelException class
*
* @author Felix Rupp <kontakt@felixrupp.com>
* @version $Id$
* @copyright Copyright (c) 2011, Felix Rupp, Nicole Reinhardt
* @license http://www.opensource.org/licenses/mit-license.php MIT-License
*
*/
class CaramelException extends Exception {
	
	
	/**
	 * @var Array $_codeArray Array which assigns messages to errorcodes 
	 */
	private $_codeArray = array(
		10 => "XML-Error"
	);
	
	
	/**
	 * Constructor for CaramelException
	 * 
	 * @param int $caramelCode Errorcode
	 * @return void
	 */
	public function CaramelException($caramelCode) {
		
		$this->super();
		
		$this->code = $caramelCode;
		$this->$message = $_codeArray[$caramelCode];
		
	} // End of constructor declaration
		
}

?>