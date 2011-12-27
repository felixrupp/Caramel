<?php

/**
 *
 * index.php file for admin area
 *
 * @author Felix Rupp <kontakt@felixrupp.com>
 * @version $Id$
 * @copyright Copyright (c) 2011, Felix Rupp, Nicole Reinhardt
 * @license http://www.opensource.org/licenses/mit-license.php MIT-License
 *
 */

define("BASEDIR", substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"],"/admin/")));
define("TEMPLATEDIR", "../".substr(dirname($_SERVER["SCRIPT_NAME"]), 0, strrpos(dirname($_SERVER["SCRIPT_NAME"]),"/admin/"))."template");

require_once(BASEDIR.'/inc/controller/BackendController.php');

# New backend controller
$backendController = new BackendController();

# Initialize session
$backendController->sessionAction();


# Error reporting for testing
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);

?>

<!DOCTYPE HTML>
<?php echo($backendController->versionInformationAction()); ?>

<html>

<head>

<?php echo($backendController->headTagAction()); ?>

</head>

<body>

<?php echo $backendController->backendOutputAction(); ?>

</body>

</html>