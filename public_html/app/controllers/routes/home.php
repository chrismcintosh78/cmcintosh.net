<?php
class Home{
    public $objTemplate;
    public $objView;
    public $objModel;
    public $arrData;
    public function __construct($strSubRoute){
        $objTemplate = new Template($GLOBALS["TEMPLATE_PATH"]);
        $this->objTemplate = $objTemplate;
        $this->arrData = [
                            "strPageTitle" => "Home", 
                            "htmGoogleIcon" => "<span class='material-symbols-outlined'>owl</span>",
                            "strPageHeading" => $strSubRoute,
                            "strDyn" => "myid"
                        ];
        $objView = new View($GLOBALS["APP_PATH"]."/views/home.html");
        //var_dump($objView->objPrimary);
        //var_dump($objView->objPrimary);
        $this->arrData["htmMain"] = $objView->htmPrimary;

        $this->objTemplate->addData($this->arrData);
        $this->objTemplate->_compile();
        print $this->objTemplate->htmDocContent;
    }
}
               
?>