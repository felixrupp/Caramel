<?php
define("BASEDIR", substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"],"/admin/")));
define("TEMPLATEDIR", "../".substr(dirname($_SERVER["SCRIPT_NAME"]), 0, strrpos(dirname($_SERVER["SCRIPT_NAME"]),"/admin/"))."template");

require_once(BASEDIR.'/inc/controller/BackendController.php');

# New backend controller
$backendController = new BackendController();


if($_GET) {
	
	if($_GET["q"]=="newpage") {
		echo $backendController->ajaxAction("newpage");
	}
	if($_GET["q"]=="editpages") {
		echo $backendController->ajaxAction("editpages");
	}
	if($_GET["q"]=="editusers") {
		echo $backendController->ajaxAction("editusers");
	}
	if($_GET["q"]=="edittemplates") {
		echo $backendController->ajaxAction("edittemplates");
	}
	if($_GET["q"]=="editglobals") {
		echo $backendController->ajaxAction("editglobals");
	}
	
}
?>