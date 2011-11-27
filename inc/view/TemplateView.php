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
	private $activeTemplate;
	
	
	/**
	 * Constructor
	 * 
	 */
	public function TemplateView($activeTemplate) {
		
		$this->activeTemplate = $activeTemplate;
		
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
		
		if($this->values) {
			foreach($this->values as $key => $val) {
				$$key = $val;
			}
		}
		
		include BASEDIR.'/template/'.$this->activeTemplate.'/index.tpl.php';
		
	}
	
	
}


?>