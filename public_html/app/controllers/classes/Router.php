<?php
class Router {
    public $routes = [];
    public $strRoute; 
    public $arrData;
    public $fncRoute;
    public $strRouteDir;
    
    public function __construct($strRoute) {
        $this->strRouteDir = $GLOBALS["APP_PATH"]. "/controllers/routes/";  
        $this->strRoute = $strRoute;
        $this->routes['/Home'] = "home.php";
        $this->routes['/Resume'] = "resume.php"; 
        $this->routes['/Contact'] = "contact.php";
        $this->routes['/Services'] = "services.php";
    }
    public function route(){
        $strController = str_replace('/', '', $this->strRoute). '.php';
        $strController = strtolower($strController);
        include $this->strRouteDir . $strController;
        $strClass = preg_replace('/\.php$/', '', $strController);
        $strClass = ucfirst($strClass);
        $objTemplate = new Template($GLOBALS["APP_PATH"] . "/templates/app.html");
        $objPage = new $strClass($objTemplate);
    }
}
?>