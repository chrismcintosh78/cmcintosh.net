<?php
class Services{
    public $objTemplate;
    public $objView;
    public $objModel;
    public $arrData;
    public function __construct($objTemplate){
        $this->objTemplate = $objTemplate;
        $this->arrData = [
                            "strPageTitle" => "Services", 
                            "htmIconLogo" => "",
                            "strPageHeading" => "Check out what i do!"
                        ];
        $this->objTemplate->addData($this->arrData);
        $this->objTemplate->compile();
        print $this->objTemplate->htmDocContent;
    }
}
               
?>