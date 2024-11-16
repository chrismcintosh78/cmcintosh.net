<?php
session_start();
require_once(__DIR__ . "/../app/init.php");

$strDefaultRoute = $CONFIG['APP']['DEFAULT_ROUTE'];
$strRoute = isset($_GET['strRoute'])? $_GET['strRoute'] : $strDefaultRoute;

$objRouter = new Router($strRoute); 
$objRouter->route();
?>