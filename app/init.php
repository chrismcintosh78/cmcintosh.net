<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$CONFIG = parse_ini_file("models/config.ini", true);
//SETUP PATHS
$GLOBALS["CONFIG"] = $CONFIG;
$GLOBALS["APP_PATH"]        = $CONFIG['APP']['PATH'];
$GLOBALS["TEMPLATE_PATH"]   = $CONFIG['APP']['PATH'] . $CONFIG["TEMPLATE"]["PATH"];
$GLOBALS["RESOURCE_PATH"]   = $CONFIG["TEMPLATE"]["RESOURCE_PATH"];
$GLOBALS["VIEW_PATH"]       = $CONFIG['APP']['PATH'] . $CONFIG["VIEW"]["PATH"];

require_once($GLOBALS["APP_PATH"] . "controllers/classes/Router.php");
require_once($GLOBALS["APP_PATH"] . "controllers/classes/_Document.php");
require_once($GLOBALS["APP_PATH"] . "controllers/classes/_Template.php");
require_once($GLOBALS["APP_PATH"] . "controllers/classes/_View.php");


//initialize the template engine
//THI ARRAY CAN HAVE ANY GLOBAL OR tEmplATE WIDE VARIBALES
//$arrTemplateData = array("{{KEY}}" => "VALUE");
$arrTemplateData = [];
$arrTemplateData["APP_LOGO"] = $CONFIG["APP"]["LOGO"];
$arrTemplateData["APP_NAME"] = $CONFIG["APP"]["NAME"];

$GLOBALS["OBJ_TEMPLATE"] = new Template($GLOBALS["TEMPLATE_PATH"], $arrTemplateData);
?>