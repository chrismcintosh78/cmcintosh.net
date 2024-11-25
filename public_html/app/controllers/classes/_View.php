<?php
class View{
    public $strViewPath;
    public $objPrimary;
    public $objSecondary;
    public $htmPrimary;

<<<<<<< HEAD
    public function __construct($objModel) {
        $strRoute = lcfirst($objModel->strPageName);
        $strViewPath = $GLOBALS["VIEW_PATH"] . $strRoute . ".html";
        // Get the view template content
        $htmViewTemplate = file_get_contents($strViewPath);
        
        // Extract the model JSON file name from the view path

        $arrPageInfo = [
                        "CONTENT_LEFT"=>"",
                        "CONTENT_CENTER"=>"",
                        "CONTENT_RIGHT"=>""
                ];
        $strModelPath = $GLOBALS["APP_PATH"] . "models/" . $strRoute . ".json";
        // Load the JSON data
        $GLOBALS["OBJ_TEMPLATE"]->insertView($strViewPath, "VIEW");
        
        // Convert the object to an associative array
        $objModel = json_decode(json_encode($objModel), true);

        // Debugging output

        $GLOBALS["OBJ_TEMPLATE"]->addData($objModel);
=======
    public function __construct($arrKeyVals) {
        
        $strRoute = lcfirst($arrKeyVals["strPageName"]);
        $strViewPath = $GLOBALS["VIEW_PATH"] . $strRoute . ".html";
        $htmViewTemplate = file_get_contents($strViewPath);
        $GLOBALS["OBJ_TEMPLATE"]->insertView($strViewPath, "VIEW");
        

        // Debugging output

        $GLOBALS["OBJ_TEMPLATE"]->addData($arrKeyVals);
>>>>>>> 5867a93 (done)
        $GLOBALS["OBJ_TEMPLATE"]->compile();
        print $GLOBALS["OBJ_TEMPLATE"]->saveHTML();
    }
}
?>