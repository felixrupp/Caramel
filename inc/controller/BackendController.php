<?php

/**
 * @package inc
 * @subpackage controller
 */

# Imports
require_once BASEDIR.'/inc/utility/CaramelException.php';
require_once BASEDIR.'/inc/model/DatabaseModel.php';
require_once BASEDIR.'/inc/model/ConfigurationModel.php';
require_once BASEDIR.'/inc/view/TemplateView.php';

/**
 *
 * BackendController class
 * 
 * @author Felix Rupp <kontakt@felixrupp.com>
 * @version $Id$
 * @copyright Copyright (c) 2011, Felix Rupp, Nicole Reinhardt
 * @license http://www.opensource.org/licenses/mit-license.php MIT-License
 * 
 */
class BackendController {

	# Attributes
	private $_config;
	private $_dataBase;
	private $_templateView;
		
	# Constants
	const VERSION = "0.3";
	const VERSION_DATE = "2011-12-27";
	

	/**
	 * Constructor
	 */
	public function BackendController() {

		# Get Configurator 
		$this->_config = ConfigurationModel::getConfigurationModel();
		
		# Get TemplatingEngine for Backend
		$this->_templateView = new TemplateView("Backend");
		
		# Get Database 
		$this->_dataBase = DatabaseModel::getDatabaseModel();
		
				
	} // End of constructor declaration
	
	
	
# Main content actions:

	/**
	 * This method assigns needed content to our template engine and renders the template.
	 * 
	 * @return void
	 */
	public function backendOutputAction() {
		
		$navigation = FALSE;
		$login = FALSE;
		$welcome = FALSE;
		
		if($this->getSession() == FALSE) {
			
			$login = TRUE;
							
			if(isset($_POST) && isset($_POST["username"]) && isset($_POST["password"])) {

				# Check login data
				$realAdmin = "";
				$realPassword = "";
					
				try {
					$realAdmin = $this->_config->getAdminConfigStringAction("ADMIN_USERNAME");
					$realPassword = $this->_config->getAdminConfigStringAction("ADMIN_PASSWORD");
				}
				catch(CaramelException $e) {
					echo $e->getDetails();
				}
					
				if($_POST["username"]==$realAdmin && $_POST["password"]==$realPassword) {

					# Set loggedin
					$_SESSION["loggedin"] = TRUE;
					$_SESSION["timestamp"] = time();
					
					$navigation = TRUE;
					$login = FALSE;
					$welcome = TRUE;
					
				} else {
					
					$navigation = FALSE;
					$login = TRUE;
					$welcome = FALSE;
					
				}
			}
			else {
				
				$navigation = FALSE;
				$login = TRUE;
				$welcome = FALSE;
				
			}			
			
		}
		else {
			
			$navigation = TRUE;
			$login = FALSE;
			$welcome = TRUE;
			
			
			if(isset($_GET["q"]) && $_GET["q"]=="logout") {
				$this->logoutAction();
				
				$navigation = FALSE;
				$login = TRUE;
				$welcome = FALSE;
				
			}
			if(isset($_GET["q"]) && $_GET["q"]=="newpage") {
			
				$navigation = TRUE;
				$login = FALSE;
				$welcome = FALSE;
				$this->_templateView->assign("newpage", TRUE);
			
			}
			if(isset($_GET["q"]) && $_GET["q"]=="editpages") {
					
				$navigation = TRUE;
				$login = FALSE;
				$welcome = FALSE;
				$this->_templateView->assign("editpages", TRUE);
					
			}
			if(isset($_GET["q"]) && $_GET["q"]=="editusers") {
					
				$navigation = TRUE;
				$login = FALSE;
				$welcome = FALSE;
				$this->_templateView->assign("editusers", TRUE);
					
			}
			if(isset($_GET["q"]) && $_GET["q"]=="edittemplates") {
					
				$navigation = TRUE;
				$login = FALSE;
				$welcome = FALSE;
				$this->_templateView->assign("edittemplates", TRUE);
					
			}
			if(isset($_GET["q"]) && $_GET["q"]=="editglobals") {
				
				$globals = $this->getGlobalConfig();
					
				$navigation = TRUE;
				$login = FALSE;
				$welcome = FALSE;
				$this->_templateView->assign("globals", $globals);
				$this->_templateView->assign("editglobals", TRUE);
					
			}
			if(isset($_POST["editglobals"])) {
				
				$globals = $this->getGlobalConfig();
				
				foreach($_POST as $key => $value) {
					
					if($key != "editglobals" && $key != "submit") {
					
						$globals[$key]["value"] = $value;
					}
				}

				try{
					$result = $this->_config->setGlobalsAction($globals);
					
				} catch(CaramelException $e) {
					$e->getDetails();
				}
				
				$globals = $this->getGlobalConfig();
									
				$navigation = TRUE;
				$login = FALSE;
				$welcome = FALSE;
				$this->_templateView->assign("globals", $globals);
				$this->_templateView->assign("editglobals", TRUE);
					
			}

		}
		
		$this->_templateView->assign("navigation", $navigation);
		$this->_templateView->assign("login", $login);
		$this->_templateView->assign("welcome", $welcome);

		$this->_templateView->render();
		
	} // End of method declaration
	
	
	
	/**
	 * Method to make ajax requests
	 * 
	 * @param String $actionName Name of the ajax action to perform
	 * 
	 * @return Content of templatefile
	 * 
	 * @deprecated
	 */
	public function ajaxAction($actionName) {
		
		$this->_templateView->setTemplateFile($actionName);
		return $this->_templateView->returnTemplate();
		
	}
	
	
	
	/**
	 * Method to initialize login session
	 * 
	 * @return void
	 */
	public function sessionAction() {
		
		session_set_cookie_params(604800); # Cookie stays for 7 days
		session_start();
		
	} // End of method declaration
	
	

	/**
	 * Print out version-information in index.php
	 * 
	 * @return string Version information comment
	 */
	public function versionInformationAction() {
		
		$comment = "<!-- \n######### Caramel CMS\n######### Version: ".self::VERSION."\n######### Release: ".self::VERSION_DATE."\n\n######### Licensed under the MIT-License: http://www.opensource.org/licenses/mit-license.php\n\n######### Copyright (c) Felix Rupp, Nicole Reinhardt\n\n######### http://www.caramel-cms.com/\n -->\n";
				
		return $comment;
	
	} // End of method declaration
	
	
	
	/**
	* Print out head-tag in index.php
	*
	* @return string Whole head-tag
	*/
	public function headTagAction() {
		
		$meta = $this->getMeta();
		
		$headTag = "\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n\n".$meta."\n\n<title>Caramel CMS Backend</title>\n\n";
	
		$headTag .= "<script type=\"text/javascript\" src=\"".TEMPLATEDIR."/Backend/js/jquery.min.js\"></script>";
		
		$headTag .= $this->_templateView->addCssJs();
	
		return $headTag;
	
	} // End of method declaration
	
	
	
	/**
	* This action logs the user off
	*
	* @return void
	*/
	public function logoutAction() {
	
		if($this->getSession()==TRUE) {
			session_destroy();
		}
	
	} // End of method declaration
	
	
	
##################################################
### Helper functions:
##################################################

	/**
	 * Check if session is active or not
	 * 
	 * @return TRUE or FALSE, wether a session is active or not
	 */
	protected function getSession() {
		
		if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]==FALSE) {
			return FALSE;
		} else {
			return TRUE;
		}
		
	} // End of method declaration
	
	
	
	/**
	 * Get parameters of GET-query before ampersand 
	 * 
	 * @return string New querystring for building correct URL
	 */
	protected function getParametersBefore() {
		$serverQueryString = $_SERVER['QUERY_STRING'];
					
		if($this->_config->getConfigStringAction("SPEAKING_URLS") == "false") {
				
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
		
		if($this->_config->getConfigStringAction("SPEAKING_URLS") == "true") {
			$newQueryString = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], $this->getLanguage())+strlen($this->getLanguage()));
		}
		
		return $newQueryString;
		
	} // End of method declaration
	
	
	
	/**
	 * Get parameters of GET-query behind ampersand 
	 * 
	 * @return string New querystring for building correct URL
	 */
	protected function getParametersBehind() {
		$serverQueryString = $_SERVER['QUERY_STRING'];
					
		if($this->_config->getConfigStringAction("SPEAKING_URLS") == "false") {
		
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
		
		elseif($this->_config->getConfigStringAction("SPEAKING_URLS") == "true") {
				
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
	
		if($this->_config->getConfigStringAction("SPEAKING_URLS") == "true") {
			return "<base href=\"".$this->_config->getConfigStringAction('BASE')."\">\n";
		} else {
			return "";
		}
		
	} // End of method declaration
	
	
	
	/**
	 * Print out meta-tags in index.php
	 * 
	 * @return string Meta-tags for author, keywords and description
	 */
	protected function getMeta() {
		
		$metaAuthor = "<meta name=\"author\" content=\"Felix Rupp, Nicole Reinhardt\">";
		
		$metaGenerator = "<meta name=\"generator\" content=\"Caramel CMS ".self::VERSION."\">";
		
		$metaTags = $metaAuthor."\n".$metaGenerator."\n";
						
		return $metaTags;
	
	} // End of method declaration
	
	
	protected function getGlobalConfig() {
		
		$globals = $this->_config->getGlobalsAction();
				
		$globals["startpage"]["acceptedValues"] = $this->_dataBase->getAllPageNamesAction();
				
		return $globals;
		
	}

} // End of class declaration

?>