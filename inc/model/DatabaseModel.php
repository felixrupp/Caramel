<?php

/**
 * @package inc
 * @subpackage model
 */

/**
 *
 * DatabaseModel class
 *
 * @author Felix Rupp <kontakt@felixrupp.com>
 * @version $Id$
 * @copyright Copyright (c) 2011, Felix Rupp, Nicole Reinhardt
 * @license http://www.opensource.org/licenses/mit-license.php MIT-License
 * 
 */
class DatabaseModel {

	# Attributes
	/**
	 * @var DatabaseModel $_databaseModel Contains single instance of our DatabaseModel
	 * @staticvar
	 */
	private static $_databaseModel = NULL;


	/**
	 * @var SimpleXMLElement $_dataBaseFile Contains the SimpleXMLElement of our xml-database
	 */
	private $_dataBaseFile;

	
	/**
	 * Configurator class-constructor
	 * 
	 * @return void
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
	 * Singleton-create-method
	 * 
	 * @static
	 * @return DatabaseModel Single instance of DatabaseModel-Class
	 * @return void
	 */
	public static function getDatabaseModel() {
	
		if (self::$_databaseModel === NULL) {
			self::$_databaseModel = new self();
		}
		return self::$_databaseModel;

	} // End of method declaration


	# Prevent cloning
	/**
	 * Overwrite __clone() method to prevent instance-cloning
	 * 
	 * @return void
	 */
	private function __clone() {}
	
	
	/**
	 * Enter description here ...
	 * 
	 * @return SimpleXMLElement Returns the SimpleXMLElement-object containing our database
	 * @return void
	 */
	public function getDatabaseFile() {
		
		return $this->_dataBaseFile;
		
	}

}
?>