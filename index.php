<?php

/**
 * @package default
 */

/**
 *
 * index.php file
 *
 * @author Felix Rupp <kontakt@felixrupp.com>
 * @version $Id$
 * @copyright Copyright (c) 2011, Felix Rupp, Nicole Reinhardt
 * @license http://www.opensource.org/licenses/mit-license.php MIT-License
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 */

/**
 * @var string BASEDIR Constant which represents the basedir of the server
 */
define("BASEDIR", substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"],"/")));
/**
 * @var string TEMPLATEDIR Constant which represents the template directory of Caramel CMS installation
 */
#define("TEMPLATEDIR", dirname($_SERVER["SCRIPT_NAME"])."template");
define("TEMPLATEDIR", substr($_SERVER["SCRIPT_NAME"], 0, strrpos($_SERVER["SCRIPT_NAME"],"/"))."/template");

require_once(BASEDIR.'/inc/controller/FrontendController.php');

# New frontend controller
$frontendController = new FrontendController();

# Automatical language redirect
$frontendController->languageRedirectAction();

# Error reporting for testing
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);

?>

<!DOCTYPE HTML>
<?php /*echo($frontendController->versionInformationAction());*/ ?>

<html lang="<?php echo($frontendController->languageCodeAction()); ?>">

<head>

<?php echo($frontendController->headTagAction()); ?>

</head>

<body>

<?php echo $frontendController->frontendOutputAction(); ?>

</body>

</html>