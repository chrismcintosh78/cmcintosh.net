<?php
class View{
    public $strViewPath;
    public $objPrimary;
    public $objSecondary;
    public $htmPrimary;

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
        $strModelPath = $GLOBALS["APP_PATH"] . "models/" . $strRoute . ".xml";
        // Load the JSON data
        $GLOBALS["OBJ_TEMPLATE"]->insertView($strViewPath, "VIEW");
        
        // Convert the object to an associative array
        $xml = new SimpleXMLElement(file_get_contents($strModelPath));
        $arrParams = $xml->xpath('//param');
        $arrKeyVals = [];
        foreach ($arrParams as $param) {
            $dataview = (string)$param['data-view'];
            if (!empty($dataview)) {
                $arrKeyVals[$dataview] = (string)$param;
            }
        }
        $objModel = new stdClass($arrKeyVals);
        $objModel["strPageName"] = $strRoute;
        $GLOBALS["OBJ_TEMPLATE"]->addData($objModel);
        $GLOBALS["OBJ_TEMPLATE"]->compile();
        print $GLOBALS["OBJ_TEMPLATE"]->saveHTML();
    }
}
?>