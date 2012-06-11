<?php

/**
 * @package inc
 * @subpackage controller
 */

/**
 * Imports
 */
require_once BASEDIR.'/inc/utility/SimpleXMLExtended.php';
require_once BASEDIR.'/inc/utility/CaramelException.php';
require_once BASEDIR.'/inc/model/DatabaseModel.php';
require_once BASEDIR.'/inc/model/ConfigurationModel.php';
require_once BASEDIR.'/inc/view/TemplateView.php';

/**
 *
 * FrontendController class
 * 
 * @author Felix Rupp <kontakt@felixrupp.com>
 * @version $Id$
 * @copyright Copyright (c) 2011, Felix Rupp, Nicole Reinhardt
 * @license http://www.opensource.org/licenses/mit-license.php MIT-License
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 * 
 * @package inc
 * @subpackage controller
 */
class FrontendController {

	/**
	 * @var ConfigurationModel $_config Holds an instance of a Config
	 */
	private $_config;

	/**
	 * @var DatabaseModel $_dataBase Holds the Database
	 */
	private $_dataBase;
	
	/**
	 * @var TemplateView $_templateView Holds an instance of our TemplatingEngine
	 */
	private $_templateView;
	
	/**
	 * @var String VERSION Constant for system version
	 */
	const VERSION = "0.2.7";
	
	/**
	 * @var String VERSION Constant for version date
	 */
	const VERSION_DATE = "2012-06-10";
		

	/**
	 * Constructor
	 * 
	 * @return void
	 */
	public function FrontendController() {

		# Get Configurator 
		$this->_config = ConfigurationModel::getConfigurationModel();
		
		# Get TemplatingEngine
		$this->_templateView = new TemplateView($this->_config->getTemplateAction());
		
		# Get Database 
		$this->_dataBase = DatabaseModel::getDatabaseModel();		
				
	} // End of constructor declaration
	
	
	
# Main content actions:

	/**
	 * This method assigns needed content to our template engine and renders the template.
	 * 
	 * @return void
	 */
	public function frontendOutputAction() {
		
		$lang = $this->getLanguage();
		$pageName = $this->getDisplay();
		
		try {
			if(!$pageName) { // no page is set for display
				$pageId = $this->_config->getConfigStringAction("STARTPAGE");
			}
			else {
				$pageId = $this->_dataBase->getPageId($pageName);
			}
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
		
		try {
			$navigation = $this->_dataBase->frontendGetWebsiteNavigationAction($lang); # This is an array with to much information for navigation
			
			# Build navigation links from given information. Returned array is very compact
			$navigation = $this->getNavigationLinks($navigation);
			
			$content = $this->_dataBase->frontendGetWebsiteContentAction($lang, $pageId); # This is a string with our content
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
				
		$this->_templateView->assign("content", $content);
		$this->_templateView->assign("navigation", $navigation);
		$this->_templateView->assign("languageSelector", $this->getLanguageSelector());
		$this->_templateView->assign("footer", $this->getFooter());
		
		$this->_templateView->renderGzipped();
		
	} // End of method declaration
	
	
	
	/**
	 * Redirects the user to the language set in browser
	 * 
	 * @return void
	 */
	public function languageRedirectAction() {
		
		if(!isset($_GET['lang'])) {
			
			try {
				$speakingUrls = $this->_config->getConfigStringAction("SPEAKING_URLS");
				$defaultLanguage = $this->_config->getConfigStringAction("DEFAULT_LANGUAGE");
			}
			catch(CaramelException $e) {
				$e->getDetails();
			}
		
			if($speakingUrls == "false") {
		
				$language = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
				$language = strtolower(substr(chop($language[0]),0,2));
		
		
				if(preg_match("/[a-z]{2}/", $language) && in_array($language, $this->_dataBase->frontendGetAllLanguagesAction())) {
					header("Location: ./?lang=".$language);
				}
				else {
					header("Location: ./?lang=".$defaultLanguage);
				}
		
			}
			elseif($speakingUrls == "true"){
		
				$language = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
				$language = strtolower(substr(chop($language[0]),0,2));
		
				if(preg_match("/[a-z]{2}/", $language) && in_array($language, $this->_dataBase->frontendGetAllLanguagesAction())) {
					header("Location: ./".$language."/");
				}
				else {
					header("Location: ./".$defaultLanguage."/");
				}
		
			}
		
		}
		
	} // End of method declaration
	
	
	
	/**
	 * Print out version-information in index.php
	 * 
	 * @return Version information comment
	 */
	public function versionInformationAction() {
		
		$comment = "<!-- \n######### Caramel CMS\n######### Version: ".self::VERSION."\n######### Release: ".self::VERSION_DATE."\n\n######### Dual-licensed under the MIT-License: http://www.opensource.org/licenses/mit-license.php and the GNU GPL: http://www.gnu.org/licenses/gpl.html\n\n######### Copyright (c) Felix Rupp, Nicole Reinhardt\n\n######### http://www.caramel-cms.com/\n -->\n";
				
		return $comment;
	
	} // End of method declaration
	
	
	
	/**
	 * Print out current language code in index.php
	 * 
	 * @return Language code for current language
	 */
	public function languageCodeAction() {
	 
		return $this->getLanguage();
	 	
	} // End of method declaration
	
	 
	
	/**
	 * Print out head-tag in index.php
	 * 
	 * @return Whole head-tag
	 */	
	public function headTagAction() {
		
		$metaGenerator = "<meta name=\"generator\" content=\"Caramel CMS ".self::VERSION."\">";
		
		$lang = $this->getLanguage();
		$pageName = $this->getDisplay();
		
		try {
			
			$metaRobots = '<meta name="robots" content="'.$this->_config->getConfigStringAction('ROBOTS').'">';
						
			if(!$pageName) { // no page is set for display
				$pageId = $this->_config->getConfigStringAction("STARTPAGE");
			} else {
				$pageId = $this->_dataBase->getPageId($pageName);
			}
			
			$meta = $this->_dataBase->frontendGetAllMetaTagsAction($lang, $pageId).$metaRobots."\n".$metaGenerator."\n";
		
			$title = $this->_config->getConfigStringAction("WEBSITE_TITLE").$this->_config->getConfigStringAction("WEBSITE_TITLE_SEPERATOR").$this->_dataBase->frontendGetWebsiteTitleAction($lang, $pageId);
		
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
		
		$headTag = $this->getBaseUrl()."\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n\n".$meta."\n\n<title>".$title."</title>\n\n";
		
		
		$additionalCssFile = $this->_dataBase->frontendGetPageAdditionalCss($pageId);
		if(strlen($additionalCssFile) > 1) {		
			$this->_templateView->addCssFile($additionalCssFile);
		}
		
		
		$additionalJsFile = $this->_dataBase->frontendGetPageAdditionalJs($pageId);
		if(strlen($additionalJsFile) > 1) {
			$this->_templateView->addJsFile($additionalJsFile);
		}
		
		
		$headTag .= $this->_templateView->addCssJs();
		
		return $headTag;
		
	} // End of method declaration


	
	
	
	
##################################################
### Helper functions:
##################################################

	
	/**
	 * This method build our navigation links from given information
	 * Note: Navigation is restricted to one sublevel
	 * 
	 * @param array $navigationArray Array with detailed navigation information
	 * 
	 * @return Array with link information for navigation
	 */
	private function getNavigationLinks($navigationArray) {
		
		$navigation = array();
		
		# Get Parameters before ampersand
		$newQueryString = $this->getParametersBefore();
			
		# Concatenate link for navigation
		$naviLink = (empty($_SERVER['QUERY_STRING']) ? '?' : $newQueryString).'display=';
	
		# Set navigation class
		try {
			$navClass = $this->_config->getConfigStringAction("NAVIGATION_CLASS");
			
			if($navClass !="") {
				$navigationClass = ' class="'.$this->_config->getConfigStringAction("NAVIGATION_CLASS");
			} else {
				$navigationClass = "";
			}
			
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
		
		
		# Test if STARTPAGE is active or not
		$pageName = $this->getDisplay();
				
		try {
			if(!$pageName) {
				// no page is set for display
				$pageId = intval($this->_config->getConfigStringAction("STARTPAGE"));
			}
			else {
				$pageId = intval($this->_dataBase->getPageId($pageName));
			}
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}

		
		
		# For loop to build nav links
		foreach($navigationArray as $navPageId => $page) {
			
			# Active Marker
			if(intval($navPageId) == $pageId) {
			
				try {
					$active = $this->_config->getConfigStringAction("NAVIGATION_ACTIVE_MARKER");
					
					if(strlen($navigationClass)<1) { # No navigationClass set
						$activeClass = ' class="'.$this->_config->getConfigStringAction("NAVIGATION_ACTIVE_CLASS").'"';
					}
					else { # navigationClass set
						$activeClass = " ".$this->_config->getConfigStringAction("NAVIGATION_ACTIVE_CLASS").'"';
					}
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
				
			} 
			else {
				$active = "";
				
				if(strlen($navigationClass)<1) {
					# No navigationClass set
					$activeClass = "";
				}
				else { # navigationClass set
					$activeClass = '"';
				}
				
			}
			
			# Build navigation link
			if($page["visible"]=="true") { # false values are not appearing in standard navigation
				
				$link = "<a";
				
				# Set navigation class
				$link .= $navigationClass.$activeClass;
				
				# Define link-syntax (speaking urls or not)
				try {
					if($this->_config->getConfigStringAction("SPEAKING_URLS") == "false") {
						$link .= " href=\"".$naviLink.$page["path"]."\"";
					}
					elseif($this->_config->getConfigStringAction("SPEAKING_URLS") == "true") {
						$link .= " href=\"".$this->getParametersBefore().'/'.$page["path"]."/\"";
					}
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
				
				# Set rel-attribute
				# DEACTIVATED BECAUSE OF HTML5 DOCTYPE
				#if($this->_config->getConfigStringAction("NAVIGATION_REL") !="disabled") {
				#	$link .= $this->_config->getConfigStringAction("NAVIGATION_REL");
				#}
				
				$link .= " title=\"".$page["titletag"]."\">";
				
				# Evaluate position of NAVIGATION_ACTIVE_MARKER
				try {
					if($this->_config->getConfigStringAction("NAVIGATION_ACTIVE_MARKER_POSITION") == "before") {
						$link .= $active.$page["navigation"];
					}
					elseif($this->_config->getConfigStringAction("NAVIGATION_ACTIVE_MARKER_POSITION") == "after") {
						$link .= $page["navigation"].$active;
					}
					elseif($this->_config->getConfigStringAction("NAVIGATION_ACTIVE_MARKER_POSITION") == "disabled") {
						$link .= $page["navigation"];
					}
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
				
				$link .="</a>";
				
				$navigation[$navPageId]["path"] = $page["path"];
				$navigation[$navPageId]["link"] = $link;
				
				
				# Subpage links
				
				foreach($page["subpages"] as $subPageId => $page) {
					
					# Active Marker
					if(intval($subPageId) == $pageId) {
					
						try {
							$active = $this->_config->getConfigStringAction("NAVIGATION_ACTIVE_MARKER");
							
							if(strlen($navigationClass)<1) { # No navigationClass set
								$activeClass = ' class="'.$this->_config->getConfigStringAction("NAVIGATION_ACTIVE_CLASS").'"';
							}
							else { # navigationClass set
								$activeClass = " ".$this->_config->getConfigStringAction("NAVIGATION_ACTIVE_CLASS").'"';
							}
						}
						catch(CaramelException $e) {
							$e->getDetails();
						}
						
					} 
					else {
						$active = "";
						
						if(strlen($navigationClass)<1) {
							# No navigationClass set
							$activeClass = "";
						}
						else { # navigationClass set
							$activeClass = '"';
						}
						
					}
						
					# Build navigation link
					if($page["visible"]=="true") { # false values are not appearing in standard navigation
					
						$link = "<a";
					
						# Set navigation class
						$link .= $navigationClass;
					
						# Define link-syntax (speaking urls or not)
						try {
							if($this->_config->getConfigStringAction("SPEAKING_URLS") == "false") {
								$link .= " href=\"".$naviLink.$page["path"]."\"";
							}
							elseif($this->_config->getConfigStringAction("SPEAKING_URLS") == "true") {
								$link .= " href=\"".$this->getParametersBefore().'/'.$page["path"]."/\"";
							}
						}
						catch(CaramelException $e) {
							$e->getDetails();
						}
					
									
						# Set rel-attribute
						# DEACTIVATED BECAUSE OF HTML5 DOCTYPE
						#if($this->_config->getConfigStringAction("NAVIGATION_REL") !="disabled") {
						#	$link .= $this->_config->getConfigStringAction("NAVIGATION_REL");
						#}
					
						$link .= " title=\"".$page["titletag"]."\">";
					
						# Evaluate position of NAVIGATION_ACTIVE_MARKER
						try {
							if($this->_config->getConfigStringAction("NAVIGATION_ACTIVE_MARKER_POSITION") == "before") {
								$link .= $active.$page["navigation"];
							}
							elseif($this->_config->getConfigStringAction("NAVIGATION_ACTIVE_MARKER_POSITION") == "after") {
								$link .= $page["navigation"].$active;
							}
							elseif($this->_config->getConfigStringAction("NAVIGATION_ACTIVE_MARKER_POSITION") == "disabled") {
								$link .= $page["navigation"];
							}
						}
						catch(CaramelException $e) {
							$e->getDetails();
						}
					
						$link .="</a>";
					
						$navigation[$pageId]["subpages"][$subPageId]["path"] = $page["path"];
						$navigation[$pageId]["subpages"][$subPageId]["link"] = $link;
					
					}
				}
				
				
			}			
			
		}
				
		return $navigation;
		
	} // End of method declaration
	
		
	
	/**
	 * Print out language selector in index.php
	 * 
	 * @return All language selectors
	 */
	private function getLanguageSelector() {
		
		$selectorLinks = array();
		
		try {
			$allLangs = $this->_dataBase->frontendGetAllLanguagesAction();
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
		
		foreach($allLangs as $langCode) {
			
			if($this->getLanguage() != $langCode) {
			
				# Get Parameters before ampersand
				$newQueryString = $this->getParametersBehind();
				
				try {
					$speakingUrls = $this->_config->getConfigStringAction("SPEAKING_URLS");
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
				
				if($speakingUrls == "false") {
					array_push($selectorLinks, '<a title="" href="?lang=en'.$newQueryString.'">'.strtoupper($langCode).'</a>');
				}
				elseif($speakingUrls == "true") {
					array_push($selectorLinks, '<a title="" href="'.substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], $this->getLanguage())).$langCode.$newQueryString.'">'.strtoupper($langCode).'</a>');
				}	

			} else {
				array_push($selectorLinks, strtoupper($langCode));
			}
		}
		
		$languageSelector = "";
		
		if(count($selectorLinks) > 1) {
			foreach($selectorLinks as $key => $link) {
			
				if($key == count($selectorLinks)-1) {
					$languageSelector .= $link;
				} else {
					
					try {
						$languageSelector .= $link.$this->_config->getConfigStringAction("LANGUAGE_SELECTOR_SEPERATOR");
					}
					catch(CaramelException $e) {
						$e->getDetails();
					}
				}
			}
		}
		
		return "\t".$languageSelector."\n";	
		
	} // End of method declaration
	
	
	
	/**
	 * Print out footer in footer of index.php
	 * 
	 * @return Website footer
	 */
	private function getFooter() {

		$languageSelector = "";
		
		try {
			$langSelectInFooter = $this->_config->getConfigStringAction("LANGUAGE_SELECTOR_IN_FOOTER");
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
		
		if($langSelectInFooter == 'true') {
			$languageSelector = $this->getLanguageSelector()."&nbsp;";
		}
		
		$footer = $languageSelector;
		
		return $footer;
	
	} // End of method declaration
	


	/**
	 * Extract language from GET-query
	 * 
	 * @return Actual language
	 */
	private function getLanguage() {
		
		try {
			$allLangs = $this->_dataBase->frontendGetAllLanguagesAction();
			$defaultLanguage = $this->_config->getConfigStringAction("DEFAULT_LANGUAGE");
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
			
		if(isset($_GET['lang']) && in_array($_GET['lang'], $allLangs)) { # Test if set language is in our language array
			$language = $_GET['lang'];
		}
		else {
			$language = $defaultLanguage;
		}
		
		return $language;
		
	} // End of method declaration
	
	
	
	/**
	 * Get display from GET-query
	 * 
	 * @return Actual page displayed
	 */
	private function getDisplay() {
		
		if(isset($_GET['display'])) {
			
			$display = $_GET['display'];
			
		}
		else {
			$display = FALSE;
		}
		
		return $display;
		
	} // End of method declaration
	
	
	
	/**
	 * Get parameters of GET-query before ampersand 
	 * 
	 * @return New querystring for building correct URL
	 */
	private function getParametersBefore() {
		$serverQueryString = $_SERVER['QUERY_STRING'];
					
		try {
			$speakingUrls = $this->_config->getConfigStringAction("SPEAKING_URLS");
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
			
		if($speakingUrls == "false") {
				
			if(preg_match('/lang/',$serverQueryString)) {		
				$newQueryString = '?'.substr($serverQueryString,0,7).'&amp;';
			}
			elseif (!preg_match('/lang/',$serverQueryString) and preg_match('/display/',$serverQueryString)) {
				$newQueryString = '?';
			}
			else {
				$newQueryString = '';
			}
			
		}
		
		if($speakingUrls == "true") {
			$newQueryString = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], $this->getLanguage())+strlen($this->getLanguage()));
		}
		
		return $newQueryString;
		
	} // End of method declaration
	
	
	
	/**
	 * Get parameters of GET-query behind ampersand 
	 * 
	 * @return New querystring for building correct URL
	 */
	private function getParametersBehind() {
		$serverQueryString = $_SERVER['QUERY_STRING'];
					
		try {
			$speakingUrls = $this->_config->getConfigStringAction("SPEAKING_URLS");
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
			
		if($speakingUrls == "false") {
		
			if(preg_match('/lang/',$serverQueryString)) {				
						
				if(preg_match('/display/',$serverQueryString)) {
					$ampZeichen = '&amp;';
				}
				else {
					$ampZeichen = '';
				}
				$newQueryString = $ampZeichen.substr($serverQueryString,8);
			}
			elseif (preg_match('/display/',$serverQueryString) AND !preg_match('/lang/',$serverQueryString)) {
				$newQueryString = '&amp;'.substr($serverQueryString,0);
			}
			else {
				$newQueryString = '';
			}
			
			return $newQueryString;
			
		}
		
		elseif($speakingUrls == "true") {
				
			if(isset($_GET['display'])) {
				$newQueryString = '/'.substr($serverQueryString,16).'/';
			} else {
			    $newQueryString = '/'.substr($serverQueryString,16);
			}
			
			return $newQueryString;
			
		}
		
	} // End of method declaration
	
	
	
	/**
	 * Print out base url in index.php
	 * 
	 * @return The Base-URL
	 */
	private function getBaseUrl() {
	
		try {
			$speakingUrls = $this->_config->getConfigStringAction("SPEAKING_URLS");
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
			
		if($speakingUrls == "true") {
			
			try {
				return "<base href=\"".$this->_config->getConfigStringAction('BASE')."\">\n";
			}
			catch(CaramelException $e) {
				$e->getDetails();
			}
			
		} else {
			return "";
		}
		
	} // End of method declaration


} // End of class declaration

?>