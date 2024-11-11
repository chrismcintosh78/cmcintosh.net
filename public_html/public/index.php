<?php
session_start();

//print $_GET['strRoute'];


class Router {
    public $routes = [];
    public $strRoute; 
    public $arrData;
    public $fncRoute;
    private $strRouteDir = __DIR__. '/../app/controllers/routes/';

    public function __construct($strRoute) {
        $this->strRoute = $strRoute;
        $this->routes['/Home'] = function(){

            include $this->strRouteDir . 'home.php';
            $objPage = new Home(); 
        };
        $this->fncRoute = $this->routes[$this->strRoute];
        $this->routes[$strRoute](); 
    }

}
$objRouter = new Router($_GET['strRoute'] ? $_GET['strRoute'] : '/Home');
$objRouter->routes[$objRouter->strRoute]();

?>