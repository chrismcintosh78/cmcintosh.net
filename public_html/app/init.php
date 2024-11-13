<?php
$CONFIG = parse_ini_file("models/config.ini", true);
$GLOBALS["APP_PATH"] = $CONFIG['APP']['PATH'];
require_once($GLOBALS["APP_PATH"] . "/controllers/classes/Router.php");
?>