<?php

# Imports
require_once(dirname(__FILE__).'/settings.php'); # Settings with Constants
require_once(dirname(__FILE__).'/Configurator.php'); # Singleton for Configfile
require_once(dirname(__FILE__).'/Browser.php'); # Browserselection

/**
 *
 * Caramel Main-Class
 * 
 * @author SieRupp GbR
 * @version 0.8
 * 
 * Date: 09.05.2011 16:18 CET
 * 
 * Copyright (c) by SieRupp GbR, Nathanael Siering and Felix Rupp
 * All rights reserved.
 * No copy, reproduction or use without written permission of SieRupp GbR.
 * http://www.sierupp.com/
 * 
 */
class Caramel {

	# Attributes
	private $_config;
	private $_dataBase;
	private $_allLanguages = array();
	
	# Constants
	const VERSION = "0.8.1";
	const VERSION_DATE = "2011-05-22";
		

	/**
	 *
	 * Caramel class-constructor
	 * Last changed: 03.04.2011
	 *
	 */
	public function Caramel() {
		
		# Get Configurator Singleton
		$this->_config = Configurator::getConfigurator("site");
		
		# Try to import the database-file
		try {			
			# Import dataBase-file:
			$this->_dataBase = simplexml_load_file(BASEDIR.$this->_config->getConfigString("DOCUMENT_SUBFOLDER").'/data.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
		}
		catch(Exception $e) {
			var_dump($e->getMessage());
			printf("\n\nAchtung: Eine der relevanten Dateien konnte nicht geladen werden!");
		}
		
		# Fill our languages array
		$xPathResult = $this->_dataBase->xpath('//@lang'); # Find all lang-elements
		$xPathResult= array_unique($xPathResult); # Remove double entries
		
		foreach($xPathResult as $langCode) {
			array_push($this->_allLanguages, (string)$langCode); # Convert SimpleXMLElements into strings
		}		
				
	} // End of constructor declaration
	
	
	
# Main content functions:


	/**
	 * 
	 * Print out version-information in index.php
	 * Last changed: 22.04.2011
	 * @return Version information comment
	 * 
	 */
	public function versionInformation() {
		
		$comment = "<!-- \n######### Caramel CMS by SieRupp GbR\n######### Version: ".Caramel::VERSION."\n######### Release: ".Caramel::VERSION_DATE."\n\n######### WARNING: No copy, reproduction or use without written permission of SieRupp GbR.\n\n######### Copyright (c) by SieRupp GbR, Nathanael Siering and Felix Rupp\n######### All rights reserved.\n\n######### http://www.sierupp.com/\n -->\n";
		
		return $comment;
	
	} // End of method declaration
	
	
	/**
	 * 
	 * Print out current language code in index.php
	 * Last changed: 27.04.2011
	 * @return Language code for current language
	 * 
	 */
	 public function languageCode() {
	 
	 	return $this->getLanguage();
	 	
	 } // End of method declaration
	
	
	/**
	 * 
	 * Print out head-tag in index.php
	 * Last changed: 22.05.2011
	 * @return Whole head-tag
	 * 
	 */	
	public function headTag() {
			
		$headTag = $this->getBaseUrl()."\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n\n".$this->getMeta()."\n<link rel=\"shortcut icon\" href=\"favicon.ico\" type=\"image/ico\">\n\n<title>".$this->getTitle()."</title>\n\n";
		
		$headTag .= $this->getJsAndCss();
		
		return $headTag;
		
	} // End of method declaration


	/**
	 * 
	 * Print out the content in index.php
	 * Last changed: 20.02.2011
	 * @return Localized content
	 * 
	 */
	public function content() {
		
		$lang = $this->getLanguage();
		$pageName = $this->getDisplay();
			
		$xPathResultContent = $this->_dataBase->xpath('//page[@name="'.$pageName.'"]/record[@lang="'.$lang.'"]/content');
		
		if(count($xPathResultContent)>0) {
			$contentLocalized = $xPathResultContent[0];
		}
		else {
			echo "Error in xml-data.";
			exit;
		}			
					
		return $contentLocalized;	
		   
	} // End of method declaration
	
 
	/**
	 * 
	 * Print out navigation in index.php
	 * Last changed: 20.03.2011
	 * @return Localized navigation
	 * 
	 */
	public function navigation() {
	
		$orderedNavi = array();	
		$orderedSubNavi = array();	
		
		$navigation = "<ul>";
		
				
		foreach($this->_dataBase->page as $page) {
			
			$xPathResultRecord = $page->xpath('record[@lang="'.$this->getLanguage().'"]');
			
			if(count($xPathResultRecord) > 0) {
			
				foreach($xPathResultRecord as $record) {
				
					$navigationLocalized = "";
					$active = "";
					$titletagLocalized = "";
						
					# Localized navigation-tag			
					$navigationLocalized = (string)$record->navigation;
					
					# Get navi-position
					$naviPosition = (int)$record->navigation->attributes()->pos;
					
					# Build active marker
					if(((string)$page->attributes()->name) == $this->getDisplay()) {
						$active = $this->_config->getConfigString("NAVIGATION_ACTIVE_MARKER");
					}
					
					# Localized title-tag
					$titletagLocalized = (string)$record->titletag;
					
					# Get Parameters before ampersand
					$newQueryString = $this->getParametersBefore();
					
					# Concatenate link for navigation
					$naviLink = (empty($_SERVER['QUERY_STRING']) ? '?' : $newQueryString).'display=';
										
					
					# Build single navigation links in <li>-Tags
					if($naviPosition!=-1) {
					
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
						if($this->_config->getConfigString("NAVIGATION_REL") !="disabled") {
							$sPush .= $this->_config->getConfigString("NAVIGATION_REL");
						}
						
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
					    
					}
					
				}
				
			} else {
				echo "Error in xml-data.";
				exit;
			}
			
		}
			
		
		#### Subpages
		
		foreach($this->_dataBase->page->page as $subpage) {
			
			$xPathResultSubRecord = $subpage->xpath('record[@lang="'.$this->getLanguage().'"]');
				
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
					if(((string)$subpage->attributes()->name) == $this->getDisplay()) {
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
						if($this->_config->getConfigString("NAVIGATION_REL") !="disabled") {
							$sPush .= $this->_config->getConfigString("NAVIGATION_REL");
				    	}
				    	
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
				echo "Error in xml-data.";
				exit;
			}
		
	
		}
		
		
		# Read ordered array entries
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
				
	} // End of method declaration
		
	
	/**
	 * 
	 * Print out language selector in index.php
	 * Last changed: 22.04.2011
	 * @return All language selectors
	 * 
	 */
	public function languageSelector() {
		
		$selectorLinks = array();
		
		foreach($this->_allLanguages as $langCode) {
			if($this->getLanguage() != $langCode) {
			
				# Get Parameters before ampersand
				$newQueryString = $this->getParametersBehind();
			
				if($this->_config->getConfigString("SPEAKING_URLS") == "false") {
					array_push($selectorLinks, '<a title="" href="?lang=en'.$newQueryString.'">'.strtoupper($langCode).'</a>');
				}
				elseif($this->_config->getConfigString("SPEAKING_URLS") == "true") {
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
					$languageSelector .= $link.$this->_config->getConfigString("LANGUAGE_SELECTOR_SEPERATOR");
				}
			}
		}
		
		return "\t".$languageSelector."\n";	
		
	} // End of method declaration
	
	
	/**
	 * 
	 * Print out footer in footer of index.php
	 * Last changed: 09.05.2011
	 * @return Website footer
	 * 
	 */
	public function footer() {

		$facebookLike = $this->getFacebookLikeButton();
		
		if($this->_config->getConfigString("LANGUAGE_SELECTOR_IN_FOOTER") == 'true') {
			$languageSelector = $this->languageSelector()."&nbsp;";
		}
		
		$footer = $languageSelector.$facebookLike;
		
		return $footer;
	
	} // End of method declaration
	




# Helper functions:

	/**
	 *
	 * Get Language from GET-query
	 * Last changed: 13.02.2011
	 * @return Actual language
	 *
	 */
	protected function getLanguage() {
	
		if(isset($_GET['lang']) and in_array($_GET['lang'], $this->_allLanguages)) { # Test if set language is in our language array
			$language = $_GET['lang'];
		}
		else {
			$language = "en";
		}
		
		return $language;
		
	} // End of method declaration
	
	
	/**
	 *
	 * Get display from GET-query
	 * Last changed: 13.02.2011
	 * @return Actual page displayed
	 *
	 */
	protected function getDisplay() {
		if(isset($_GET['display'])) {
			$display = $_GET['display'];
		}
		else {
			$display = $this->_config->getConfigString("STARTPAGE");
		}
		
		return $display;
		
	} // End of method declaration
	
	
	/**
	 *
	 * Get parameters of GET-query before ampersand 
	 * Last changed: 20.03.2011
	 * @return New querystring for building correct URL
	 *
	 */
	protected function getParametersBefore() {
		$serverQueryString = $_SERVER['QUERY_STRING'];
					
		if($this->_config->getConfigString("SPEAKING_URLS") == "false") {
				
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
		
		if($this->_config->getConfigString("SPEAKING_URLS") == "true") {
			$newQueryString = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], $this->getLanguage())+strlen($this->getLanguage()));
		}
		
		return $newQueryString;
		
	} // End of method declaration
	
	
	/**
	 *
	 * Get parameters of GET-query behind ampersand 
	 * Last changed: 06.03.2011
	 * @return New querystring for building correct URL
	 *
	 */
	protected function getParametersBehind() {
		$serverQueryString = $_SERVER['QUERY_STRING'];
					
		if($this->_config->getConfigString("SPEAKING_URLS") == "false") {
		
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
		
		elseif($this->_config->getConfigString("SPEAKING_URLS") == "true") {
				
			if(isset($_GET['display'])) {
				$newQueryString = '/'.substr($serverQueryString,16).'/';
			} else {
			    $newQueryString = '/'.substr($serverQueryString,16);
			}
			
			return $newQueryString;
			
		}
		
	} // End of method declaration
	
	
	/**
	 * 
	 * Print out title in title-tag in index.php
	 * Last changed: 13.02.2011
	 * @return Localized website-title
	 * 
	 */
	protected function getTitle() {
		$lang = $this->getLanguage();
		$pageName = $this->getDisplay();
		
		$xPathResultTitle = $this->_dataBase->xpath('//page[@name="'.$pageName.'"]/record[@lang="'.$lang.'"]/title');
		
		if(count($xPathResultTitle)>0) {
			$titleLocalized = $this->_config->getConfigString("WEBSITE_TITLE").$this->_config->getConfigString("WEBSITE_TITLE_SEPERATOR").(string)$xPathResultTitle[0];
		}
		else {
			echo "Error in xml-data.";
			exit;
		}
						
		return $titleLocalized;
	
	} // End of method declaration
	
	
	/**
	 * 
	 * Print out base url in index.php
	 * Last changed: 27.04.2011
	 * @return Base url
	 * 
	 */
	protected function getBaseUrl() {
	
		if($this->_config->getConfigString("SPEAKING_URLS") == "true") {
			return "<base href=\"".$this->_config->getConfigString('BASE')."\">\n";
		} else {
			return "";
		}
		
	} // End of method declaration
	
	
	/**
	 * 
	 * Print out meta-tags in index.php
	 * Last changed: 22.04.2011
	 * @return Meta-tags for author, keywords and description
	 * 
	 */
	protected function getMeta() {
		$lang = $this->getLanguage();
		$pageName = $this->getDisplay();
		
		$xPathResultMetaDescription = $this->_dataBase->xpath('//page[@name="'.$pageName.'"]/record[@lang="'.$lang.'"]/meta[@name="description"]');
		if(count($xPathResultMetaDescription)>0) {
			$metaDescription = "<meta name=\"description\" content=\"".$xPathResultMetaDescription[0]."\">";
		}
		else {
			echo "Error in xml-data.";
			exit;
		}
		
		$xPathResultMetaKeywords = $this->_dataBase->xpath('//page[@name="'.$pageName.'"]/record[@lang="'.$lang.'"]/meta[@name="keywords"]');
		if(count($xPathResultMetaKeywords)>0) {
			$metaKeywords = "<meta name=\"keywords\" content=\"".$xPathResultMetaKeywords[0]."\">";
		}
		else {
			echo "Error in xml-data.";
			exit;
		}
		
		$xPathResultMetaAuthor = $this->_dataBase->xpath('//page[@name="'.$pageName.'"]/record[@lang="'.$lang.'"]/meta[@name="author"]');
		if(count($xPathResultMetaAuthor)>0) {
			$metaAuthor = "<meta name=\"author\" content=\"".$xPathResultMetaAuthor[0]."\">";
		}
		else {
			echo "Error in xml-data.";
			exit;
		}
		
		
		$metaRobots = '<meta name="robots" content="'.$this->_config->getConfigString('ROBOTS').'">';
		
		$metaRevisit = '<meta name="revisit-after" content="'.$this->_config->getConfigString('REVISIT_AFTER').'">';
		
		$metaAudiences = '<meta name="audience" content="all">';
		
		$metaGenerator = "<meta name=\"generator\" content=\"Caramel CMS".self::VERSION."\">";
		
		$metaTags = $metaDescription."\n".$metaKeywords."\n".$metaAuthor."\n".$metaRobots."\n".$metaRevisit."\n".$metaAudiences."\n".$metaGenerator."\n";
		
						
		return $metaTags;
	
	} // End of method declaration
	
	
	/**
	 * 
	 * Return minified JS and CSS files
	 * Last changed: 22.05.2011
	 * @return Minified js and css
	 * 
	 */
	protected function getJsAndCss() {
		
		$jsAndCss = "<link rel=\"stylesheet\" type=\"text/css\" href=\"caramel/min/?f=caramel/css/screen.css\">\n";
		$jsAndCss .= "<script type=\"text/javascript\" src=\"caramel/min/?f=caramel/js/script.js\"></script>";
				
		return $jsAndCss;
		
	} // End of method declaration
	
	
	/**
	 * 
	 * Print out facebook like button in index.php
	 * Last changed: 09.05.2011
	 * @return Facebook like button
	 * 
	 */
	protected function getFacebookLikeButton() {
	 
		$lang = $this->getLanguage();
		$pageName = $this->getDisplay();
		 
		$xPathResultFacebook = $this->_dataBase->xpath('//page[@name="'.$pageName.'"]/record[@lang="'.$lang.'"]/facebook-like');
		 
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
		 		
		 		if(((string)$this->_config->getConfigString("FACEBOOK_LIKE_MODE")) == "site-specific") {
		 			$url .= $_SERVER['REQUEST_URI'];
		 		}
		 		else {
		 			$url .= "/";
		 		}
		 		
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
		 	echo "Error in xml-data.";
		 	exit;
		 }
			 
		 return $facebookLike;
		 
	} // End of method declaration


} // End of class declaration

?>