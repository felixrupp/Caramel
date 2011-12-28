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
	 * @var String Name of the template file to use. DEFAULT ist index
	 */
	private $_templateFile;
	
	
	/**
	 * Constructor of TemplateView
	 * 
	 * @param String $activeTemplate Path to active template directory
	 * @return void
	 */
	public function TemplateView($activeTemplate) {
		
		$this->_activeTemplate = $activeTemplate;
		
		$this->_templateFile = "index";
		
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
	
	
	
	/**
	 * Method to add correct JS and CSS files from template
	 * 
	 * @return String with html content of JS and CSS files
	 */
	public function addCssJs() {
		
		$cssJs = "<link rel=\"shortcut icon\" href=\"".TEMPLATEDIR."/".$this->_activeTemplate."/images/favicon.ico\" type=\"image/ico\">\n";
		$cssJs .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".TEMPLATEDIR."/".$this->_activeTemplate."/css/styles.css\">\n";
		$cssJs .= "<script type=\"text/javascript\" src=\"".TEMPLATEDIR."/".$this->_activeTemplate."/js/scripts.js\"></script>";
		
		return $cssJs;
		
	} // End of method declaration
	
	
	
	/**
	 * Method to set different template filename
	 * 
	 * @param String $templateFile
	 */
	public function setTemplateFile($templateFile) {
		
		$this->_templateFile = $templateFile;
		
	} // End of method declaration
	
	
	
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
		
		$this->_templateFile = "index";
		
		include BASEDIR.'/template/'.$this->_activeTemplate.'/'.$this->_templateFile.'.tpl.php';
		
	} // End of method declaration
	
	
	
	/**
	 * Method to return template content as string
	 * 
	 * @return Content of templatefile
	 */
	public function returnTemplate() {
		
		if($this->_values) {
			foreach($this->_values as $key => $val) {
				$$key = $val;
			}
		}
		
		return file_get_contents(TEMPLATEDIR.'/'.$this->_activeTemplate.'/'.$this->_templateFile.'.tpl.php');
		
	} // End of method declaration
	
	
}


?>