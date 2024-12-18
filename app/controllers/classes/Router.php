<?php
class Router {
    public $routes = [];
    public $strRoute; 
    public $arrData;
    public $fncRoute;
    public $strRouteDir;
    public $strTemplatePath;
    
    public function __construct($strRoute) {
        
        $this->strRouteDir = $GLOBALS["APP_PATH"]. "/controllers/routes/";  
        $this->strRoute = $strRoute;
        $this->routes['/Home'] = "home.php";
        $this->routes['/Resume'] = "resume.php"; 
        $this->routes['/Contact'] = "contact.php";
        $this->routes['/Services'] = "services.php";
    }

    public function route() {
        // Split the route into parts
        $arrRouteParts = explode('/', trim($this->strRoute, '/'));
        
        // Determine the main route
        $strMainRoute = '/' . array_shift($arrRouteParts);

        // Concatenate the remaining parts as the sub-route
        $strSubRoute = implode('/', $arrRouteParts);

        // Determine the controller file
        $strController = isset($this->routes[$strMainRoute]) ? $this->routes[$strMainRoute] : null;

        if ($strController) {
            
            include $this->strRouteDir . $strController;
            $strClass = preg_replace('/\.php$/', '', $strController);
            $strClass = ucfirst($strClass);

            // Pass the template and sub-route to the controller
            $objPage = new $strClass($strSubRoute);
        } else {
            // Handle the case where the route is not found
            // You might want to include a 404 page or redirect
            echo "404 Not Found";
        }
    }
}
?>