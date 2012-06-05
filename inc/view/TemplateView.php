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
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 * 
 * @package inc
 * @subpackage view
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
	 * @var array Array with additional CSS files to load
	 */
	private $_additionalCssFiles = array();
	
	/**
	 * @var array Array with additional JS files to load
	 */
	private $_additionalJsFiles = array();
	
	
	
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
		
		foreach($this->_additionalCssFiles as $cssFile) {
			$cssJs .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".TEMPLATEDIR."/".$this->_activeTemplate."/css/".$cssFile.".css\">\n";
		}
		
		$cssJs .= "<script type=\"text/javascript\" src=\"".TEMPLATEDIR."/".$this->_activeTemplate."/js/jquery.min.js\"></script>\n";
		
		$cssJs .= "<script type=\"text/javascript\" src=\"".TEMPLATEDIR."/".$this->_activeTemplate."/js/scripts.js\"></script>\n";
		
		foreach($this->_additionalJsFiles as $jsFile) {
			$cssJs .= "<script type=\"text/javascript\" src=\"".TEMPLATEDIR."/".$this->_activeTemplate."/js/".$jsFile.".js\"></script>\n";
		}
		
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
	* Method to render the template with gzip compression
	*
	* @return void
	*/
	public function renderGzipped() {
	
		ob_start();
		ob_implicit_flush(0);
	
		$this->render();
	
		global $HTTP_ACCEPT_ENCODING;
	
		if(headers_sent()){
				
			$encoding = false;
				
		} elseif( strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false ) {
				
			$encoding = 'x-gzip';
				
		} elseif( strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false ) {
				
			$encoding = 'gzip';
				
		} else {
				
			$encoding = false;
				
		}
	
		if($encoding) {
				
			$contents = ob_get_contents();
				
			ob_end_clean();
				
			header('Content-Encoding: '.$encoding);
				
			print("\x1f\x8b\x08\x00\x00\x00\x00\x00");
				
			$size = strlen($contents);
				
			$contents = gzcompress($contents, 9);
				
			$contents = substr($contents, 0, $size);
				
			print($contents);
				
		} else {
				
			ob_end_flush();
	
		}
	
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
	
	
	
	/**
	 * Method to return activeTemplate-path
	 * 
	 * @return activeTemplate-path
	 */
	public function getActiveTemplate() {
		return $this->_activeTemplate;
	} // End of method declaration
	
	
	
	/**
	 * Method to add new CSS files to array
	 * 
	 * @param String $cssFilename
	 */
	public function addCssFile($cssFilename) {
		array_push($this->_additionalCssFiles, $cssFilename);
	} // End of method declaration
	
	/**
	* Method to add new JS files to array
	*
	* @param String $jsFilename
	*/
	public function addJsFile($jsFilename) {
		array_push($this->_additionalJsFiles, $jsFilename);
	} // End of method declaration

	
}
?>