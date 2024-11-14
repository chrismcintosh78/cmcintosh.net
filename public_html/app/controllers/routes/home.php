<?php
class Home{
    public $objTemplate;
    public $objView;
    public $objModel;
    public $arrData;
    public function __construct($objTemplate){
        $this->objTemplate = $objTemplate;
        $this->arrData = [
                            "strPageTitle" => "Home", 
                            "htmIconLogo" => "<span class='material-symbols-outlined'>owl</span>",
                            "strPageHeading" => "Welcome to our home page!"
                        ];
        $objView = new View($GLOBALS["APP_PATH"]."/views/home.html");
        $this->arrData["htmPrimary"] = $objView->htmPrimary;
        $this->objTemplate->addData($this->arrData);
        $this->objTemplate->compile();
        print $this->objTemplate->htmDocContent;
    }
}
               
?>