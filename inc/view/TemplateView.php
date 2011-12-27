<?php

/**
 * @package inc
 * @subpackage view
 */

/**
 *
 * TemplateView class
 *
 * @author Felix Rupp <kontakt@felixrupp.com>
 * @version $Id$
 * @copyright Copyright (c) 2011, Felix Rupp, Nicole Reinhardt
 * @license http://www.opensource.org/licenses/mit-license.php MIT-License
 * 
 */
class TemplateView {
	
	# Attributes
	/**
	 * @var array $values Will contain all template-values
	 */
	private $_values;

	/**
	 * @var String Path to active template directory
	 */
	private $_activeTemplate;
	
	
	/**
	 * Constructor of TemplateView
	 * 
	 * @param String $activeTemplate Path to active template directory
	 * @return void
	 */
	public function TemplateView($activeTemplate) {
		
		$this->_activeTemplate = $activeTemplate;
		
		$this->_values = array();
		
	} // End of constructor declaration
	
	
	/**
	 * Method to assign all template values to our template
	 * 
	 * @param String $key Array-key
	 * @param String $value Array-value for key
	 * @return void
	 */
	public function assign($key, $value) {
		
		$this->_values[$key] = $value;
		
	} // End of method declaration
	
	
	public function addCssJs() {
		
		$cssJs = "<link rel=\"stylesheet\" type=\"text/css\" href=\"".TEMPLATEDIR."template/".$this->_activeTemplate."/css/styles.css\">\n";
		$cssJs .= "<script type=\"text/javascript\" src=\"".TEMPLATEDIR."template/".$this->_activeTemplate."/js/scripts.js\"></script>";
		
		return $cssJs;
		
	}
	
	
	/**
	 * Function which renders the template
	 * 
	 * @return void
	 */
	public function render() {
		
		if($this->_values) {
			foreach($this->_values as $key => $val) {
				$$key = $val;
			}
		}
		
		include BASEDIR.'/template/'.$this->_activeTemplate.'/index.tpl.php';
		
	} // End of method declaration
	
	
}


?>