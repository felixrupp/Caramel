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
	public function getAllMetaTagsAction($lang, $pageName=NULL, $pageId=NULL) {
		
		
		if($pageName!=NULL && $pageId==NULL) {
			$xPathResultMetaDescription = $this->_dataBase->xpath('//page[@path="'.$pageName.'"]/record[@lang="'.$lang.'"]/meta[@name="description"]');
		}
		else if($pageId!=NULL && $pageName==NULL) {
			$xPathResultMetaDescription = $this->_dataBase->xpath('//page[@id="'.$pageId.'"]/record[@lang="'.$lang.'"]/meta[@name="description"]');
		}
		else{
			$xPathResultMetaDescription = $this->_dataBase->xpath('//page/record[@lang="'.$lang.'"]/meta[@name="description"]');
		}
		
		
		if(count($xPathResultMetaDescription)>0 && $xPathResultMetaDescription!=false) {
			$metaDescription = "<meta name=\"description\" content=\"".$xPathResultMetaDescription[0]."\">";
		}
		else { // Take first language
			
			if($pageName!=NULL && $pageId==NULL) {
				$xPathResultMetaDescription = $this->_dataBase->xpath('//page[@path="'.$pageName.'"]/record/meta[@name="description"]');
			}
			else if($pageId!=NULL && $pageName==NULL) {
				$xPathResultMetaDescription = $this->_dataBase->xpath('//page[@id="'.$pageId.'"]/record/meta[@name="description"]');
			}
			else{
				$xPathResultMetaDescription = $this->_dataBase->xpath('//page/record/meta[@name="description"]');
			}
			
			
			if(count($xPathResultMetaDescription)>0 && $xPathResultMetaDescription!=false) {
				$metaDescription = "<meta name=\"description\" content=\"".$xPathResultMetaDescription[0]."\">";
			}
			else {
				throw new CaramelException(10);
			}
			
		}
		
		
		
		
		if($pageName!=NULL && $pageId==NULL) {
			$xPathResultMetaKeywords = $this->_dataBase->xpath('//page[@path="'.$pageName.'"]/record[@lang="'.$lang.'"]/meta[@name="keywords"]');
		}
		else if($pageId!=NULL && $pageName==NULL) {
			$xPathResultMetaKeywords = $this->_dataBase->xpath('//page[@id="'.$pageId.'"]/record[@lang="'.$lang.'"]/meta[@name="keywords"]');
		}
		else{
			$xPathResultMetaKeywords = $this->_dataBase->xpath('//page/record[@lang="'.$lang.'"]/meta[@name="keywords"]');
		}
		
		if(count($xPathResultMetaKeywords)>0 && $xPathResultMetaKeywords!=false) {
			$metaKeywords = "<meta name=\"keywords\" content=\"".$xPathResultMetaKeywords[0]."\">";
		}
		else { // Take first language
			
			if($pageName!=NULL && $pageId==NULL) {
				$xPathResultMetaKeywords = $this->_dataBase->xpath('//page[@path="'.$pageName.'"]/record/meta[@name="keywords"]');
			}
			else if($pageId!=NULL && $pageName==NULL) {
				$xPathResultMetaKeywords = $this->_dataBase->xpath('//page[@id="'.$pageId.'"]/record/meta[@name="keywords"]');
			}
			else{
				$xPathResultMetaKeywords = $this->_dataBase->xpath('//page/record/meta[@name="keywords"]');
			}
			
			if(count($xPathResultMetaKeywords)>0 && $xPathResultMetaKeywords!=false) {
				$metaKeywords = "<meta name=\"keywords\" content=\"".$xPathResultMetaKeywords[0]."\">";
			}
			else {
				throw new CaramelException(10);
			}
			
		}
		
		
		
		
		if($pageName!=NULL && $pageId==NULL) {
			$xPathResultMetaAuthor = $this->_dataBase->xpath('//page[@path="'.$pageName.'"]/record[@lang="'.$lang.'"]/meta[@name="author"]');
		}
		else if($pageId!=NULL && $pageName==NULL) {
			$xPathResultMetaAuthor = $this->_dataBase->xpath('//page[@id="'.$pageId.'"]/record[@lang="'.$lang.'"]/meta[@name="author"]');
		}
		else{
			$xPathResultMetaAuthor = $this->_dataBase->xpath('//page/record[@lang="'.$lang.'"]/meta[@name="author"]');
		}
		
		if(count($xPathResultMetaAuthor)>0 && $xPathResultMetaAuthor!=false) {
			$metaAuthor = "<meta name=\"author\" content=\"".$xPathResultMetaAuthor[0]."\">";
		}
		else { // Take first language
			
			if($pageName!=NULL && $pageId==NULL) {
				$xPathResultMetaAuthor = $this->_dataBase->xpath('//page[@path="'.$pageName.'"]/record/meta[@name="author"]');
			}
			else if($pageId!=NULL && $pageName==NULL) {
				$xPathResultMetaAuthor = $this->_dataBase->xpath('//page[@id="'.$pageId.'"]/record/meta[@name="author"]');
			}
			else{
				$xPathResultMetaAuthor = $this->_dataBase->xpath('//page/record/meta[@name="author"]');
			}
			
			if(count($xPathResultMetaAuthor)>0 && $xPathResultMetaAuthor!=false) {
				$metaAuthor = "<meta name=\"author\" content=\"".$xPathResultMetaAuthor[0]."\">";
			}
			else {
				throw new CaramelException(10);
			}
			
		}
		
		return $metaDescription."\n".$metaKeywords."\n".$metaAuthor."\n";
		
	} // End of method declaration
	
	
	
	/**
	 * Method to return only all page paths
	 * 
	 * @throws CaramelException
	 * @return Array with all page paths.
	 */
	public function getAllPageNamesAction() {
		
		$pageNames = array();
		
		$xPathResultPages = $this->_dataBase->xpath("//page");
		
		if(count($xPathResultPages)>0) {
						
			foreach($xPathResultPages as $page) {
			
				$pageNames[] = array("path"=>(string)$page->attributes()->path, "id"=>(int)$page->attributes()->id);
				
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
	public function getWebsiteTitleAction($lang, $pageName=NULL, $pageId=NULL) {
				
		if($pageName!=NULL && $pageId==NULL) {
			$xPathResultTitle = $this->_dataBase->xpath('//page[@path="'.$pageName.'"]/record[@lang="'.$lang.'"]/title');
		}
		else if($pageId!=NULL && $pageName==NULL) {
			$xPathResultTitle = $this->_dataBase->xpath('//page[@id="'.$pageId.'"]/record[@lang="'.$lang.'"]/title');
		}
		else{
			$xPathResultTitle = $this->_dataBase->xpath('//page/record[@lang="'.$lang.'"]/title');
		}
		
		if(count($xPathResultTitle)>0 && $xPathResultTitle!=false) {
			$title = (string)$xPathResultTitle[0][0];
		}
		else { // Take first language
			
			if($pageName!=NULL && $pageId==NULL) {
				$xPathResultTitle = $this->_dataBase->xpath('//page[@path="'.$pageName.'"]/record/title');
			}
			else if($pageId!=NULL && $pageName==NULL) {
				$xPathResultTitle = $this->_dataBase->xpath('//page[@id="'.$pageId.'"]/record/title');
			}
			else{
				$xPathResultTitle = $this->_dataBase->xpath('//page/record/title');
			}
			
			
			if(count($xPathResultTitle)>0 && $xPathResultTitle!=false) {
				$title = (string)$xPathResultTitle[0][0];
			}
			else {
				throw new CaramelException(10);
			}
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
	public function getWebsiteContentAction($lang, $pageName=NULL, $pageId=NULL) {
		
		
		if($pageName!=NULL && $pageId==NULL) {
			$xPathResultContent = $this->_dataBase->xpath('//page[@path="'.$pageName.'"]/record[@lang="'.$lang.'"]/content');
		}
		else if($pageId!=NULL && $pageName==NULL) {
			$xPathResultContent = $this->_dataBase->xpath('//page[@id="'.$pageId.'"]/record[@lang="'.$lang.'"]/content');
		}
		else{
			$xPathResultContent = $this->_dataBase->xpath('//page/record[@lang="'.$lang.'"]/content');
		}
		
		
		if(count($xPathResultContent)>0 && $xPathResultContent!=false) {
						
			$content = (string)$xPathResultContent[0][0];

		}
		else { // take first language available
			
			if($pageName!=NULL && $pageId==NULL) {
				$xPathResultContent = $this->_dataBase->xpath('//page[@path="'.$pageName.'"]/record/content');
			}
			else if($pageId!=NULL && $pageName==NULL) {
				$xPathResultContent = $this->_dataBase->xpath('//page[@id="'.$pageId.'"]/record/content');
			}
			else{
				$xPathResultContent = $this->_dataBase->xpath('//page/record/content');
			}
			
			if(count($xPathResultContent)>0 && $xPathResultContent!=false) {
				$content = (string)$xPathResultContent[0][0];
			}
			else {
				throw new CaramelException(10);
			}

		}
		
		return $content;
		
	} // End of method declaration
	
	
	
	/**
	 * Method to return array with localized navigation
	 * Note: Navigation is restricted to one sublevel
	 * 
	 * @param string $lang Current language
	 * 
	 * @throws CaramelException
	 * @return Array with localized navigation information
	 */
	public function getWebsiteNavigationAction($lang) {
				
		$orderedNavi = array();
		
		foreach($this->_dataBase->page as $page) {
			
			## Get records
			$xPathResultRecord = $page->xpath('record[@lang="'.$lang.'"]');
			
			if(count($xPathResultRecord) > 0 && $xPathResultRecord!=false) {
			
				$record = $xPathResultRecord[0];
			
				$orderedNavi[(int)$page->attributes()->id] = array(
					"path" => (string)$page->attributes()->path, 
					"pos" => (int)$record->navigation->attributes()->pos,
					"navigation" => (string)$record->navigation,
					"title" => (string)$record->title,
					"titletag" => (string)$record->titletag,
				);
				
			} else { // Take first language
				
				$xPathResultRecord = $page->xpath('record');
				
				if(count($xPathResultRecord) > 0 && $xPathResultRecord!=false) {
					$record = $xPathResultRecord[0];
						
					$orderedNavi[(int)$page->attributes()->id] = array(
						"path" => (string)$page->attributes()->path, 
						"pos" => (int)$record->navigation->attributes()->pos,
						"navigation" => (string)$record->navigation,
						"title" => (string)$record->title,
						"titletag" => (string)$record->titletag,
					);
				}
				else {
					throw new CaramelException(10);
				}
				
			}
			
			$orderedNavi[(int)$page->attributes()->id]["subpages"] = array();
			
			
			## SubPages
			$subPages = $page->page;
			
			foreach($subPages as $subPage) {
				
				## Get subrecords
				$xPathResultRecord = $subPage->xpath('record[@lang="'.$lang.'"]');
						
				if(count($xPathResultRecord) > 0 && $xPathResultRecord!=false) {
							
					$subRecord = $xPathResultRecord[0];
							
					$orderedNavi[(int)$page->attributes()->id]["subpages"][(int)$subPage->attributes()->id] = array(
						"path" => (string)$subPage->attributes()->path,
						"pos" => (int)$subRecord->navigation->attributes()->pos,
						"navigation" => (string)$subRecord->navigation,
						"title" => (string)$subRecord->title,
						"titletag" => (string)$subRecord->titletag,
					);
	
				} else { // Take first language
					
					$xPathResultRecord = $subPage->xpath('record');
					
					
					if(count($xPathResultRecord) > 0 && $xPathResultRecord!=false) {
						$subRecord = $xPathResultRecord[0];
							
						$orderedNavi[(int)$page->attributes()->id]["subpages"][(int)$subPage->attributes()->id] = array(
							"path" => (string)$subPage->attributes()->path,
							"pos" => (int)$subRecord->navigation->attributes()->pos,
							"navigation" => (string)$subRecord->navigation,
							"title" => (string)$subRecord->title,
							"titletag" => (string)$subRecord->titletag,
						);
					}
					else {
						throw new CaramelException(10);
					}
					
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
	* @throws CaramelException
	* @return Array with all pages
	*/
	public function getWebsitePagesAction($lang) {
	
		$orderedNavi = array();
	
		foreach($this->_dataBase->page as $page) {
				
			## Get records
			$xPathResultRecord = $page->xpath('record[@lang="'.$lang.'"]');
			
			if(count($xPathResultRecord) > 0 && $xPathResultRecord!=false) {
				
				$record = $xPathResultRecord[0];
				
				$orderedNavi[(int)$page->attributes()->id] = array(
					"path" => (string)$page->attributes()->path, 
					"pos" => (int)$record->navigation->attributes()->pos,
					"id" => (int)$page->attributes()->id,
					"navigation" => (string)$record->navigation,
				);
	
			} else { // Take first language 
				
				$xPathResultRecord = $page->xpath('record');
					
				if(count($xPathResultRecord) > 0 && $xPathResultRecord!=false) {
				
					$record = $xPathResultRecord[0];
				
					$orderedNavi[(int)$page->attributes()->id] = array(
						"path" => (string)$page->attributes()->path, 
						"pos" => (int)$record->navigation->attributes()->pos,
						"id" => (int)$page->attributes()->id,
						"navigation" => (string)$record->navigation,
					);
				
				} else {
					throw new CaramelException(10);
				}
			}
			
			$orderedNavi[(int)$page->attributes()->id]["subpages"] = array();
			
			
			## SubPages
			$subPages = $page->page;
			
			foreach($subPages as $subPage) {
	
				## Get subrecords
				$xPathResultRecord = $subPage->xpath('record[@lang="'.$lang.'"]');
							
				if(count($xPathResultRecord) > 0 && $xPathResultRecord!=false) {
				
					$subRecord = $xPathResultRecord[0];
			
					$orderedNavi[(int)$page->attributes()->id]["subpages"][(int)$subPage->attributes()->id] = array(
						"path" => (string)$subPage->attributes()->path,
						"pos" => (int)$subRecord->navigation->attributes()->pos,
						"id" => (int)$subPage->attributes()->id,
						"navigation" => (string)$subRecord->navigation,
					);
	
				} else { // Take first language
					
					$xPathResultRecord = $subPage->xpath('record');
								
					if(count($xPathResultRecord) > 0 && $xPathResultRecord!=false) {
					
						$subRecord = $xPathResultRecord[0];
				
						$orderedNavi[(int)$page->attributes()->id]["subpages"][(int)$subPage->attributes()->id] = array(
							"path" => (string)$subPage->attributes()->path,
							"pos" => (int)$subRecord->navigation->attributes()->pos,
							"id" => (int)$subPage->attributes()->id,
							"navigation" => (string)$subRecord->navigation,
						);
		
					} else {
						throw new CaramelException(10);
					}
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
		$page["path"]["label"] = "URL path to page";
		
		if(count($xPathResultPage)>0) {
			
			$page["path"]["value"] = (string)$xPathResultPage[0]["path"];
			
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
	* @return Result of file_put_contents
	*/
	public function setPageInformation($id, $page) {
		
		$result = false;
		
		$xPathResultPage = $this->_dataBase->xpath('//page[@id="'.$id.'"]');
		
		if(count($xPathResultPage)>0) {
			
			$xPathResultPage[0]["path"] = $page["path"]["value"];
			
			$result = file_put_contents(BASEDIR.'/database/data.xml', $this->_dataBase->asXML());
			
		}
		else {
			throw new CaramelException(10);
		}
		
		
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
				
				$result = file_put_contents(BASEDIR.'/database/data.xml', $this->_dataBase->asXML());
				
			}
			else {
				throw new CaramelException(10);
			}
			
		}
		
		return $result;
		
	}
	
	
	/**
	 * Method to delete a single page with all records
	 * 
	 * @param int $pageId Id of the page
	 * 
	 * @throws CaramelException
	 * @return Results of file_put_contents
	 */
	public function deletePageAction($pageId) {
		
		$result = false;
		
		$xPathResultPage = $this->_dataBase->xpath('//page[@id="'.$pageId.'"]');
		
		if(count($xPathResultPage)>0) {
			
			$xPathResultPage[0]->removeNode();
			
			$result = file_put_contents(BASEDIR.'/database/data.xml', $this->_dataBase->asXML());
			
		}
		else {
			throw new CaramelException(10);
		}
		
		return $result;
		
	} // End of method declaration
	
	
	
	/**
	 * Method to create a new page with one default record
	 * 
	 * @param string $path URL path of the new page
	 * @param string $defaultLang Language for default record of the new page
	 * @param array $recordContents Array with contents of default record
	 * 
	 * @throws CaramelException
	 * @return Result of file_put_contents
	 */
	public function createPageAction($path, $defaultLang, $recordContents) {
		
		$result = false;
		$idArray = array();
		
		$xPathId = $this->_dataBase->xpath("page/@id");
				
		if(count($xPathId)>0) {
			
			foreach($xPathId as $idNode) {
				$idArray[] = (int)$idNode["id"];
			}
			
			$newID = max($idArray)+1;
			
			
			# Add page
			$newPage = $this->_dataBase->addChildCData("page");
			
			## Set ID
			$newPage->addAttribute("id", $newID);
			
			## Set path
			$newPage->addAttribute("path", $path);
			
			
			# Add record
			$newRecord = $newPage->addChildCData("record");
			
			## Set language
			$newRecord->addAttribute("lang", $defaultLang);
			
			## Add rest of children
			$navigation = $newRecord->addChildCData("navigation", $recordContents["navigation"]);
			
			$newRecord->addChild("title", $recordContents["title"]);
			
			$newRecord->addChild("titletag", $recordContents["titletag"]);
			
			$metaDescription = $newRecord->addChildCData("meta", $recordContents["metadescription"]);
			$metaDescription->addAttribute("name", "description");
			
			$metaKeywords = $newRecord->addChildCData("meta", $recordContents["metakeywords"]);
			$metaKeywords->addAttribute("name", "keywords");
			
			$metaAuthor = $newRecord->addChildCData("meta", $recordContents["metaauthor"]);
			$metaAuthor->addAttribute("name", "author");
			
			$newRecord->addChildCData("socialbar", "false");
			
			$newRecord->addChildCData("content", $recordContents["content"]);
			
			$result = file_put_contents(BASEDIR.'/database/data.xml', $this->_dataBase->asXML());
			
		}
		else {
			throw new CaramelException(10);
		}
		
		return $result;
		
	} // End of method declaration
	
	
	
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