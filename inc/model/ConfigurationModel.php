<?php

/**
 *
 * ConfigurationModel class
 * 
 * @author Felix Rupp
 * @version 0.1
 * @date: 27.11.2011
 * 
 */
 class ConfigurationModel {
 
 	# Attributes
 	private static $_configurator = NULL;
 	
 	private $_configFile;
 
 	
 	/**
 	 * 
 	 * Configurator class-constructor
 	 * Last changed: 03.04.2011
 	 * @param string $configFileName Filename for config-file to load
 	 *
 	 */
 	private function ConfigurationModel($configFileName) {
 		# Import config-file:
 		try {
 			$this->_configFile = simplexml_load_file(BASEDIR.'/config/'.$configFileName.'.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
 		}
 		catch(Exception $e) {
 			var_dump($e->getMessage());
 			printf("\n\nAchtung: Eine der relevanten Dateien konnte nicht geladen werden!");
 		}
 	} // End of constructor declaration
 	
 	
 	/**
 	 * 
 	 * Singleton-create-method
 	 * Last changed: 03.04.2011
 	 * @param string $configFileName Filename for config-file to load
 	 * @return Single instance of Configurator-Class
 	 * 
 	 */
 	public static function getConfigurationModel($configFileName) {
 	
		if (self::$_configurator === NULL) {
			self::$_configurator = new self($configFileName);
		}
		return self::$_configurator;
		
 	} // End of method declaration
 	
 	
 	# Prevent cloning
 	private function __clone() {}
 	 
 	
 	/**
 	 *
 	 * Get String from key of config-file 
 	 * Last changed: 13.02.2011
 	 * @param string $key Key to lookup in config-file
 	 * @return Value for given key
 	 *
 	 */
 	public function getConfigString($key) {
 		
 		$setting = $this->_configFile->xpath('//setting[@key="'.$key.'"]');
 		
 		if(count($setting)>0) {
 			return (string)$setting[0];
 		}
 		else {
 			echo "Error in xml-data.";
 			#exit;
 		}
 		
 	} // End of method declaration
 	
 	
 	/**
 	 *
 	 * Set String from key of config-file 
 	 * Last changed: 11.02.2011
 	 * @return void
 	 *
 	 */
 	public function setConfigString($key, $string) {
 	
 		#_configFile->caramel-plist->setting->key[$keys]->nodeValue = $string;
 		
 	} // End of method declaration
 	
 
 }
 ?>