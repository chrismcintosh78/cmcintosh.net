<?php
class Resume{
    public $objTemplate;
    public $objView;
    public $objModel;
    public $arrData;
    public function __construct($objTemplate){
        $this->objTemplate = $objTemplate;
        $this->arrData = [
                            "strPageTitle" => "Resume", 
                            "htmIconLogo" => "",
                            "strPageHeading" => "Welcome to my resume!"
                        ];
        $this->objTemplate->addData($this->arrData);
        $this->objTemplate->compile();
        print $this->objTemplate->htmDocContent;
    }
}
               
?>