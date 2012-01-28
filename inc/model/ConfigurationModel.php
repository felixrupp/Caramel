<?php

/**
 * @package inc
 * @subpackage model
 */

/**
 *
 * ConfigurationModel class
 *
 * @author Felix Rupp <kontakt@felixrupp.com>
 * @version $Id$
 * @copyright Copyright (c) 2011, Felix Rupp, Nicole Reinhardt
 * @license http://www.opensource.org/licenses/mit-license.php MIT-License
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package inc
 * @subpackage model
 */
class ConfigurationModel {

	/**
	* @var ConfigurationModel $_configurator Contains single instance of our ConfigurationModel
	* @staticvar $_configurator
	*/
	private static $_configurator = NULL;
	
	
	/**
	 * @var SimpleXMLExtended $_configFile Contains the SimpleXMLExtended of our xml-configfile
	 */
	private $_configFile;
	
	/**
	 * @var SimpleXMLExtended $_adminConfigFile Contains the SimpleXMLExtended of our admin configfile
	 */
	private $_adminConfigFile;
	
	
	/**
	 * Configurator class-constructor
	 *
	 * @return void
	 */
	private function ConfigurationModel() {

		try {
			$this->reloadConfigFile();
			$this->reloadAdminConfigFile();
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
		
	} // End of constructor declaration
	
	
	/**
	 * Singleton-create-method
	 *
	 * @return ConfigurationModel Single instance of ConfigurationModel
	 */
	public static function getConfigurationModel() {
	
		if (self::$_configurator === NULL) {
			self::$_configurator = new self();
		}
		return self::$_configurator;
	
	} // End of method declaration
	
	
	# Prevent cloning
	/**
	 * Overwrite __clone() method to prevent instance-cloning
	*
	* @return void
	*/
	private function __clone() {
	}
		
	
	
	/**
	 * This method returns an ordered array with all global settings
	 *
	 * @return Array with all global settings
	 */
	public function getGlobalsAction() {
			
		$globals = array(
	 			"website_title" => array("label" => "Global website-title:", "value" => stripslashes($this->getConfigStringAction("WEBSITE_TITLE")), "blank" => false),
	 			"website_title_seperator" => array("label" => "Website-title seperator:", "value" => stripslashes($this->getConfigStringAction("WEBSITE_TITLE_SEPERATOR")), "blank" => false),
	 			"startpage" => array("label" => "Homepage:", "value" => stripslashes($this->getConfigStringAction("STARTPAGE")), "acceptedValues" => array(), "blank" => false),
	 			"base" => array("label" => "Basepath:", "value" => stripslashes($this->getConfigStringAction("BASE")), "blank" => false),
	 			"robots" => array("label" => "Robot settings:", "value" => stripslashes($this->getConfigStringAction("ROBOTS")), "acceptedValues" => array(), "blank" => false),
	 			"speaking_urls" => array("label" => "Speaking URLs:", "value" => stripslashes($this->getConfigStringAction("SPEAKING_URLS")), "blank" => false),
	 			"navigation_active_marker_position" => array("label" => "Position of active-navigation-marker:", "value" => stripslashes($this->getConfigStringAction("NAVIGATION_ACTIVE_MARKER_POSITION")), "blank" => false),
	 			"navigation_active_marker" => array("label" => "Marker for active-navigation:", "value" => stripslashes($this->getConfigStringAction("NAVIGATION_ACTIVE_MARKER")), "blank" => true),
	 			"navigation_class" => array("label" => "Navigation class:", "value" => stripslashes($this->getConfigStringAction("NAVIGATION_CLASS")), "blank" => true),
	 			"language_selector_in_footer" => array("label" => "Language selector in footer:", "value" => stripslashes($this->getConfigStringAction("LANGUAGE_SELECTOR_IN_FOOTER")), "blank" => false),
	 			"language_selector_seperator" => array("label" => "Language selector seperator:", "value" => stripslashes($this->getConfigStringAction("LANGUAGE_SELECTOR_SEPERATOR")), "blank" => false),
				"default_language" => array("label" => "Default language for frontend:", "value" => stripslashes($this->getConfigStringAction("DEFAULT_LANGUAGE")), "blank" => false),
		
		);
			
		return $globals;
			
	} // End of method declaration
	
	
	
	/**
	 * Method to save global config
	 *
	 * @param array $globals Array that contains all global settings
	 *
	 * @throws CaramelException
	 * @return void
	 */
	public function setGlobalsAction($globals) {
			
		$result = false;
	
		foreach($globals as $key => $valueArray) {
	
			if($key != "submit") {
					
				$key = strtoupper($key);
					
				$valueArray = stripslashes((string)$valueArray["value"]);
					
				$result = $this->setConfigString($key, $valueArray);
				
			}
		}
			
		return $result;
			
	} // End of method declaration
	
	
	
	/**
	* This method returns an ordered array with all admin settings
	*
	* @return Array with all admin settings
	*/
	public function getAdminAction() {
			
		$admin = array(
		 		"admin_username" => array("label" => "Admin name:", "value" => stripslashes($this->getAdminConfigStringAction("ADMIN_USERNAME")), "blank" => false),
				"admin_password" => array("label" => "New admin password:", "value" => stripslashes($this->getAdminConfigStringAction("ADMIN_PASSWORD")), "blank" => false),
		 		"admin_email" => array("label" => "Admin eMail-address:", "value" => stripslashes($this->getAdminConfigStringAction("ADMIN_EMAIL")), "blank" => false),
		 		"contact_email" => array("label" => "eMail-address for receiver of contactform:", "value" => stripslashes($this->getAdminConfigStringAction("CONTACT_EMAIL")), "blank" => false),
		);
			
		return $admin;
			
	} // End of method declaration
	
	
	
	/**
	* Method to save admin config
	*
	* @param array $globals Array that contains all admin settings
	*
	* @throws CaramelException
	* @return Result of file_put_contents
	*/
	public function setAdminAction($admin) {
			
		$result = false;
	
		foreach($admin as $key => $valueArray) {
	
			if($key != "submit") {
					
				$key = strtoupper($key);
					
				$valueArray = stripslashes((string)$valueArray["value"]);
					
				$result = $this->setAdminConfigString($key, $valueArray);
									
			}
		}
			
		return $result;
			
	} // End of method declaration
	
	
	
	/**
	 * Method to set new template file for frontend
	 * 
	 * @param string $newTemplate New template to set
	 * 
	 * @throws CaramelException
	 * @return Result of file_put_contents
	 */
	public function setTemplateAction($newTemplate) {
		
		$this->setConfigString("TEMPLATE", $newTemplate);
		
		return file_put_contents(BASEDIR.'/config/site.xml', $this->_configFile->asXML());
		
	} // End of method declaration
	
	
		
############################################################################
##
##  Helper methods
##
############################################################################
	
	
	
	/**
	 * Get String from key of config-file
	 *
	 * @param string $key Key to lookup in config-file
	 *
	 * @throws CaramelException
	 * @return string Value for given key
	 */
	public function getConfigStringAction($key) {
	
		$setting = $this->_configFile->xpath('//setting[@key="'.$key.'"]');
	
		if(count($setting)>0) {
			return (string)$setting[0];
		}
		else {
			throw new CaramelException(10);
		}
	
	} // End of method declaration
	
	
	
	/**
	 * Set String from key of config-file
	 *
	 * @param string $key Key of the setting to change
	 * @param string $newValue New value for the setting
	 *
	 * @throws CaramelException
	 * @return Result of file_put_contents
	 */
	protected function setConfigString($key, $newValue) {
	
		$setting = $this->_configFile->xpath('//setting[@key="'.$key.'"]');
	
		if(count($setting)>0) {
	
			$setting[0][0] = null;
			$setting[0][0]->addCData($newValue);
	
		}
		else {
			throw new CaramelException(10);
		}
		
		return file_put_contents(BASEDIR.'/config/site.xml', $this->_configFile->asXML());		
	
	} // End of method declaration
	
	
	
	/**
	 * Get String from key of admin configfile
	 *
	 * @param string $key Key to lookup in config-file
	 * 
	 * @throws CaramelException
	 * @return string Value for given key
	 */
	public function getAdminConfigStringAction($key) {
	
		$setting = $this->_adminConfigFile->xpath('//setting[@key="'.$key.'"]');
	
		if(count($setting)>0) {
			return (string)$setting[0];
		}
		else {
			throw new CaramelException(10);
		}
	
	} // End of method declaration
	
	
	
	/**
	* Set String from key of admin config-file
	*
	* @param string $key Key of the setting to change
	* @param string $newValue New value for the setting
	*
	* @throws CaramelException
	* @return Result of file_put_contents
	*/
	protected function setAdminConfigString($key, $newValue) {
	
		$setting = $this->_adminConfigFile->xpath('//setting[@key="'.$key.'"]');
	
		if(count($setting)>0) {
	
			$setting[0][0] = null;
			$setting[0][0]->addCData($newValue);
	
		}
		else {
			throw new CaramelException(10);
		}
	
		return file_put_contents(BASEDIR.'/config/admin.xml', $this->_adminConfigFile->asXML());
		
	} // End of method declaration
	
	
	
	/**
	 * This method updates the contents of the local configFile in our singleton.
	 *
	 * @throws CaramelException
	 * @return void
	 */
	protected function reloadConfigFile() {
			
		try {
			$this->_configFile = simplexml_load_file(BASEDIR.'/config/site.xml', "SimpleXMLExtended", LIBXML_NOCDATA);
		}
		catch(Exception $e) {
			throw new CaramelException(11);
		}
			
	} // End of method declaration
	
	
	
	/**
	 * This method updates the contents of the local adminConfigFile in our singleton.
	 *
	 * @throws CaramelException
	 * @return void
	 */
	protected function reloadAdminConfigFile() {

		try {
			$this->_adminConfigFile = simplexml_load_file(BASEDIR.'/config/admin.xml', "SimpleXMLExtended", LIBXML_NOCDATA);
		}
		catch(Exception $e) {
			throw new CaramelException(11);
		}
	
	} // End of method declaration


}
?>