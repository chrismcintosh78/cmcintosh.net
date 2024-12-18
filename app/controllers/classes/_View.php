<?php
class View{
    public $strViewPath;
    public $objPrimary;
    public $objSecondary;
    public $htmPrimary;


    public function __construct($arrKeyVals) {
        
        $strRoute = lcfirst($arrKeyVals["strPageName"]);
        $strViewPath = $GLOBALS["VIEW_PATH"] . $strRoute . ".html";
        $htmViewTemplate = file_get_contents($strViewPath);
        $GLOBALS["OBJ_TEMPLATE"]->insertView($strViewPath, "VIEW");
        

        // Debugging output

        $GLOBALS["OBJ_TEMPLATE"]->addData($arrKeyVals);

        $GLOBALS["OBJ_TEMPLATE"]->compile();
        print $GLOBALS["OBJ_TEMPLATE"]->saveHTML();
    }
}
?>
