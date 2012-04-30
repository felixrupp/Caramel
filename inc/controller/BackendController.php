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
 * BackendController class
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
class BackendController {

	# Attributes
	private $_config;
	private $_dataBase;
	private $_templateView;
		
	# Constants
	const VERSION = "0.2.3";
	const VERSION_DATE = "2012-04-30";
	

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
					
				if($_POST["username"]==$realAdmin && md5($_POST["password"])==$realPassword) {

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
			
			# Logout
			if(isset($_GET["q"]) && $_GET["q"]=="logout") {
				$this->logoutAction();
				
				$navigation = FALSE;
				$login = TRUE;
				$welcome = FALSE;
				
			}
			# New page
			if(isset($_GET["q"]) && $_GET["q"]=="newpage") {
				
				$navigation = TRUE;
				$login = FALSE;
				$welcome = FALSE;
				$this->_templateView->assign("newpage", TRUE);
			
			}
			# Page overview
			if(isset($_GET["q"]) && $_GET["q"]=="editpages" && !isset($_GET["id"]) && !isset($_GET["delete"])) {
				
				try {
					$allPages = $this->_dataBase->getWebsitePagesAction("en");
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
					
				#var_dump($allPages);
				
				$navigation = TRUE;
				$login = FALSE;
				$welcome = FALSE;
				
				$this->_templateView->assign("pages", $allPages);
				$this->_templateView->assign("editpages", TRUE);
					
			}
			# Edit a single page
			if(isset($_GET["q"]) && $_GET["q"]=="editpages" && isset($_GET["id"]) && !isset($_GET["delete"])) {
			
				$id = (int)trim($_GET["id"]);
				
				try {
					$page = $this->_dataBase->getPageInformation($id);
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
					
				#var_dump($page);
							
				$navigation = TRUE;
				$login = FALSE;
				$welcome = FALSE;
			
				$this->_templateView->assign("page", $page);
				$this->_templateView->assign("editonepage", TRUE);
					
			}
			# Delete a single page
			if(isset($_GET["q"]) && $_GET["q"]=="editpages" && isset($_GET["id"]) && isset($_GET["delete"])) {
					
				$id = (int)trim($_GET["id"]);
			
				try {
					$result = $this->_dataBase->deletePageAction($id);
					$allPages = $this->_dataBase->getWebsitePagesAction("en");
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
					
				#var_dump($page);
					
				$navigation = TRUE;
				$login = FALSE;
				$welcome = FALSE;
					
				$this->_templateView->assign("pages", $allPages);
				$this->_templateView->assign("editpages", TRUE);
					
			}
			# Edit admin user
			if(isset($_GET["q"]) && $_GET["q"]=="editusers") {
					
				$admin = $this->_config->getAdminAction();
				
				$navigation = TRUE;
				$login = FALSE;
				$welcome = FALSE;
				
				$this->_templateView->assign("admin", $admin);
				$this->_templateView->assign("editusers", TRUE);
					
			}
			# Edit templates
			if(isset($_GET["q"]) && $_GET["q"]=="edittemplates") {
					
				$template = $this->getTemplateConfig();
				
				$navigation = TRUE;
				$login = FALSE;
				$welcome = FALSE;
				
				$this->_templateView->assign("template", $template);
				$this->_templateView->assign("edittemplates", TRUE);
					
			}
			# Edit global settings
			if(isset($_GET["q"]) && $_GET["q"]=="editglobals") {
				
				$globals = $this->getGlobalConfig();
					
				$navigation = TRUE;
				$login = FALSE;
				$welcome = FALSE;
				
				$this->_templateView->assign("globals", $globals);
				$this->_templateView->assign("editglobals", TRUE);
					
			}
			
			####### POST
			
			if(isset($_POST["newpage"])) {
			
				#var_dump($_POST);
			
				$path = strtolower(trim($_POST["path"]));
				$defaultLang = strtolower(trim($_POST["defaultLanguage"]));
				
				$recordContents["navigation"] = trim($_POST["navigation"]);
				$recordContents["title"] = trim($_POST["title"]);
				$recordContents["titletag"] = trim($_POST["titletag"]);
				$recordContents["metadescription"] = trim($_POST["metadescription"]);
				$recordContents["metakeywords"] = trim($_POST["metakeywords"]);
				$recordContents["metaauthor"] = trim($_POST["metaauthor"]);
				$recordContents["content"] = trim($_POST["content"]);
				
			
				try {
					
					$result = $this->_dataBase->createPageAction($path, $defaultLang, $recordContents);
					
					$allPages = $this->_dataBase->getWebsitePagesAction("en");
					
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
								
				$navigation = TRUE;
				$login = FALSE;
				$welcome = FALSE;
				
				$this->_templateView->assign("pages", $allPages);
				$this->_templateView->assign("editpages", TRUE);
			
			}
			
			if(isset($_POST["editonepage"]) && isset($_POST["pageid"])) {
				
								
				$id = (int)trim($_POST["pageid"]);
				
				try {
					$page = $this->_dataBase->getPageInformation($id);
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
				
				$page["path"]["value"] = trim($_POST["path"]);
				
				foreach($_POST as $key => $value) {
					
					if($key!="editonepage" && $key!="submit" && $key!="pageid" && $key!="path") {
						
						# Current language
						$lang = substr($key, strrpos($key, "_")+1, strlen($key));
							
						$key = substr($key, 0, strrpos($key, "_"));
												
						$page["records"][$lang][$key]["value"] = $value;
					}
				}
				
				
				try{
					$result = $this->_dataBase->setPageInformation($id, $page);
					$page = $this->_dataBase->getPageInformation($id);
				} 
				catch(CaramelException $e) {
					$e->getDetails();
				}
								
				$navigation = TRUE;
				$login = FALSE;
				$welcome = FALSE;				
					
				$this->_templateView->assign("page", $page);
				$this->_templateView->assign("editonepage", TRUE);
				
			}
			
			if(isset($_POST["edittemplates"])) {
				
				#var_dump($_POST);
				
				$newTemplate = $_POST["template"];
				
				try {
					$this->_config->setTemplateAction($newTemplate);
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
				
				$navigation = TRUE;
				$login = FALSE;
				$welcome = FALSE;
				
				$template = $this->getTemplateConfig();
				
				$this->_templateView->assign("template", $template);
				$this->_templateView->assign("edittemplates", TRUE);
								
			}
			
			if(isset($_POST["editglobals"])) {
				
				#var_dump($_POST);
								
				$globals = $this->getGlobalConfig();
				
				$globals["speaking_urls"]["value"] = "false";
				$globals["language_selector_in_footer"]["value"] = "false";
				
				
				foreach($_POST as $key => $value) {
					
					if($key != "editglobals" && $key != "submit") {
						$globals[$key]["value"] = $value;
					}
					
					# Cover Speaking URLs
					if($key == "speaking_urls") {
						$globals["speaking_urls"]["value"] = "true";
					}
					
					# Cover language_selector_in_footer
					if($key == "language_selector_in_footer") {
						$globals["language_selector_in_footer"]["value"] = "true";
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
			
			if(isset($_POST["editusers"])) {
			
				#var_dump($_POST);
			
				$admin = $this->_config->getAdminAction();
			
				foreach($_POST as $key => $value) {
					
					if($key != "editusers" && $key != "submit" && $key != "admin_password") {
						$admin[$key]["value"] = $value;
					}
					
					# Handle password
					if($key=="admin_password" && $value!="" && $_POST["password_verification"]!="") {
						
						if($value==$_POST["password_verification"]) { # verifiy password
							$admin["admin_password"]["value"] = md5($value);
						}
					}
					
				}
			
				try{
					$result = $this->_config->setAdminAction($admin);
				} 
				catch(CaramelException $e) {
					$e->getDetails();
				}
			
				$admin = $this->_config->getAdminAction();
					
				$navigation = TRUE;
				$login = FALSE;
				$welcome = FALSE;
				$this->_templateView->assign("admin", $admin);
				$this->_templateView->assign("editusers", TRUE);
					
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
		
		$comment = "<!-- \n######### Caramel CMS\n######### Version: ".self::VERSION."\n######### Release: ".self::VERSION_DATE."\n\n######### Dual-licensed under the MIT-License: http://www.opensource.org/licenses/mit-license.php and the GNU GPL: http://www.gnu.org/licenses/gpl.html\n\n######### Copyright (c) Felix Rupp, Nicole Reinhardt\n\n######### http://www.caramel-cms.com/\n -->\n";
				
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
	
		$headTag .= "<script type=\"text/javascript\" src=\"".TEMPLATEDIR."/Backend/js/jquery.min.js\"></script>\n";
		
		$headTag .= "<script type=\"text/javascript\" src=\"".TEMPLATEDIR."/Backend/js/ckeditor/ckeditor.js\"></script>\n";
		$headTag .= "<script type=\"text/javascript\" src=\"".TEMPLATEDIR."/Backend/js/ckeditor/adapters/jquery.js\"></script>\n";
		
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
	
	
	
	/**
	 * This method returns a correct formatted array with all global settings
	 * 
	 * @return Array with global configuration
	 */
	protected function getGlobalConfig() {
		
		$globals = $this->_config->getGlobalsAction();
				
		$globals["startpage"]["acceptedValues"] = $this->_dataBase->getAllPageNamesAction();
		$globals["robots"]["acceptedValues"] = array("index,follow", "index,nofollow", "noindex,follow", "noindex,nofollow");
		$globals["navigation_active_marker_position"]["acceptedValues"] = array("disabled", "before", "after");
				
		return $globals;
		
	} // End of method declaration
	
	
	
	/**
	 * This method returns a correct formatted array with our template settings
	 * 
	 * @return Array with template configuration
	 */
	protected function getTemplateConfig() {
		
		try {
			$template = $this->_config->getConfigStringAction("TEMPLATE");
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
		
		$acceptedValues = array();
		
		## Find all possible templates
		$dirIterator = new DirectoryIterator(BASEDIR.'/template/');
		
		foreach($dirIterator as $dirItem) {
			
			if($dirItem->isDir() && !$dirItem->isDot() && strpos($dirItem->getPathname(), "Backend")==FALSE) { # All folders without dots and NOT Backend-Template
				
				if(is_file($dirItem->getPathname()."/index.tpl.php")) {
				
					$acceptedValues[] = substr($dirItem->getPathname(), strrpos($dirItem->getPathname(), "/")+1, strlen($dirItem->getPathname()));
					
				}
							
			}
			
		}
		
		
		$templateArray["template"]["label"] = "Template";
		$templateArray["template"]["value"] = $template;
		$templateArray["template"]["blank"] = "false";
		$templateArray["template"]["acceptedValues"] = $acceptedValues;
		
		return $templateArray;
		
	} // End of method declaration

} // End of class declaration

?>