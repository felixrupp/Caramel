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
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 * 
 * @package inc
 * @subpackage model
 */
class DatabaseModel {

	# Attributes
	/**
	 * @var DatabaseModel $_databaseModel Contains single instance of our DatabaseModel
	 * @staticvar $_databaseModel
	 */
	private static $_databaseModel = NULL;


	/**
	 * @var SimpleXMLElement $_dataBase Contains the SimpleXMLElement of our xml-database
	 */
	private $_dataBase;

	
	/**
	 * Configurator class-constructor
	 * 
	 * @return void
	 */
	private function DatabaseModel() {
		# Try to import the database-file
		try {			
			$this->_dataBase = simplexml_load_file(BASEDIR.'/database/data.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
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
	 * Method to get all used languages out of database
	 * 
	 * @throws CaramelException
	 * @return Array with all used language-codes
	 */
	public function getAllLanguagesAction() {
		
		$allLanguages = array();
		
		# Fill our languages array
		try{
			
			$xPathResult = $this->_dataBase->xpath('//@lang'); # Find all lang-elements
			$xPathResult = array_unique($xPathResult); # Remove double entries
			
			foreach($xPathResult as $langCode) {
				array_push($allLanguages, (string)$langCode); # Convert SimpleXMLElements into strings
			}
		} catch(CaramelException $e) {
			$e->getDetails();
		}
		
		return $allLanguages;
		
	} // End of method declaration
	
	
	
	/**
	 * Method to return all meta information for the given page/language
	 * 
	 * @param string $lang Current language used
	 * @param string $pageName Name of the current page
	 * 
	 * @throws CaramelException
	 * @return string String with all needed meta information to one page
	 */
	public function getAllMetaTagsAction($lang, $pageName) {
		
		$xPathResultMetaDescription = $this->_dataBase->xpath('//page[@path="'.$pageName.'"]/record[@lang="'.$lang.'"]/meta[@name="description"]');
		if(count($xPathResultMetaDescription)>0) {
			$metaDescription = "<meta name=\"description\" content=\"".$xPathResultMetaDescription[0]."\">";
		}
		else {
			throw new CaramelException(10);
		}
		
		$xPathResultMetaKeywords = $this->_dataBase->xpath('//page[@path="'.$pageName.'"]/record[@lang="'.$lang.'"]/meta[@name="keywords"]');
		if(count($xPathResultMetaKeywords)>0) {
			$metaKeywords = "<meta name=\"keywords\" content=\"".$xPathResultMetaKeywords[0]."\">";
		}
		else {
			throw new CaramelException(10);
		}
		
		$xPathResultMetaAuthor = $this->_dataBase->xpath('//page[@path="'.$pageName.'"]/record[@lang="'.$lang.'"]/meta[@name="author"]');
		if(count($xPathResultMetaAuthor)>0) {
			$metaAuthor = "<meta name=\"author\" content=\"".$xPathResultMetaAuthor[0]."\">";
		}
		else {
			throw new CaramelException(10);
		}
		
		return $metaDescription."\n".$metaKeywords."\n".$metaAuthor."\n";
		
	} // End of method declaration
	
	
	
	/**
	 * Method to return only all page paths
	 * 
	 * @return Array with all page paths.
	 */
	public function getAllPageNamesAction() {
		
		$pageNames = array();
		
		$xPathResultPages = $this->_dataBase->xpath("//page");
		
		if(count($xPathResultPages)>0) {
						
			foreach($xPathResultPages as $page) {
			
				$pageNames[] = (string)$page->attributes()->path;
				
			}
		}
		else{
			throw new CaramelException(10);
		}
		
		return $pageNames;		
		
	} // End of method declaration
	
	
	
	/**
	 * Method to return the needed website title
	 * 
	 * @param string $lang Current language used
	 * @param string $pageName Name of the current page
	 * 
	 * @throws CaramelException
	 * @return string String with correct website title
	 */
	public function getWebsiteTitleAction($lang, $pageName) {
		
		$xPathResultTitle = $this->_dataBase->xpath('//page[@path="'.$pageName.'"]/record[@lang="'.$lang.'"]/title');
		
		if(count($xPathResultTitle)>0) {
			$title = (string)$xPathResultTitle[0];
		}
		else {
			throw new CaramelException(10);
		}
		
		return $title;
		
	} // End of method declaration
	
	
	
	/**
	 * Method to return the content of a page
	 * 
	 * @param string $lang Current language used
	 * @param string $pageName Name of the current page
	 * 
	 * @throws CaramelException
	 * @return string String with correct website content
	 */
	public function getWebsiteContentAction($lang, $pageName) {
		
		$xPathResultContent = $this->_dataBase->xpath('//page[@path="'.$pageName.'"]/record[@lang="'.$lang.'"]/content');
		
		if(count($xPathResultContent)>0) {
			$content = $xPathResultContent[0];
		}
		else {
			throw new CaramelException(10);
		}
			
		return $content;
		
	} // End of method declaration
	
	
	
	/**
	 * Method to return array with localized navigation
	 * Note: Navigation is restricted to one sublevel
	 * 
	 * @param string $lang Current language
	 * 
	 * @return Array with localized navigation information
	 */
	public function getWebsiteNavigationAction($lang) {
				
		$orderedNavi = array();
		
		foreach($this->_dataBase->page as $page) {
			
			## Get records
			$xPathResultRecord = $page->xpath('record[@lang="'.$lang.'"]');
			
			if(count($xPathResultRecord) > 0) {
			
				$record = $xPathResultRecord[0];
			
				$orderedNavi[(int)$page->attributes()->id] = array(
					"path" => (string)$page->attributes()->path, 
					"pos" => (int)$record->navigation->attributes()->pos,
					"navigation" => (string)$record->navigation,
					"title" => (string)$record->title,
					"titletag" => (string)$record->titletag,
				);
				
			}
			
			$orderedNavi[(int)$page->attributes()->id]["subpages"] = array();
			
			
			## SubPages
			$subPages = $page->page;
			
			foreach($subPages as $subPage) {
				
				## Get subrecords
				$xPathResultRecord = $subPage->xpath('record[@lang="'.$lang.'"]');
						
				if(count($xPathResultRecord) > 0) {
							
					$subRecord = $xPathResultRecord[0];
							
					$orderedNavi[(int)$page->attributes()->id]["subpages"][(int)$subPage->attributes()->id] = array(
						"path" => (string)$subPage->attributes()->path,
						"pos" => (int)$subRecord->navigation->attributes()->pos,
						"navigation" => (string)$subRecord->navigation,
						"title" => (string)$subRecord->title,
						"titletag" => (string)$subRecord->titletag,
					);
	
				}

				
			}
			
			
		}
		
		return $orderedNavi;
		
	} // End of method declaration

}
?>