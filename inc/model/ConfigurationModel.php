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
 	 * @return string Value for given key
 	 */
 	public function getConfigString($key) {
 		
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
 	 * @return void
 	 * 
 	 * @deprecated
 	 */
 	public function setConfigString($key, $string) {
 	
 		#_configFile->caramel-plist->setting->key[$keys]->nodeValue = $string;
 		
 	} // End of method declaration
 	
 	
 	
 	/**
 	* Get String from key of admin configfile
 	*
 	* @param string $key Key to lookup in config-file
 	* @return string Value for given key
 	*/
 	public function getAdminConfigString($key) {
 			
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