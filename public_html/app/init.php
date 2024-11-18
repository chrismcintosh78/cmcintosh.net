<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$CONFIG = parse_ini_file("models/config.ini", true);
$GLOBALS["APP_PATH"] = $CONFIG['APP']['PATH'];
$GLOBALS["TEMPLATE_PATH"] = $CONFIG['APP']['PATH'] . $CONFIG["TEMPLATE"]["PATH"];
require_once($GLOBALS["APP_PATH"] . "controllers/classes/Router.php");
require_once($GLOBALS["APP_PATH"] . "controllers/classes/Document.php");
require_once($GLOBALS["APP_PATH"] . "controllers/classes/Template.php");
require_once($GLOBALS["APP_PATH"] . "controllers/classes/View.php");




//initialize the template engine
$GLOBALS["OBJ_TEMPLATE"] = new Template($GLOBALS["TEMPLATE_PATH"]);
?>