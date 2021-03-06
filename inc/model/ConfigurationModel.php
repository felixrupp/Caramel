<?php

/**
 * @package inc
 * @subpackage model
 */

/**
 *
 * ConfigurationModel class
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
class ConfigurationModel {

	/**
	* @var ConfigurationModel $_configurator Contains single instance of our ConfigurationModel
	* @staticvar $_configurator
	*/
	private static $_configurator = NULL;
	
	/**
	 * @var SimpleXMLExtended $_configFile Contains the SimpleXMLExtended of our xml-configfile
	 */
	private $_configFile;
	
	/**
	 * @var SimpleXMLExtended $_adminConfigFile Contains the SimpleXMLExtended of our admin configfile
	 */
	private $_adminConfigFile;
	
	/**
	 * @var SimpleXMLExtended $_adminLangFile Contains the SimpleXMLExtended of our xml-languagefile for admin
	 */
	private $_adminLangFile;
	
	/**
	 * @var string $_backendLang Contains iso language-code of the backend language
	 */
	private $_backendLang;
	
	/**
	 * @var array $_backendLangugeData Contains SimpleXMLExtended object with backend language data
	 */
	private $_backendLangugeData;
	
	/**
	 * @var array $_allBackendLanguages Contains an array with alle existing backend languages
	 */
	private $_allBackendLanguages;
	
	
	/**
	 * @var array $_isoLangCodes Contains all ISO language codes and respective language names
	 */
	private $_isoLangCodes = array(
    'aa' => 'Afar',
    'ab' => 'Abkhaz',
    'ae' => 'Avestan',
    'af' => 'Afrikaans',
    'ak' => 'Akan',
    'am' => 'Amharic',
    'an' => 'Aragonese',
    'ar' => 'Arabic',
    'as' => 'Assamese',
    'av' => 'Avaric',
    'ay' => 'Aymara',
    'az' => 'Azerbaijani',
    'ba' => 'Bashkir',
    'be' => 'Belarusian',
    'bg' => 'Bulgarian',
    'bh' => 'Bihari',
    'bi' => 'Bislama',
    'bm' => 'Bambara',
    'bn' => 'Bengali',
    'bo' => 'Tibetan Standard, Tibetan, Central',
    'br' => 'Breton',
    'bs' => 'Bosnian',
    'ca' => 'Catalan; Valencian',
    'ce' => 'Chechen',
    'ch' => 'Chamorro',
    'co' => 'Corsican',
    'cr' => 'Cree',
    'cs' => 'Czech',
    'cu' => 'Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic',
    'cv' => 'Chuvash',
    'cy' => 'Welsh',
    'da' => 'Danish',
    'de' => 'German',
    'dv' => 'Divehi; Dhivehi; Maldivian;',
    'dz' => 'Dzongkha',
    'ee' => 'Ewe',
    'el' => 'Greek, Modern',
    'en' => 'English',
    'eo' => 'Esperanto',
    'es' => 'Spanish; Castilian',
    'et' => 'Estonian',
    'eu' => 'Basque',
    'fa' => 'Persian',
    'ff' => 'Fula; Fulah; Pulaar; Pular',
    'fi' => 'Finnish',
    'fj' => 'Fijian',
    'fo' => 'Faroese',
    'fr' => 'French',
    'fy' => 'Western Frisian',
    'ga' => 'Irish',
    'gd' => 'Scottish Gaelic; Gaelic',
    'gl' => 'Galician',
    'gn' => 'GuaranÃ­',
    'gu' => 'Gujarati',
    'gv' => 'Manx',
    'ha' => 'Hausa',
    'he' => 'Hebrew (modern)',
    'hi' => 'Hindi',
    'ho' => 'Hiri Motu',
    'hr' => 'Croatian',
    'ht' => 'Haitian; Haitian Creole',
    'hu' => 'Hungarian',
    'hy' => 'Armenian',
    'hz' => 'Herero',
    'ia' => 'Interlingua',
    'id' => 'Indonesian',
    'ie' => 'Interlingue',
    'ig' => 'Igbo',
    'ii' => 'Nuosu',
    'ik' => 'Inupiaq',
    'io' => 'Ido',
    'is' => 'Icelandic',
    'it' => 'Italian',
    'iu' => 'Inuktitut',
    'ja' => 'Japanese (ja)',
    'jv' => 'Javanese (jv)',
    'ka' => 'Georgian',
    'kg' => 'Kongo',
    'ki' => 'Kikuyu, Gikuyu',
    'kj' => 'Kwanyama, Kuanyama',
    'kk' => 'Kazakh',
    'kl' => 'Kalaallisut, Greenlandic',
    'km' => 'Khmer',
    'kn' => 'Kannada',
    'ko' => 'Korean',
    'kr' => 'Kanuri',
    'ks' => 'Kashmiri',
    'ku' => 'Kurdish',
    'kv' => 'Komi',
    'kw' => 'Cornish',
    'ky' => 'Kirghiz, Kyrgyz',
    'la' => 'Latin',
    'lb' => 'Luxembourgish, Letzeburgesch',
    'lg' => 'Luganda',
    'li' => 'Limburgish, Limburgan, Limburger',
    'ln' => 'Lingala',
    'lo' => 'Lao',
    'lt' => 'Lithuanian',
    'lu' => 'Luba-Katanga',
    'lv' => 'Latvian',
    'mg' => 'Malagasy',
    'mh' => 'Marshallese',
    'mi' => 'Maori',
    'mk' => 'Macedonian',
    'ml' => 'Malayalam',
    'mn' => 'Mongolian',
    'mr' => 'Marathi (Mara?hi)',
    'ms' => 'Malay',
    'mt' => 'Maltese',
    'my' => 'Burmese',
    'na' => 'Nauru',
    'nb' => 'Norwegian BokmÃ¥l',
    'nd' => 'North Ndebele',
    'ne' => 'Nepali',
    'ng' => 'Ndonga',
    'nl' => 'Dutch',
    'nn' => 'Norwegian Nynorsk',
    'no' => 'Norwegian',
    'nr' => 'South Ndebele',
    'nv' => 'Navajo, Navaho',
    'ny' => 'Chichewa; Chewa; Nyanja',
    'oc' => 'Occitan',
    'oj' => 'Ojibwe, Ojibwa',
    'om' => 'Oromo',
    'or' => 'Oriya',
    'os' => 'Ossetian, Ossetic',
    'pa' => 'Panjabi, Punjabi',
    'pi' => 'Pali',
    'pl' => 'Polish',
    'ps' => 'Pashto, Pushto',
    'pt' => 'Portuguese',
    'qu' => 'Quechua',
    'rm' => 'Romansh',
    'rn' => 'Kirundi',
    'ro' => 'Romanian, Moldavian, Moldovan',
    'ru' => 'Russian',
    'rw' => 'Kinyarwanda',
    'sa' => 'Sanskrit (Sa?sk?ta)',
    'sc' => 'Sardinian',
    'sd' => 'Sindhi',
    'se' => 'Northern Sami',
    'sg' => 'Sango',
    'si' => 'Sinhala, Sinhalese',
    'sk' => 'Slovak',
    'sl' => 'Slovene',
    'sm' => 'Samoan',
    'sn' => 'Shona',
    'so' => 'Somali',
    'sq' => 'Albanian',
    'sr' => 'Serbian',
    'ss' => 'Swati',
    'st' => 'Southern Sotho',
    'su' => 'Sundanese',
    'sv' => 'Swedish',
    'sw' => 'Swahili',
    'ta' => 'Tamil',
    'te' => 'Telugu',
    'tg' => 'Tajik',
    'th' => 'Thai',
    'ti' => 'Tigrinya',
    'tk' => 'Turkmen',
    'tl' => 'Tagalog',
    'tn' => 'Tswana',
    'to' => 'Tonga (Tonga Islands)',
    'tr' => 'Turkish',
    'ts' => 'Tsonga',
    'tt' => 'Tatar',
    'tw' => 'Twi',
    'ty' => 'Tahitian',
    'ug' => 'Uighur, Uyghur',
    'uk' => 'Ukrainian',
    'ur' => 'Urdu',
    'uz' => 'Uzbek',
    've' => 'Venda',
    'vi' => 'Vietnamese',
    'vo' => 'VolapÃ¼k',
    'wa' => 'Walloon',
    'wo' => 'Wolof',
    'xh' => 'Xhosa',
    'yi' => 'Yiddish',
    'yo' => 'Yoruba',
    'za' => 'Zhuang, Chuang',
    'zh' => 'Chinese',
    'zu' => 'Zulu',
);
	
	
	
	/**
	 * Configurator class-constructor
	 *
	 * @return void
	 */
	private function ConfigurationModel() {

		try {
			$this->reloadConfigFile();
			$this->reloadAdminConfigFile();
			$this->reloadAdminLangFile();
			
			$this->_backendLang = $this->getAdminConfigString("BACKEND_LANGUAGE");
			$this->_backendLangugeData = $this->getBackendLanguage($this->_backendLang);
			$this->_allBackendLanguages = $this->getAllBackendLanguages();	
		}
		catch(CaramelException $e) {
			$e->getDetails();
		}
		
	} // End of constructor declaration
	
	
	/**
	 * Singleton-create-method
	 *
	 * @return ConfigurationModel Single instance of ConfigurationModel
	 */
	public static function getConfigurationModel() {
	
		if (self::$_configurator === NULL) {
			self::$_configurator = new self();
		}
		return self::$_configurator;
	
	} // End of method declaration
	
	
	# Prevent cloning
	/**
	 * Overwrite __clone() method to prevent instance-cloning
	*
	* @return void
	*/
	private function __clone() {
	}
		
	
	
	/**
	 * This method returns an ordered array with all global settings
	 *
	 * @return Array with all global settings
	 */
	public function getGlobalsAction() {
		
		$configArray = $this->getConfig($this->_configFile);
		$globals = array();
				
		$languageArray = array();
		foreach($this->_backendLangugeData as $xmlNode) {
			$languageArray[(string)$xmlNode["key"]] = (string)$xmlNode;
		}
				
		foreach($configArray as $node) {
			
			$globals[strtolower((string)$node["key"])] = array("label" => $languageArray[(string)$node["key"]], "value" => stripslashes((string)$node), "type" => (string)$node["type"], "blank" => (string)$node["blank"], "validate" => (string)$node["validate"]);
			
		}
		
		# Provide languages for default frontend language		
		foreach($this->_isoLangCodes as $langCode => $langValue) {
				
			$globals["default_language"]["acceptedValues"][$langCode] = $langValue;
		}
		
		# Set Robot and navigation active marker positions
		$globals["robots"]["acceptedValues"] = array("index,follow"=>"index,follow", "index,nofollow"=>"index,nofollow", "noindex,follow"=>"noindex,follow", "noindex,nofollow"=>"noindex,nofollow");
		$globals["navigation_active_marker_position"]["acceptedValues"] = array("disabled"=>"disabled", "before"=>"before", "after"=>"after");
				
		# Remove template settings:
		if(isset($globals["template"])) {unset($globals["template"]);}	
			
		return $globals;
			
	} // End of method declaration
	
	
	
	/**
	 * Method to save global config
	 *
	 * @param array $globals Array that contains all global settings
	 *
	 * @throws CaramelException
	 * @return void
	 */
	public function setGlobalsAction($globals) {
			
		$result = false;
	
		foreach($globals as $key => $valueArray) {
	
			if($key != "submit") {
					
				$key = strtoupper($key);
					
				$valueArray = stripslashes((string)$valueArray["value"]);
					
				$result = $this->setConfigString($key, $valueArray);
				
			}
		}
			
		return $result;
			
	} // End of method declaration
	
	
	
	/**
	 * Method to return the base admin login information
	 * 
	 * @throws CaramelException
	 * @return Simple array with admin login info to check while logging in
	 */
	public function getLoginInfoAction() {
		
		$loginInformation = array();
		
		$loginInformation["username"] = $this->getAdminConfigString("ADMIN_USERNAME");
		$loginInformation["password"] = $this->getAdminConfigString("ADMIN_PASSWORD");
		$loginInformation["email"] = $this->getAdminConfigString("ADMIN_EMAIL");
		
		return $loginInformation;
		
	} // End of method declaration
	
	
	
	/**
	* This method returns an ordered array with all admin settings
	* 
	* @param string $lang Language to fetch options for
	*
	* @throws CaramelException
	* @return Array with all admin settings
	*/
	public function getAdminAction() {
				
		$adminConfigArray = $this->getConfig($this->_adminConfigFile);
				
		$languageArray = array();
		foreach($this->_backendLangugeData as $xmlNode) {
			$languageArray[(string)$xmlNode["key"]] = (string)$xmlNode;
		}
				
		foreach($adminConfigArray as $node) {
			
			$admin[strtolower((string)$node["key"])] = array("label" => $languageArray[(string)$node["key"]], "value" => stripslashes((string)$node), "type" => (string)$node["type"], "blank" => (string)$node["blank"], "validate" => (string)$node["validate"]);
			
		}
		
		# Don't show passwords:
		$admin["admin_password"]["value"] = "";
		
		# Provide all language which are in our lang_admin.xml file for html select-tag:
		$admin["backend_language"]["acceptedValues"] = array();
				
		foreach($this->_allBackendLanguages as $langCode) {
				
			$admin["backend_language"]["acceptedValues"][$langCode] = $this->_isoLangCodes[$langCode];
		}
		
		return $admin;
			
	} // End of method declaration
	
	
	
	/**
	* Method to save admin config
	*
	* @param array $globals Array that contains all admin settings
	*
	* @throws CaramelException
	* @return Result of file_put_contents
	*/
	public function setAdminAction($admin) {
			
		$result = false;
	
		foreach($admin as $key => $valueArray) {
	
			if($key != "submit") {
					
				$key = strtoupper($key);
					
				$valueArray = stripslashes((string)$valueArray["value"]);
					
				$result = $this->setAdminConfigString($key, $valueArray);
									
			}
		}
			
		return $result;
			
	} // End of method declaration
	
	
	
	/**
	 * Method to get current active template
	 * 
	 * @throws CaramelException
	 * @return The current template set in template settings
	 */
	public function getTemplateAction() {
		
		return $this->getConfigString("TEMPLATE");
		
	} // End of method declaration
	
	
	
	/**
	 * Method to set new template file for frontend
	 * 
	 * @param string $newTemplate New template to set
	 * 
	 * @throws CaramelException
	 * @return Result of file_put_contents
	 */
	public function setTemplateAction($newTemplate) {
		
		$this->setConfigString("TEMPLATE", $newTemplate);
		
		return file_put_contents(BASEDIR.'/config/site.xml', $this->_configFile->asXML());
		
	} // End of method declaration
	
	
	
	/**
	 * Wrapper for getConfigString
	 * 
	 * @see getConfigString
	 *
	 * @param string $key Key to lookup in config-file
	 *
	 * @throws CaramelException
	 * @return string Value for given key
	 */
	public function getConfigStringAction($key) {
	
		return $this->getConfigString($key);
	
	} // End of method declaration
	
	
	
	/**
	 * Wrapper for getAdminConfigString
	 * 
	 * @see getAdminConfigString
	 *
	 * @param string $key Key to lookup in config-file
	 *
	 * @throws CaramelException
	 * @return string Value for given key
	 */
	public function getAdminConfigStringAction($key) {
	
		return $this->getAdminConfigString($key);
	
	} // End of method declaration
	
	
	
	/**
	 * Wrapper for getBackendLanguagestring
	 *
	 * @see getBackendLanguagestring
	 *
	 * @param string $key Key to lookup in config-file
	 *
	 * @throws CaramelException
	 * @return Value for given key
	 */
	public function getBackendLanguageStringAction($key) {
				
		return $this->getBackendLanguageString($this->_backendLang, $key);
	
	} // End of method declaration
	
	
		
############################################################################
##
##  Helper methods
##
############################################################################
	
		
	/**
	 * Get full config from passed config file
	 *
	 * @throws CaramelException
	 * @return SimpleXMLExtended node mathing the $key
	 */
	private function getConfig($configFile) {
	
		$setting = $configFile->xpath('setting');
	
		if(count($setting)>0) {
			return $setting;
		}
		else {
			throw new CaramelException(10);
		}
	
	} // End of method declaration
	
	
	
	/**
	 * Get String from key of config-file
	 *
	 * @param string $key Key to lookup in config-file
	 *
	 * @throws CaramelException
	 * @return Value for given key
	 */
	private function getConfigString($key) {
	
		$setting = $this->_configFile->xpath('//setting[@key="'.$key.'"]');
	
		if(count($setting)>0) {
			return (string)$setting[0];
		}
		else {
			throw new CaramelException(10);
		}
	
	} // End of method declaration
	
	
	
	/**
	 * Set String from key of config-file
	 *
	 * @param string $key Key of the setting to change
	 * @param string $newValue New value for the setting
	 *
	 * @throws CaramelException
	 * @return Result of file_put_contents
	 */
	private function setConfigString($key, $newValue) {
	
		$setting = $this->_configFile->xpath('//setting[@key="'.$key.'"]');
	
		if(count($setting)>0) {
	
			$setting[0][0] = null;
			$setting[0][0]->addCData($newValue);
	
		}
		else {
			throw new CaramelException(10);
		}
		
		return file_put_contents(BASEDIR.'/config/site.xml', $this->_configFile->asXML());		
	
	} // End of method declaration
	
	
	
	/**
	 * Get String from key of admin configfile
	 *
	 * @param string $key Key to lookup in config-file
	 * 
	 * @throws CaramelException
	 * @return Value for given key
	 */
	private function getAdminConfigString($key) {
	
		$setting = $this->_adminConfigFile->xpath('//setting[@key="'.$key.'"]');
	
		if(count($setting)>0) {
			return (string)$setting[0];
		}
		else {
			throw new CaramelException(10);
		}
	
	} // End of method declaration
	
	
	
	/**
	* Set String from key of admin config-file
	*
	* @param string $key Key of the setting to change
	* @param string $newValue New value for the setting
	*
	* @throws CaramelException
	* @return Result of file_put_contents
	*/
	private function setAdminConfigString($key, $newValue) {
	
		$setting = $this->_adminConfigFile->xpath('//setting[@key="'.$key.'"]');
	
		if(count($setting)>0) {
	
			$setting[0][0] = null;
			$setting[0][0]->addCData($newValue);
	
		}
		else {
			throw new CaramelException(10);
		}
	
		return file_put_contents(BASEDIR.'/config/admin.xml', $this->_adminConfigFile->asXML());
		
	} // End of method declaration
	
	
	
	/**
	 * Get string from backend languagefile
	 *
	 * @param string $lang The language to fetch the string for
	 * @param string $key The key of the language setting
	 *
	 * @throws CaramelException
	 * @return Value mathing the $lang and the $key
	 * @deprecated
	 */
	private function getBackendLanguageString($lang, $key) {
	
		$setting = $this->_adminLangFile->xpath('//lang[@code="'.$lang.'"]/setting[@key="'.$key.'"]');
	
		if(count($setting)>0) {
			return (string)$setting[0];
		}
		else {
			throw new CaramelException(10);
		}
	
	} // End of method declaration
	
	
	
	/**
	 * Get string from backend languagefile
	 *
	 * @param string $lang The language to fetch the string for
	 *
	 * @throws CaramelException
	 * @return Value mathing the $lang and the $key
	 */
	private function getBackendLanguage($lang) {
	
		$setting = $this->_adminLangFile->xpath('//lang[@code="'.$lang.'"]/setting');
	
		if(count($setting)>0) {
			return $setting;
		}
		else {
			throw new CaramelException(10);
		}
	
	} // End of method declaration
	
	
	
	/**
	 * Get all languages in lang file
	 *
	 * @throws CaramelException
	 * @return Value mathing the $lang and the $key
	 */
	private function getAllBackendLanguages() {
	
		$allLanguages = array();
		
		$setting = $this->_adminLangFile->xpath('//@code');
	
		if(count($setting)>0) {
			
			$setting = array_unique($setting); # Remove double entries
				
			foreach($setting as $langCode) {
				array_push($allLanguages, (string)$langCode); # Convert SimpleXMLElements into strings
			}
			
			return $allLanguages;
			
		}
		else {
			throw new CaramelException(10);
		}
	
	} // End of method declaration
	
	
	
	/**
	 * This method updates the contents of the local configFile in our singleton.
	 *
	 * @throws CaramelException
	 * @return void
	 */
	private function reloadConfigFile() {
			
		try {
			$this->_configFile = simplexml_load_file(BASEDIR.'/config/site.xml', "SimpleXMLExtended");
		}
		catch(Exception $e) {
			throw new CaramelException(11);
		}
			
	} // End of method declaration
	
	
	
	/**
	 * This method updates the contents of the local adminConfigFile in our singleton.
	 *
	 * @throws CaramelException
	 * @return void
	 */
	private function reloadAdminConfigFile() {

		try {
			$this->_adminConfigFile = simplexml_load_file(BASEDIR.'/config/admin.xml', "SimpleXMLExtended");
		}
		catch(Exception $e) {
			throw new CaramelException(11);
		}
	
	} // End of method declaration
	
	
	
	/**
	 * This method updates the contents of the local langFile in our singleton.
	 *
	 * @throws CaramelException
	 * @return void
	 */
	private function reloadAdminLangFile() {
			
		try {
			$this->_adminLangFile = simplexml_load_file(BASEDIR.'/config/lang.xml', "SimpleXMLExtended");
		}
		catch(Exception $e) {
			throw new CaramelException(11);
		}
			
	} // End of method declaration


}
?>