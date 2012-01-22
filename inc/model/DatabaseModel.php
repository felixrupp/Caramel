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
	 * @var SimpleXMLExtended $_dataBase Contains the SimpleXMLExtended of our xml-database
	 */
	private $_dataBase;

	
	/**
	 * Configurator class-constructor
	 * 
	 * @return void
	 */
	private function DatabaseModel() {
		
		$this->reloadDatabaseFile();
			
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
			$content = (string)$xPathResultContent[0];
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
	
	
	/**
	* Method to return array with all pages and subpages
	* Note: Navigation is restricted to one sublevel
	*
	* @param string $lang Current language
	*
	* @return Array with all pages
	*/
	public function getWebsitePagesAction($lang) {
	
		$orderedNavi = array();
	
		foreach($this->_dataBase->page as $page) {
				
			## Get records
			$xPathResultRecord = $page->xpath('record[@lang="'.$lang.'"]');
			
			if(count($xPathResultRecord) > 0) {
				
				$record = $xPathResultRecord[0];
				
				$orderedNavi[(int)$page->attributes()->id] = array(
						"path" => (string)$page->attributes()->path, 
						"pos" => (int)$record->navigation->attributes()->pos,
						"id" => (int)$page->attributes()->id,
						"navigation" => (string)$record->navigation,
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
						"id" => (int)$subPage->attributes()->id,
						"navigation" => (string)$subRecord->navigation,
					);
	
				}
	
					
			}
			
			
		}
	
		return $orderedNavi;
	
	} // End of method declaration
	
	
	
	/**
	 * Method to get all page information incl. records for one page-id
	 * 
	 * @param int $id Id from one specific page
	 * 
	 * @throws CaramelException
	 * @return Array with all information to page with $id
	 */
	public function getPageInformation($id) {
		
		$xPathResultPage = $this->_dataBase->xpath('//page[@id="'.$id.'"]');
		
		$page = array();
		
		$page["id"] = $id;
		$page["path"] = (string)$xPathResultPage[0]->attributes()->path;
		
		if(count($xPathResultPage)>0) {
			
			foreach($xPathResultPage[0]->record as $record) {
				
				$lang = (string)$record->attributes()->lang;
				
				$page["records"][$lang]["navigation"]["label"] = "Name used in navigation:";
				$page["records"][$lang]["navigation"]["value"] = stripslashes(trim((string)$record->navigation));
				
				$page["records"][$lang]["title"]["label"] = "Website title:";
				$page["records"][$lang]["title"]["value"] = stripslashes(trim((string)$record->title));
				
				$page["records"][$lang]["titletag"]["label"] = "Title-tag used in navigation:";
				$page["records"][$lang]["titletag"]["value"] = stripslashes(trim((string)$record->titletag));
				
				$page["records"][$lang]["metadescription"]["label"] = "Description:";
				$page["records"][$lang]["metadescription"]["value"] = stripslashes(trim((string)$record->meta[0]));
				
				$page["records"][$lang]["metakeywords"]["label"] = "Keywords:";
				$page["records"][$lang]["metakeywords"]["value"] = stripslashes(trim((string)$record->meta[1]));
				
				$page["records"][$lang]["metaauthor"]["label"] = "Author:";
				$page["records"][$lang]["metaauthor"]["value"] = stripslashes(trim((string)$record->meta[2]));
				
				$page["records"][$lang]["socialbar"]["label"] = "Activate Socialbar:";
				$page["records"][$lang]["socialbar"]["value"] = stripslashes(trim((string)$record->socialbar));
				
				$page["records"][$lang]["content"]["label"] = "Page content:";
				$page["records"][$lang]["content"]["value"] = trim((string)$record->content);
				
			}
			
		}
		else {
			throw new CaramelException(10);
		}
			
		return $page;
		
	}
	
	
	
	/**
	* Method to get all page information incl. records for one page-id
	*
	* @param int $id Id from one specific page
	* @param array $page Array with modified page information
	*
	* @throws CaramelException
	* @return Array with all information to page with $id
	*/
	public function setPageInformation($id, $page) {	
		
		foreach($page["records"] as $lang => $record) {
			
			$xPathResultRecord = $this->_dataBase->xpath('//page[@id="'.$id.'"]/record[@lang="'.$lang.'"]');
			
			if(count($xPathResultRecord)>0) {
				
				$xPathResultRecord[0]->navigation = null;
				$xPathResultRecord[0]->navigation->addCData(stripslashes(trim($record["navigation"]["value"])));
				$xPathResultRecord[0]->title = null;
				$xPathResultRecord[0]->title->addCData(stripslashes(trim($record["title"]["value"])));
				$xPathResultRecord[0]->titletag = null;
				$xPathResultRecord[0]->titletag->addCData(stripslashes(trim($record["titletag"]["value"])));
				$xPathResultRecord[0]->meta[0] = null;
				$xPathResultRecord[0]->meta[0]->addCData(stripslashes(trim($record["metadescription"]["value"])));
				$xPathResultRecord[0]->meta[1] = null;
				$xPathResultRecord[0]->meta[1]->addCData(stripslashes(trim($record["metakeywords"]["value"])));
				$xPathResultRecord[0]->meta[2] = null;
				$xPathResultRecord[0]->meta[2]->addCData(stripslashes(trim($record["metaauthor"]["value"])));
				$xPathResultRecord[0]->socialbar = null;
				$xPathResultRecord[0]->socialbar->addCData(stripslashes(trim($record["socialbar"]["value"])));
				$xPathResultRecord[0]->content = null;
				$xPathResultRecord[0]->content->addCData(stripslashes(trim($record["content"]["value"])));
				
			}
			else {
				throw new CaramelException(10);
			}
			
		}
		
		return file_put_contents(BASEDIR.'/database/data.xml', $this->_dataBase->asXML());
		
	}
	
	
	
########################
##
## Helper methods
##
########################

	protected function reloadDatabaseFile() {
		# Try to import the database-file
		try {
			$this->_dataBase = simplexml_load_file(BASEDIR.'/database/data.xml', "SimpleXMLExtended", LIBXML_NOCDATA);
		}
		catch(Exception $e) {
			var_dump($e->getMessage());
			printf("\n\nAchtung: Eine der relevanten Dateien konnte nicht geladen werden!");
		}
	}
	
}
?>