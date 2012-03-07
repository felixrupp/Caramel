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

	# Attributes
	private $_config;
	private $_dataBase;
	private $_templateView;
	
	# Constants
	const VERSION = "0.2.2";
	const VERSION_DATE = "2012-03-07";
		

	/**
	 * Constructor
	 */
	public function FrontendController() {

		# Get Configurator 
		$this->_config = ConfigurationModel::getConfigurationModel();
		
		# Get TemplatingEngine
		$this->_templateView = new TemplateView($this->_config->getConfigStringAction("TEMPLATE"));
		
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
		$pageId = NULL;
		
		if(!$pageName) { // no page is set for display
			
			try {
				$pageId = $this->_config->getConfigStringAction("STARTPAGE");
			}
			catch(CaramelException $e) {
				$e->getDetails();
			}
			
			$pageName = NULL;
		}
		
		try {
			$navigation = $this->_dataBase->getWebsiteNavigationAction($lang); # This is an array with to much information for navigation
			
			# Build navigation links from given information. Returned array is very compact
			$navigation = $this->getNavigationLinks($navigation);
			
			$content = $this->_dataBase->getWebsiteContentAction($lang, $pageName, $pageId); # This is a string with our content
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
				
		$this->_templateView->assign("content", $content);
		$this->_templateView->assign("navigation", $navigation);
		$this->_templateView->assign("languageSelector", $this->getLanguageSelector());
		$this->_templateView->assign("footer", $this->getFooter());
		
		$this->_templateView->render();
		
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
		
		
				if(preg_match("/[a-z]{2}/", $language) && in_array($language, $this->_dataBase->getAllLanguagesAction())) {
					header("Location: ./?lang=".$language);
				}
				else {
					header("Location: ./?lang=".$defaultLanguage);
				}
		
			}
			elseif($speakingUrls == "true"){
		
				$language = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
				$language = strtolower(substr(chop($language[0]),0,2));
		
				if(preg_match("/[a-z]{2}/", $language) && in_array($language, $this->_dataBase->getAllLanguagesAction())) {
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
	 * @return string Version information comment
	 */
	public function versionInformationAction() {
		
		$comment = "<!-- \n######### Caramel CMS\n######### Version: ".self::VERSION."\n######### Release: ".self::VERSION_DATE."\n\n######### Dual-licensed under the MIT-License: http://www.opensource.org/licenses/mit-license.php and the GNU GPL: http://www.gnu.org/licenses/gpl.html\n\n######### Copyright (c) Felix Rupp, Nicole Reinhardt\n\n######### http://www.caramel-cms.com/\n -->\n";
				
		return $comment;
	
	} // End of method declaration
	
	
	/**
	 * Print out current language code in index.php
	 * 
	 * @return string Language code for current language
	 */
	 public function languageCodeAction() {
	 
	 	return $this->getLanguage();
	 	
	 } // End of method declaration
	
	
	/**
	 * Print out head-tag in index.php
	 * 
	 * @return string Whole head-tag
	 */	
	public function headTagAction() {
		
		$metaGenerator = "<meta name=\"generator\" content=\"Caramel CMS ".self::VERSION."\">";
		
		$lang = $this->getLanguage();
		$pageName = $this->getDisplay();
		$pageId = NULL;
		
		try {
			
			$metaRobots = '<meta name="robots" content="'.$this->_config->getConfigStringAction('ROBOTS').'">';
			
			if(!$pageName) { // no page is set for display
				$pageId = $this->_config->getConfigStringAction("STARTPAGE");
				$pageName = NULL;
			}
			
			$meta = $this->_dataBase->getAllMetaTagsAction($lang, $pageName, $pageId).$metaRobots."\n".$metaGenerator."\n";
		
			$title = $this->_config->getConfigStringAction("WEBSITE_TITLE").$this->_config->getConfigStringAction("WEBSITE_TITLE_SEPERATOR").$this->_dataBase->getWebsiteTitleAction($lang, $pageName, $pageId);
		
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
		
		$headTag = $this->getBaseUrl()."\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n\n".$meta."\n<link rel=\"shortcut icon\" href=\"favicon.ico\" type=\"image/ico\">\n\n<title>".$title."</title>\n\n";
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
	protected function getNavigationLinks($navigationArray) {
		
		$navigation = array();
		
		# Get Parameters before ampersand
		$newQueryString = $this->getParametersBefore();
			
		# Concatenate link for navigation
		$naviLink = (empty($_SERVER['QUERY_STRING']) ? '?' : $newQueryString).'display=';
	
		# Set navigation class
		try {
			$navClass = $this->_config->getConfigStringAction("NAVIGATION_CLASS");
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
		
		if($navClass !="") {
			$navigationClass = ' class="'.$this->_config->getConfigStringAction("NAVIGATION_CLASS");
		} else {
			$navigationClass = "";
		}
	
		foreach($navigationArray as $pageId => $page) {
			
			# Active Marker
			if($page["path"] == $this->getDisplay()) {
			
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
				
			} else {
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
			if($page["pos"]!=-1) { # Negative values are not appearing in standard navigation
				
				$link = "<a";
				
				# Set navigation class
				$link .= $navigationClass.$activeClass;
				
				# Define link-syntax (speaking urls or not)
				//TODO: try-catch
				if($this->_config->getConfigStringAction("SPEAKING_URLS") == "false") {
					$link .= " href=\"".$naviLink.$page["path"]."\"";
				}
				elseif($this->_config->getConfigStringAction("SPEAKING_URLS") == "true") {
					$link .= " href=\"".$this->getParametersBefore().'/'.$page["path"]."/\"";
				}
				
				# Set rel-attribute
				# DEACTIVATED BECAUSE OF HTML5 DOCTYPE
				#if($this->_config->getConfigStringAction("NAVIGATION_REL") !="disabled") {
				#	$link .= $this->_config->getConfigStringAction("NAVIGATION_REL");
				#}
				
				$link .= " title=\"".$page["titletag"]."\">";
				
				# Evaluate position of NAVIGATION_ACTIVE_MARKER
				//TODO: Try-catch
				if($this->_config->getConfigStringAction("NAVIGATION_ACTIVE_MARKER_POSITION") == "before") {
					$link .= $active.$page["navigation"];
				}
				elseif($this->_config->getConfigStringAction("NAVIGATION_ACTIVE_MARKER_POSITION") == "after") {
					$link .= $page["navigation"].$active;
				}
				elseif($this->_config->getConfigStringAction("NAVIGATION_ACTIVE_MARKER_POSITION") == "disabled") {
					$link .= $page["navigation"];
				}
				
				$link .="</a>";
				
				$navigation[$pageId]["link"] = $link;
				
				
				# Subpage links
				
				foreach($page["subpages"] as $subPageId => $page) {
					
					# Active Marker
					//TODO: Try-catch
					if($page["path"] == $this->getDisplay()) {
						$active = $this->_config->getConfigStringAction("NAVIGATION_ACTIVE_MARKER");
					} else {
						$active = "";
					}
						
					# Build navigation link
					if($page["pos"]!=-1) { # Negative values are not appearing in standard navigation
					
						$link = "<a";
					
						# Set navigation class
						$link .= $navigationClass;
					
						# Define link-syntax (speaking urls or not)
						//TODO: Try-catch
						if($this->_config->getConfigStringAction("SPEAKING_URLS") == "false") {
							$link .= " href=\"".$naviLink.$page["path"]."\"";
						}
						elseif($this->_config->getConfigStringAction("SPEAKING_URLS") == "true") {
							$link .= " href=\"".$this->getParametersBefore().'/'.$page["path"]."/\"";
						}
									
						# Set rel-attribute
						# DEACTIVATED BECAUSE OF HTML5 DOCTYPE
						#if($this->_config->getConfigStringAction("NAVIGATION_REL") !="disabled") {
						#	$link .= $this->_config->getConfigStringAction("NAVIGATION_REL");
						#}
					
						$link .= " title=\"".$page["titletag"]."\">";
					
						# Evaluate position of NAVIGATION_ACTIVE_MARKER
						//TODO: Try-catch
						if($this->_config->getConfigStringAction("NAVIGATION_ACTIVE_MARKER_POSITION") == "before") {
							$link .= $active.$page["navigation"];
						}
						elseif($this->_config->getConfigStringAction("NAVIGATION_ACTIVE_MARKER_POSITION") == "after") {
							$link .= $page["navigation"].$active;
						}
						elseif($this->_config->getConfigStringAction("NAVIGATION_ACTIVE_MARKER_POSITION") == "disabled") {
							$link .= $page["navigation"];
						}
					
						$link .="</a>";
					
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
	 * @return string All language selectors
	 */
	protected function getLanguageSelector() {
		
		$selectorLinks = array();
		
		try {
			$allLangs = $this->_dataBase->getAllLanguagesAction();
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
	 * @return string Website footer
	 */
	protected function getFooter() {

		$facebookLike = "";
		$languageSelector = "";
		
		/*try {
			$facebookLike = $this->getSocialbar();
		}
		catch(CaramelException $e) {
			echo $e->getDetails();
		}*/
		
		
		try {
			$langSelectInFooter = $this->_config->getConfigStringAction("LANGUAGE_SELECTOR_IN_FOOTER");
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
		
		if($langSelectInFooter == 'true') {
			$languageSelector = $this->getLanguageSelector()."&nbsp;";
		}
		
		$footer = $languageSelector.$facebookLike;
		
		return $footer;
	
	} // End of method declaration
	


	/**
	 * Extract language from GET-query
	 * 
	 * @return string Actual language
	 */
	protected function getLanguage() {
		
		try {
			$allLangs = $this->_dataBase->getAllLanguagesAction();
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
	 * @return string Actual page displayed
	 */
	protected function getDisplay() {
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
	 * @return string New querystring for building correct URL
	 */
	protected function getParametersBefore() {
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
		
		#var_dump($_SERVER['REQUEST_URI']);
		#var_dump($this->getLanguage());
		#var_dump($newQueryString);
		
		return $newQueryString;
		
	} // End of method declaration
	
	
	/**
	 * Get parameters of GET-query behind ampersand 
	 * 
	 * @return string New querystring for building correct URL
	 */
	protected function getParametersBehind() {
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
	 * @return string Base url
	 */
	protected function getBaseUrl() {
	
		try {
			$speakingUrls = $this->_config->getConfigStringAction("SPEAKING_URLS");
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
			
		if($speakingUrls == "true") {
			return "<base href=\"".$this->_config->getConfigStringAction('BASE')."\">\n";
		} else {
			return "";
		}
		
	} // End of method declaration
	
	
	
	
	
	/**
	 * Return minified JS and CSS files
	 * 
	 * @return string Minified js and css
	 * @deprecated
	 */
	protected function getJsAndCss() {
		
		$jsAndCss = "<link rel=\"stylesheet\" type=\"text/css\" href=\"caramel/min/?f=caramel/css/screen.css\">\n";
		$jsAndCss .= "<script type=\"text/javascript\" src=\"caramel/min/?f=caramel/js/script.js\"></script>";
				
		return $jsAndCss;
		
	} // End of method declaration
	
	
	/**
	 * Print out facebook like button in index.php
	 * 
	 * @return string Facebook like button
	 * @deprecated
	 */
	protected function getSocialbar() {
	 
		$lang = $this->getLanguage();
		$pageName = $this->getDisplay();
		 
		$xPathResultFacebook = $this->_dataBase->xpath('//page[@name="'.$pageName.'"]/record[@lang="'.$lang.'"]/socialbar');
		 
		if(count($xPathResultFacebook)>0) {
		 	
			if(((string)$xPathResultFacebook[0]) == "true") {
		 		
				if(isset($_SERVER['HTTPS'])) {
					if($_SERVER['HTTPS'] == "" or $_SERVER['HTTPS'] == null) {
						$url = "https://";
					}
				} else {
					$url = "http://";
				}
	
		 		$url .= $_SERVER['SERVER_NAME'];
		 		
		 		$url .= "/";
		 		
		 		$url = urlencode($url);
		 	
		 		# Define locale if not english
		 		if($this->getLanguage()!="en") {
		 			$facebookLang = "locale=".$this->getLanguage()."_".strtoupper($this->getLanguage())."&amp;";
		 		} else {
		 			$facebookLang = "";
		 		}
			 		
		 		$facebookLike = '<iframe src="http://www.facebook.com/plugins/like.php?href='.$url.'&amp;'.$facebookLang.'send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" style="border:none; overflow:hidden; width:150px; height:20px; background:transparent;"></iframe>';
			 		
		 	} else {
		 		$facebookLike = "";
	 		}
		 
		 }
		 else {
		 	throw new CaramelException(10);
		 }
			 
		 return $facebookLike;
		 
	} // End of method declaration


} // End of class declaration

?>