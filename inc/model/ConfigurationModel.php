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
 * 
 */
 class ConfigurationModel {
 
 	# Attributes
 	/**
 	 * @var ConfigurationModel $_configurator Contains single instance of our ConfigurationModel
 	 * @staticvar
 	 */
 	private static $_configurator = NULL;
 	
 
 	/**
 	 * @var SimpleXMLElement $_configFile Contains the SimpleXMLElement of our xml-configfile
 	 */
 	private $_configFile;
 	
 	/**
  	 * @var SimpleXMLElement $_adminConfigFile Contains the SimpleXMLElement of our admin configfile
 	 */
 	private $_adminConfigFile;
 
 	
 	/**
 	 * Configurator class-constructor
 	 * 
 	 * @return void
 	 */
 	private function ConfigurationModel() {
 		# Import config-file:
 		try {
 			$this->_configFile = simplexml_load_file(BASEDIR.'/config/site.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
 			$this->_adminConfigFile = simplexml_load_file(BASEDIR.'/config/admin.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
 		}
 		catch(Exception $e) {
 			var_dump($e->getMessage());
 			printf("\n\nAchtung: Eine der relevanten Dateien konnte nicht geladen werden!");
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
 	private function __clone() {}
 	 
 	
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
 	 * @throws CaramelException
 	 * @return void
  	 */
 	public function setConfigStringAction($key, $newValue) {
 		
 		$setting = $this->_configFile->xpath('//setting[@key="'.$key.'"]');
 		
 		if(count($setting)>0) {
 			
 			$setting[0] = $newValue;
 			$this->_configFile->asXML(BASEDIR.'/config/site.xml');
 			
 		}
 		else {
 			throw new CaramelException(10);
 		}
 	
 		#_configFile->caramel-plist->setting->key[$keys]->nodeValue = $string;
 		
 	} // End of method declaration
 	
 	
 	
 	/**
 	 * This method returns an ordered array with all global settings
 	 * 
 	 * @return Array with all global settings
 	 */
 	public function getGlobalsAction() {
 		
 		return array(
 			"website_title" => array("label" => "Global website-title:", "value" => $this->getConfigStringAction("WEBSITE_TITLE"), "blank" => false),
 			"website_title_seperator" => array("label" => "Website-title seperator:", "value" => $this->getConfigStringAction("WEBSITE_TITLE_SEPERATOR"), "blank" => false),
 			"startpage" => array("label" => "Homepage:", "value" => $this->getConfigStringAction("STARTPAGE"), "blank" => false),
 			"base" => array("label" => "Basepath:", "value" => $this->getConfigStringAction("BASE"), "blank" => false),
 			"robots" => array("label" => "Robot settings:", "value" => $this->getConfigStringAction("ROBOTS"), "blank" => false),
 			"revisit_after" => array("label" => "Robots revisit after:", "value" => $this->getConfigStringAction("REVISIT_AFTER"), "blank" => false),
 			"speaking_urls" => array("label" => "Speaking URLs", "value" => $this->getConfigStringAction("SPEAKING_URLS"), "blank" => false),
 			"navigation_active_marker_position" => array("label" => "Position of active-navigation-marker", "value" => $this->getConfigStringAction("NAVIGATION_ACTIVE_MARKER_POSITION"), "blank" => false),
 			"navigation_active_marker" => array("label" => "Marker for active-navigation:", "value" => $this->getConfigStringAction("NAVIGATION_ACTIVE_MARKER"), "blank" => true),
 			"navigation_class" => array("label" => "Navigation class:", "value" => $this->getConfigStringAction("NAVIGATION_CLASS"), "blank" => true),
 			"language_selector_in_footer" => array("label" => "Language selector in footer:", "value" => $this->getConfigStringAction("LANGUAGE_SELECTOR_IN_FOOTER"), "blank" => false),
 			"language_selector_seperator" => array("label" => "Language selector seperator:", "value" => $this->getConfigStringAction("LANGUAGE_SELECTOR_SEPERATOR"), "blank" => false),
 		);
 		
 	} // End of method declaration
 	
 	
 	
 	/**
 	 * Method to save global config
 	 * 
 	 * @param array $globals Array that contains all global settings
 	 * 
 	 * throws CaramelException
 	 * @return void
 	 */
 	public function setGlobalsAction($globals) {
 		
 		foreach($globals as $key => $valueArray) {
 			
 			if($key != "submit") {
 				
 				$key = strtoupper($key);
 				 			
 				$setting = $this->_configFile->xpath('//setting[@key="'.$key.'"]');

 				if(count($setting)>0) {
 					
 					$setting[0] = null;
 					$setting[0] = $valueArray["value"];
 					
 					echo $setting[0]."\n";
 						
 				}
 				else {
 					throw new CaramelException(10);
 				}
 			}
 		}
 		 		
 		return file_put_contents(BASEDIR.'/config/site2.xml', $this->_configFile->asXML());
 		
 	} // End of method declaration
 	
 	
 	
 	################
 	## Admin stuff
 	################
 	
	/**
 	* Get String from key of admin configfile
 	*
 	* @param string $key Key to lookup in config-file
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
 	
 
 }
 ?>