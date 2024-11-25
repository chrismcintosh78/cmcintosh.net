<?php
session_start();
require_once(__DIR__ . "/../app/init.php");

$GLOBALS["OBJ_TEMPLATE"]->addData("APP_NAME", $CONFIG["APP"]["NAME"]);
$GLOBALS["OBJ_TEMPLATE"]->addData("APP_LOGO", $CONFIG["APP"]["LOGO"]);

$strDefaultRoute = $CONFIG['APP']['DEFAULT_ROUTE'];
$strRoute = isset($_GET['strRoute'])? $_GET['strRoute'] : $strDefaultRoute;

$objRouter = new Router($strRoute); 
$objRouter->route();
?>