<?php

# Imports
//TODO: Imports einfügen


/**
 *
 * DatabaseModel class
 *
 * @author Felix Rupp
 * @version 0.1
 * @date: 27.11.2011
 *
 */
class DatabaseModel {

	# Attributes
	private static $_databaseModel = NULL;

	private $_dataBaseFile;

	/**
	 * Configurator class-constructor
	 *
	 */
	private function DatabaseModel() {
		# Try to import the database-file
		try {			
			$this->_dataBaseFile = simplexml_load_file(BASEDIR.'/database/data.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
		}
		catch(Exception $e) {
			var_dump($e->getMessage());
			printf("\n\nAchtung: Eine der relevanten Dateien konnte nicht geladen werden!");
		}
			
	} // End of constructor declaration


	/**
	 *
	 * Singleton-create-method
	 * @return Single instance of DatabaseModel-Class
	 *
	 */
	public static function getDatabaseModel() {
	
		if (self::$_databaseModel === NULL) {
			self::$_databaseModel = new self();
		}
		return self::$_databaseModel;

	} // End of method declaration


	# Prevent cloning
	private function __clone() {}

}
?>