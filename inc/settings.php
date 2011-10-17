<?php

/**
 *
 * Caramel Settings
 * 
 * @author SieRupp GbR
 * @version 0.5
 * 
 * Date: 06.03.2011 16:05 CET
 * 
 * Copyright (c) by SieRupp GbR, Nathanael Siering and Felix Rupp
 * All rights reserved.
 * No copy, reproduction or use without written permission of SieRupp GbR.
 * http://www.sierupp.com/
 * 
 */

define("BASEDIR", substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"],"/")));

ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);

// Add minify lib to include-path
#$path = dirname(__FILE__)."/../min/lib"; 
#set_include_path($path.PATH_SEPARATOR.get_include_path());

?>