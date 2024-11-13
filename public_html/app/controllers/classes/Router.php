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
    }
    public function route(){
        print "";
        $strController = str_replace('/', '', $this->strRoute). '.php';
        $strController = strtolower($strController);
        include $this->strRouteDir . $strController;
        $strClass = preg_replace('/\.php$/', '', $strController);
        $strClass = ucfirst($strClass);
        print "calling class";
        $objPage = new $strClass();
    }
}
?>