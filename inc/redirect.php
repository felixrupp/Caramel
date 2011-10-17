<?php

# Imports
require_once('Configurator.php');

## Language Redirect
if(!isset($_GET['lang'])) {

	/* Get Configurator Singleton */
	$_config = Configurator::getConfigurator("site");
	
	if($_config->getConfigString("SPEAKING_URLS") == "false") {
	
		$language = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		$language = strtolower(substr(chop($language[0]),0,2));
		
		
		if(preg_match("/[a-z]{2}/", $language)) {
			header("Location: ./?lang=".$language);
		}
		else {
			header("Location: ./?lang=en");
		}
	
	}
	elseif($_config->getConfigString("SPEAKING_URLS") == "true"){
		
		$language = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		$language = strtolower(substr(chop($language[0]),0,2));
		
		if(preg_match("/[a-z]{2}/", $language)) {
			header("Location: ./".$language."/");
		}
		else {
			header("Location: ./en/");
		}
		
		
	}
	
	
}



/*
# Display redirect (for Ajax)
if(isset($_GET[$caramel->getString("ATTRIBUTE")])){
	print inhaltAjax($_GET[$this->$caramel->getString("ATTRIBUTE")]);
}


# Print Ajax content
function inhaltAjax($displayID) {
    
    // Sprache setzen
	$contentLocalized = 'inhalt'.$caramel->getLanguage();

	$fileName = $displayID.'.xml';
	$xmlFile = simplexml_load_file(substr($_SERVER["SCRIPT_FILENAME"], 0, (strrpos($_SERVER["SCRIPT_FILENAME"],"/")-3)).$caramel->getString("DOCUMENT_SUBFOLDER").'/'.$fileName);
	
	$inhalt = $xmlFile->$contentLocalized;
	
	return $inhalt;	   
}*/

?>