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
	 * Method to get all used languages out of database
	 * 
	 * @return Array with all used language-codes
	 */
	public function getAllLanguagesAction() {
		
		$allLanguages = array();
		
		# Fill our languages array
		$xPathResult = $this->_dataBase->xpath('//@lang'); # Find all lang-elements
		$xPathResult = array_unique($xPathResult); # Remove double entries
		
		foreach($xPathResult as $langCode) {
			array_push($allLanguages, (string)$langCode); # Convert SimpleXMLElements into strings
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
		
		$xPathResultMetaDescription = $this->_dataBase->xpath('//page[@name="'.$pageName.'"]/record[@lang="'.$lang.'"]/meta[@name="description"]');
		if(count($xPathResultMetaDescription)>0) {
			$metaDescription = "<meta name=\"description\" content=\"".$xPathResultMetaDescription[0]."\">";
		}
		else {
			throw new CaramelException(10);
		}
		
		$xPathResultMetaKeywords = $this->_dataBase->xpath('//page[@name="'.$pageName.'"]/record[@lang="'.$lang.'"]/meta[@name="keywords"]');
		if(count($xPathResultMetaKeywords)>0) {
			$metaKeywords = "<meta name=\"keywords\" content=\"".$xPathResultMetaKeywords[0]."\">";
		}
		else {
			throw new CaramelException(10);
		}
		
		$xPathResultMetaAuthor = $this->_dataBase->xpath('//page[@name="'.$pageName.'"]/record[@lang="'.$lang.'"]/meta[@name="author"]');
		if(count($xPathResultMetaAuthor)>0) {
			$metaAuthor = "<meta name=\"author\" content=\"".$xPathResultMetaAuthor[0]."\">";
		}
		else {
			throw new CaramelException(10);
		}
		
		return $metaDescription."\n".$metaKeywords."\n".$metaAuthor."\n";
		
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
		
		$xPathResultTitle = $this->_dataBase->xpath('//page[@name="'.$pageName.'"]/record[@lang="'.$lang.'"]/title');
		
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
		
		$xPathResultContent = $this->_dataBase->xpath('//page[@name="'.$pageName.'"]/record[@lang="'.$lang.'"]/content');
		
		if(count($xPathResultContent)>0) {
			$content = $xPathResultContent[0];
		}
		else {
			throw new CaramelException(10);
		}
			
		return $content;
		
	} // End of method declaration
	
	
	
	
	public function getWebsiteNavigationAction($lang, $pageName) {
		
		$orderedNavi = array();
		$orderedSubNavi = array();

		#$navigation = "<ul>";



		foreach($this->_dataBase->page as $page) {

			$xPathResultRecord = $page->xpath('record[@lang="'.$lang.'"]');

			if(count($xPathResultRecord) > 0) {

				foreach($xPathResultRecord as $record) {

					/*
					 $navigationLocalized = "";
					$active = "";
					$titletagLocalized = "";

					# Localized navigation-tag
					$navigationLocalized = (string)$record->navigation;

					# Get navi-position
					$naviPosition = (int)$record->navigation->attributes()->pos;

					# Build active marker
					//TODO: Do it not here!
					#if(((string)$page->attributes()->name) == $pageName) {
					#	$active = $this->_config->getConfigString("NAVIGATION_ACTIVE_MARKER");
					#}

					# Localized title-tag
					$titletagLocalized = (string)$record->titletag;
					*/
						
					$orderedNavi[(string)$page->attributes()->name] = array(
										"name" => (string)$page->attributes()->name, 
										"pos" => (int)$record->navigation->attributes()->pos,
										"navigation" => (string)$record->navigation,
										"title" => (string)$record->title,
										"titletag" => (string)$record->titletag
					);
						

					# Get Parameters before ampersand
					//TODO: Do it not here!
					#$newQueryString = $this->getParametersBefore();

					# Concatenate link for navigation
					//TODO: Do it not here!
					#$naviLink = (empty($_SERVER['QUERY_STRING']) ? '?' : $newQueryString).'display=';


					# Build single navigation links in <li>-Tags
					//TODO: Do it not here!
					/*if($naviPosition!=-1) {

					$sPush = "\n\t<li><a";

					# Set navigation class
					if($this->_config->getConfigString("NAVIGATION_CLASS") !="disabled") {
					$sPush .= $this->_config->getConfigString("NAVIGATION_CLASS");
					}

					# Define link-syntax (speaking urls or not)
					if($this->_config->getConfigString("SPEAKING_URLS") == "false") {
					$sPush .= " href=\"".$naviLink.(string)$page->attributes()->name."\"";
					}
					elseif($this->_config->getConfigString("SPEAKING_URLS") == "true") {
					$sPush .= " href=\"".$this->getParametersBefore().'/'.(string)$page->attributes()->name."/\"";
					}


					# Set rel-attribute
					# DEACTIVATED BECAUSE OF HTML5 DOCTYPE
					#if($this->_config->getConfigString("NAVIGATION_REL") !="disabled") {
					#	$sPush .= $this->_config->getConfigString("NAVIGATION_REL");
					#}

					$sPush .= " title=\"".$titletagLocalized."\">";

					# Evaluate position of NAVIGATION_ACTIVE_MARKER
					if($this->_config->getConfigString("NAVIGATION_ACTIVE_MARKER_POSITION") == "before") {
					$sPush .= $active.$navigationLocalized;
					}
					elseif($this->_config->getConfigString("NAVIGATION_ACTIVE_MARKER_POSITION") == "after") {
					$sPush .= $navigationLocalized.$active;
					}
					elseif($this->_config->getConfigString("NAVIGATION_ACTIVE_MARKER_POSITION") == "disabled") {
					$sPush .= $navigationLocalized;
					}

					$sPush .="</a>";

					# Add entry ordered to array
					$orderedNavi[$naviPosition] = $sPush;
						
					}*/

				}

			} else {
				throw new CaramelException(10);
			}

		}
			

		#### Subpages

		/*foreach($this->_dataBase->page->page as $subpage) {
				
			$xPathResultSubRecord = $subpage->xpath('record[@lang="'.$lang.'"]');

			if(count($xPathResultSubRecord) > 0) {

				foreach($xPathResultSubRecord as $subrecord) {
						
					$navigationLocalized = "";
					$active = "";
					$titletagLocalized = "";
						
					# Localized navigation-tag
					$navigationLocalized = (string)$subrecord->navigation;
						
					# Get navi-position
					$naviPosition = (int)$subrecord->navigation->attributes()->pos;
						
					# Build active marker
					if(((string)$subpage->attributes()->name) == $pageName) {
						$active = $this->_config->getConfigString("NAVIGATION_ACTIVE_MARKER");
					}
						
					# Localized title-tag
					$titletagLocalized = (string)$subrecord->titletag;
						
					# Get Parameters before ampersand
					$newQueryString = $this->getParametersBefore();
						
					# Concatenate link for navigation
					$naviLink = (empty($_SERVER['QUERY_STRING']) ? '?' : $newQueryString).'display=';


					# Build single navigation links in <li>-Tags
					if($naviPosition!=-1) {

						$sPush = "\n\t\t<ul>\n\t\t\t<li><a";
							
						# Set navigation class
						if($this->_config->getConfigString("NAVIGATION_CLASS") !="disabled") {
							$sPush .= $this->_config->getConfigString("NAVIGATION_CLASS");
						}
						 
						# Define link-syntax (speaking urls or not)


						if($this->_config->getConfigString("SPEAKING_URLS") == "false") {
							$sPush .= " href=\"".$naviLink.(string)$subpage->attributes()->name."\"";
						}
						elseif($this->_config->getConfigString("SPEAKING_URLS") == "true") {
							$sPush .= " href=\"".$this->getParametersBefore().'/'.(string)$subpage->attributes()->name."/\"";
						}
							

						# Set rel-attribute
						# DEACTIVATED BECAUSE OF HTML5 DOCTYPE
						#if($this->_config->getConfigString("NAVIGATION_REL") !="disabled") {
						#	$sPush .= $this->_config->getConfigString("NAVIGATION_REL");
						#}

						$sPush .= " title=\"".$titletagLocalized."\">";

						# Evaluate position of NAVIGATION_ACTIVE_MARKER
						if($this->_config->getConfigString("NAVIGATION_ACTIVE_MARKER_POSITION") == "before") {
							$sPush .= $active.$navigationLocalized;
						}
						elseif($this->_config->getConfigString("NAVIGATION_ACTIVE_MARKER_POSITION") == "after") {
							$sPush .= $navigationLocalized.$active;
						}
						elseif($this->_config->getConfigString("NAVIGATION_ACTIVE_MARKER_POSITION") == "disabled") {
							$sPush .= $navigationLocalized;
						}

						$sPush .="</a></li>\n\t\t</ul>";
							
						# Add entry ordered to array
						$orderedSubNavi[$naviPosition] = $sPush;

					}

				}

			} else {
				throw new CaramelException(10);
			}

		}*/


		# Read ordered array entries
		//TODO: Do it not here!
		for($i=1; $i<=sizeof($orderedNavi); $i++) {
			$navigation .= $orderedNavi[$i];
				
			# Insert subpage if exists
			if(!empty($orderedSubNavi[$i])) {
				$navigation .= $orderedSubNavi[$i]."\n\t";
			}
				
			$navigation .= "</li>";
		}

		$navigation .= "\n</ul>\n";
		
		
			
		return $navigation;
		
	}

}
?>