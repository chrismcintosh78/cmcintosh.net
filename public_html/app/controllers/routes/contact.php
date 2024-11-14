<?php
class Contact{
    public $objTemplate;
    public $objView;
    public $objModel;
    public $arrData;
    public function __construct($objTemplate){
        $this->objTemplate = $objTemplate;
        $this->arrData = [
                            "strPageTitle" => "Contact", 
                            "htmIconLogo" => "",
                            "strPageHeading" => "Welcome to my Contact page!"
                        ];
        $this->objTemplate->addData($this->arrData);
        $this->objTemplate->compile();
        print $this->objTemplate->htmDocContent;
    }
}
               
?>