<?php


/**
*
* TemplateView class
*
* @author Felix Rupp
* @version 0.1
* @date: 27.11.2011
*
*/

class TemplateView {
	
	# Attributes
	private $values;
	private $activeTemplatePath;
	
	
	/**
	 * Constructor
	 * 
	 */
	public function TemplateView($activeTemplatePath) {
		
		$this->activeTemplatePath = $activeTemplatePath;
		
		$this->values = array();
		
	} // End of constructor declaration
	
	
	/**
	 * assign-method
	 * 
	 * @param String $key
	 * @param String $value
	 */
	public function assign($key, $value) {
		
		$this->values[$key] = $value;
		
	} // End of method declaration
	
	
	
	public function render() {
		
		//TODO: Render algorithmus bauen, der html template lädt und verarbeitet
		
		
	}
	
	
}


?>