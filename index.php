<?php

/**
 *
 * index.php file
 *
 * @author Felix Rupp <kontakt@felixrupp.com>
 * @version $Id$
 * @copyright Copyright (c) 2011, Felix Rupp, Nicole Reinhardt
 * @license http://www.opensource.org/licenses/mit-license.php MIT-License
 *
 */

define("BASEDIR", substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"],"/")));
require_once(BASEDIR.'/inc/controller/FrontendController.php');

# New frontend controller
$frontendController = new FrontendController();

# Automatical language redirect
$frontendController->languageRedirect();

# Error reporting for testing
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);

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