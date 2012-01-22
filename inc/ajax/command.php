<?php

/**
 * @package inc
 * @subpackage ajax
 */

/**
 *
 * Contact script
 *
 * @author Felix Rupp <kontakt@felixrupp.com>
 * @version $Id$
 * @copyright Copyright (c) 2011, Felix Rupp, Nicole Reinhardt
 * @license http://www.opensource.org/licenses/mit-license.php MIT-License
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 * 
 */

#require_once("Configurator.php");
#$config = Configurator::getConfigurator("admin");


if(!$_POST) {
	echo "Nicht direkt Laden!";
	exit;
}

$errors=array(false,false,false,false);
$kopie=false;


if(isset($_POST["absenderName"]) && preg_match("/([A-Za-zÄÖÜäöüß-]+)/",$_POST["absenderName"])) {
	$name = $_POST["absenderName"];
	$errors[0]=false;
} else {
    $errors[0]=true;
	echo "Bitte Absender eintragen.";
	exit;
}
if(isset($_POST["absenderEmail"]) && preg_match("/^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,6})$/",$_POST["absenderEmail"])) {
	$email = $_POST["absenderEmail"];
	$errors[1]=false;
} else {
    $errors[1]=true;
	echo "Bitte g&uuml;ltige E-Mail-Adresse eintragen.";
	exit;
}
if(isset($_POST["absenderBetreff"])) {
	$title = $_POST["absenderBetreff"];
} else {
	$title="";
}
if(isset($_POST["absenderNachricht"]) && (strlen($_POST["absenderNachricht"]) >= 10)){
	$message = stripslashes($_POST["absenderNachricht"]);
	$errors[3]=false;
} else {
    $errors[3]=true;
	echo "Bitte eine mindestens 10 Zeichen lange Nachricht eingeben.";
	exit;
}
if(isset($_POST["absenderTelefon"]) && (strlen($_POST["absenderTelefon"]) >= 4)) {
	$phone = $_POST["absenderTelefon"];
	$message .= "\n\nTelefonnummer: ".$phone;
} else {
	$phone="";
}
if(isset($_POST["kopie"]) && $_POST["kopie"]=="true") {
	$kopie=true;
} else {
	$kopie=false;
}


$recipient = $config->getConfigString("CONTACT_EMAIL");


if($errors[0]==false && $errors[1]==false && $errors[2]==false && $errors[3]==false) {
    
    if($kopie==true) {
        $title2 = $title." - Kopie";
        
        if(!mail($email,$title2,$message,"From: $name <$email>")) {
            echo "Fehler: Nachricht wurde nicht gesendet.";
        }
                
        if(mail($recipient,$title,$message,"From: $name <$email>")) {
        	echo "Ihre Nachricht wurde erfolgreich versendet. Vielen Dank."; 
        } else {
        	echo "Fehler: Nachricht wurde nicht gesendet.";
        }
    
    } elseif($kopie==false) {
    
        if(mail($recipient,$title,$message,"From: $name <$email>")) {
        	echo "Ihre Nachricht wurde erfolgreich versendet. Vielen Dank."; 
        } else {
        	echo "Fehler: Nachricht wurde nicht gesendet.";
        }
        
    }   
    
}

?>