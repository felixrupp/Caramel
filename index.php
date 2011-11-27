<?php

ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);


define("BASEDIR", substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"],"/")));

require_once(BASEDIR.'/inc/redirect.php');
require_once(BASEDIR.'/inc/controller/FrontendController.php');
	
$frontendController = new FrontendController();

?>
<!DOCTYPE HTML>
<?php echo($frontendController->versionInformation()); ?>

<html lang="<?php echo($frontendController->languageCode()); ?>">

<head>

<?php echo($frontendController->headTag()); ?>

</head>

<body>

<?php echo $frontendController->frontendOutput(); ?>

</body>

</html>