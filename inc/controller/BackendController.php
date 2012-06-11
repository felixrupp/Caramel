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
	 * @var boolean $_navigation Boolean: Show navigation or not
	 */
	private $_navigation = FALSE;
	
	/**
	 * @var boolean $_login Boolean: Show loginform or not
	 */
	private $_login = FALSE;
	
	/**
	 * @var boolean $_welcome Boolean: Show welcome page or not
	 */
	private $_welcome = FALSE;
		
	/**
	 * @var String VERSION Constant for system version
	 */
	const VERSION = "0.2.7";
	
	/**
	 * @var String VERSION Constant for version date
	 */
	const VERSION_DATE = "2012-06-10";
	
	/**
	 * @var String SYSTEM_SALT System Salt for bcrypt hashing
	 */
	const SYSTEM_SALT = 'Mv7DAYvR782k5PgANTYG262P3h6b4p757e2k2jA788ESdAHKP2wBfV93SK3u87Ks';
	

	/**
	 * Constructor
	 * 
	 * @return void
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
		
		if($this->getSession() == FALSE) { # No session, so please show login
			
			$this->_login = TRUE;
				
			if(isset($_POST) && isset($_POST["username"]) && isset($_POST["password"])) {
			
				# Check login data
				$realAdmin = "";
				$realPassword = "";
				$realEmail = "";
					
				try {
					$loginInformation = $this->_config->getLoginInfoAction();
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
					
				if($_POST["username"]==$loginInformation["username"] && $this->bcryptCheck($loginInformation["email"], $_POST["password"], $loginInformation["password"])) {
				
					# Set loggedin
					$_SESSION["loggedin"] = TRUE;
					$_SESSION["timestamp"] = time();
						
					$this->_navigation = TRUE;
					$this->_login = FALSE;
					$this->_welcome = TRUE;
						
					} else {
							
						$this->_navigation = FALSE;
						$this->_login = TRUE;
						$this->_welcome = FALSE;
							
					}
					
			} else {
			
				$this->_navigation = FALSE;
				$this->_login = TRUE;
				$this->_welcome = FALSE;
			
			}
			
		}
		else { # Already logged in
			
			$this->_navigation = TRUE;
			$this->_login = FALSE;
			$this->_welcome = TRUE;
			
			# Logout
			if(isset($_GET["q"]) && $_GET["q"]=="logout") {
				$this->logoutAction();
				
				$this->_navigation = FALSE;
				$this->_login = TRUE;
				$this->_welcome = FALSE;
				
			}
			# New page
			if(isset($_GET["q"]) && $_GET["q"]=="newpage") {
				
				$this->_navigation = TRUE;
				$this->_login = FALSE;
				$this->_welcome = FALSE;
				$this->_templateView->assign("newpage", TRUE);
			
			}
			# Page overview
			if(isset($_GET["q"]) && $_GET["q"]=="editpages" && !isset($_GET["id"]) && !isset($_GET["delete"])) {
				
				try {
					$allPages = $this->_dataBase->backendGetWebsitePagesAction("en");
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
								
				$this->_navigation = TRUE;
				$this->_login = FALSE;
				$this->_welcome = FALSE;
				
				$this->_templateView->assign("pages", $allPages);
				$this->_templateView->assign("editpages", TRUE);
					
			}
			# Move page up
			if(isset($_GET["q"]) && $_GET["q"]=="moveup" && isset($_GET["id"])) {
				
				$id = (int)trim($_GET["id"]);
				
				try {
					$result = $this->_dataBase->backendMovePageUpAction($id);
					$allPages = $this->_dataBase->backendGetWebsitePagesAction("en");
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
								
				$this->_navigation = TRUE;
				$this->_login = FALSE;
				$this->_welcome = FALSE;
				
				$this->_templateView->assign("pages", $allPages);
				$this->_templateView->assign("editpages", TRUE);
				
			}
			# Move page down
			if(isset($_GET["q"]) && $_GET["q"]=="movedown" && isset($_GET["id"])) {
			
				$id = (int)trim($_GET["id"]);
			
				try {
					$result = $this->_dataBase->backendMovePageDownAction($id);
					$allPages = $this->_dataBase->backendGetWebsitePagesAction("en");
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
			
				$this->_navigation = TRUE;
				$this->_login = FALSE;
				$this->_welcome = FALSE;
			
				$this->_templateView->assign("pages", $allPages);
				$this->_templateView->assign("editpages", TRUE);
			
			}
			# Edit a single page
			if(isset($_GET["q"]) && $_GET["q"]=="editpages" && isset($_GET["id"]) && !isset($_GET["delete"])) {
			
				$id = (int)trim($_GET["id"]);
				
				try {
					$page = $this->_dataBase->backendGetPageInformation($id);
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
											
				$this->_navigation = TRUE;
				$this->_login = FALSE;
				$this->_welcome = FALSE;
			
				$this->_templateView->assign("page", $page);
				$this->_templateView->assign("editonepage", TRUE);
					
			}
			# Delete a single page
			if(isset($_GET["q"]) && $_GET["q"]=="editpages" && isset($_GET["id"]) && isset($_GET["delete"])) {
					
				$id = (int)trim($_GET["id"]);
			
				try {
					$result = $this->_dataBase->backendDeletePageAction($id);
					$allPages = $this->_dataBase->backendGetWebsitePagesAction("en");
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
									
				$this->_navigation = TRUE;
				$this->_login = FALSE;
				$this->_welcome = FALSE;
					
				$this->_templateView->assign("pages", $allPages);
				$this->_templateView->assign("editpages", TRUE);
					
			}
			# Edit admin user
			if(isset($_GET["q"]) && $_GET["q"]=="editusers") {
				
				$admin = $this->_config->getAdminAction();
				
				$this->_navigation = TRUE;
				$this->_login = FALSE;
				$this->_welcome = FALSE;
				
				$this->_templateView->assign("admin", $admin);
				$this->_templateView->assign("editusers", TRUE);
					
			}
			# Edit templates
			if(isset($_GET["q"]) && $_GET["q"]=="edittemplates") {
					
				$template = $this->getTemplateConfig();
				
				$this->_navigation = TRUE;
				$this->_login = FALSE;
				$this->_welcome = FALSE;
				
				$this->_templateView->assign("template", $template);
				$this->_templateView->assign("edittemplates", TRUE);
					
			}
			# Edit global settings
			if(isset($_GET["q"]) && $_GET["q"]=="editglobals") {
				
				$globals = $this->getGlobalConfig();
					
				$this->_navigation = TRUE;
				$this->_login = FALSE;
				$this->_welcome = FALSE;
				
				$this->_templateView->assign("globals", $globals);
				$this->_templateView->assign("editglobals", TRUE);
					
			}
			
			####### POST
			
			# New page
			if(isset($_POST["newpage"])) {
						
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
					
					$result = $this->_dataBase->backendCreatePageAction($path, $defaultLang, $recordContents);
					
					$allPages = $this->_dataBase->backendGetWebsitePagesAction("en");
					
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
								
				$this->_navigation = TRUE;
				$this->_login = FALSE;
				$this->_welcome = FALSE;
				
				$this->_templateView->assign("pages", $allPages);
				$this->_templateView->assign("editpages", TRUE);
			
			}
			# Edit one page
			if(isset($_POST["editonepage"]) && isset($_POST["pageid"])) {
				
								
				$id = (int)trim($_POST["pageid"]);
				
				try {
					$page = $this->_dataBase->backendGetPageInformation($id);
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
				
				$page["path"]["value"] = trim($_POST["path"]);
				
				$page["stylesheet"]["value"] = trim($_POST["stylesheet"]);
				$page["scriptfile"]["value"] = trim($_POST["scriptfile"]);
				
				foreach($_POST as $key => $value) {
					
					if($key!="editonepage" && $key!="submit" && $key!="pageid" && $key!="path" && $key != "stylesheet" && $key != "scriptfile") {
						
						# Current language
						$lang = substr($key, strrpos($key, "_")+1, strlen($key));
							
						$key = substr($key, 0, strrpos($key, "_"));
						
						if($key != "visible") {
							
							$page["records"][$lang][$key]["value"] = $value;
							
						}
						else if($key == "visible") {
							
							$page["records"][$lang][$key]["value"] = "true";
							
						}
						
					}
										
				}
				
				
				
				
				try{
					$result = $this->_dataBase->backendSetPageInformation($id, $page);
					$page = $this->_dataBase->backendGetPageInformation($id);
				} 
				catch(CaramelException $e) {
					$e->getDetails();
				}
								
				$this->_navigation = TRUE;
				$this->_login = FALSE;
				$this->_welcome = FALSE;				
					
				$this->_templateView->assign("page", $page);
				$this->_templateView->assign("editonepage", TRUE);
				
			}
			# Edit template config
			if(isset($_POST["edittemplates"])) {
								
				$newTemplate = $_POST["template"];
				
				try {
					$this->_config->setTemplateAction($newTemplate);
				}
				catch(CaramelException $e) {
					$e->getDetails();
				}
				
				$this->_navigation = TRUE;
				$this->_login = FALSE;
				$this->_welcome = FALSE;
				
				$template = $this->getTemplateConfig();
				
				$this->_templateView->assign("template", $template);
				$this->_templateView->assign("edittemplates", TRUE);
								
			}
			# Edit global config
			if(isset($_POST["editglobals"])) {
												
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
									
				$this->_navigation = TRUE;
				$this->_login = FALSE;
				$this->_welcome = FALSE;
				
				$this->_templateView->assign("globals", $globals);
				$this->_templateView->assign("editglobals", TRUE);
					
			}
			# Edit users
			if(isset($_POST["editusers"])) {
							
				$admin = $this->_config->getAdminAction();
			
				foreach($_POST as $key => $value) {
					
					if($key != "editusers" && $key != "submit" && $key != "admin_password" && $key != "password_verification") {
						$admin[$key]["value"] = $value;
					}
					
					# Handle password
					if($key=="admin_password" && $value!="" && $_POST["password_verification"]!="") {
						
						if($value==$_POST["password_verification"] && strlen($_POST["admin_email"])>1) { # verifiy password, save only when email is provided
							
							$admin["admin_password"]["value"] = $this->bcryptEncode($_POST["admin_email"], $value);
						
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
					
				$this->_navigation = TRUE;
				$this->_login = FALSE;
				$this->_welcome = FALSE;
				
				$this->_templateView->assign("admin", $admin);
				$this->_templateView->assign("editusers", TRUE);
					
			}

		}
		
		$this->_templateView->assign("navigation", $this->_navigation);
		$this->_templateView->assign("login", $this->_login);
		$this->_templateView->assign("welcome", $this->_welcome);

		$this->_templateView->renderGzipped();
		
	} // End of method declaration
	
	
	
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
	 * @return Version information comment
	 */
	public function versionInformationAction() {
		
		$comment = "<!-- \n######### Caramel CMS\n######### Version: ".self::VERSION."\n######### Release: ".self::VERSION_DATE."\n\n######### Dual-licensed under the MIT-License: http://www.opensource.org/licenses/mit-license.php and the GNU GPL: http://www.gnu.org/licenses/gpl.html\n\n######### Copyright (c) Felix Rupp, Nicole Reinhardt\n\n######### http://www.caramel-cms.com/\n -->\n";
				
		return $comment;
	
	} // End of method declaration
	
	
	
	/**
	 * Print out head-tag in index.php
	 *
	 * @return Complete head-tag
	 */
	public function headTagAction() {
		
		$meta = $this->getMeta();
		
		$headTag = "\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n\n".$meta."\n\n<title>Caramel CMS Backend</title>\n\n";
	
		$headTag .= $this->_templateView->addCssJs();
		
		$headTag .= "<script type=\"text/javascript\" src=\"".TEMPLATEDIR."/Backend/js/ckeditor/ckeditor.js\"></script>\n";
		$headTag .= "<script type=\"text/javascript\" src=\"".TEMPLATEDIR."/Backend/js/ckeditor/adapters/jquery.js\"></script>\n";
			
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
	private function getSession() {
		
		if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]==FALSE) {
			return FALSE;
		} else {
			return TRUE;
		}
		
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
	
	
	
	/**
	 * Print out meta-tags in index.php
	 * 
	 * @return Meta-tags for author, keywords and description
	 */
	private function getMeta() {
		
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
	private function getGlobalConfig() {
		
		try {
			$globals = $this->_config->getGlobalsAction();
					
			$globals["startpage"]["acceptedValues"] = $this->_dataBase->backendGetAllPageNamesAction();
			$globals["robots"]["acceptedValues"] = array("index,follow", "index,nofollow", "noindex,follow", "noindex,nofollow");
			$globals["navigation_active_marker_position"]["acceptedValues"] = array("disabled", "before", "after");
					
			return $globals;
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
		
	} // End of method declaration
	
	
	
	/**
	 * This method returns a correct formatted array with our template settings
	 * 
	 * @return Array with template configuration
	 */
	private function getTemplateConfig() {
		
		try {
			$template = $this->_config->getTemplateAction();
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
	
	
	
	/**
	 * Method to hash via bcrypt.
	 * 
	 * @param String $email eMail adress
	 * @param String $password Password to encode
	 * 
	 * @return BCrypt hashed password.
	 */
	private function bcryptEncode($email, $password) {
		
		try {
			$result = $this->checkBlowfish();
			
			$salt = 'q8JJ4Ere8w75fCQ3yMZj5A8Yr632zm8keZDSbphjY43r3Z9cY4L5A6V4vK75p4xP';
			$string = hash_hmac("whirlpool", str_pad ($password, strlen ($password)*4, sha1($email), STR_PAD_BOTH ), self::SYSTEM_SALT, true );
			$rounds = '12';
				
			return crypt($string, '$2a$'.$rounds.'$'.$salt);
			
		} catch(CaramelException $e) {
			$e->getDetails();
		}
		
	} // End of method declaration
	
	
	
	/**
	 * Method to check bcrypt encoded passwords
	 * 
	 * @param String $email eMail adress
	 * @param String $password Password given to check
	 * @param String $stored Password to check against
	 * 
	 * @return Boolean value. True if password is valid.
	 */
	private function bcryptCheck($email, $password, $stored) {
		
		try {
			$result = $this->checkBlowfish();
			
			$string = hash_hmac("whirlpool", str_pad($password, strlen($password)*4, sha1($email), STR_PAD_BOTH), self::SYSTEM_SALT, true);
			
			return crypt($string, substr($stored, 0, 30)) == $stored;
			
		} catch(CaramelException $e) {
			$e->getDetails();
		}
		
		
		
	} // End of method declaration
	
	
	
	/**
	 * Method to check if Blowfish algorithm is available on this server.
	 * 
	 * @throws CaramelException
	 */
	private function checkBlowfish() {
		
		if (!defined('CRYPT_BLOWFISH')) {
			
			throw new CaramelException(66);
			
		}
			
	} // End of method declaration
	

} // End of class declaration

?>