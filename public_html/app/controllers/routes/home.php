<?php
class Home{
    public $objTemplate;
    public $objView;
    public $objModel;
    public $arrData;
    public function __construct($strSubRoute){
        //the view should resnder the doc so this contoller should be preparing the data and sending it to thee view, 
        //the view should nnot be conection to any models  the controllr should be getting tha t data
        /*
        $strModelPath = $GLOBALS["APP_PATH"] . '/models/home.json';
        $jsnPageData = file_get_contents($strModelPath);
        $objModel = json_decode($jsnPageData);
        $objModel->strPageName = "Home";
        $objModel->arrParams = [
                            "htmGoogleIcon" => "",
                            "strPageHeading" => $strSubRoute,
                            "strDyn" => "myid"
                        ];
        $objView = new View($objModel);
        */
        print "home";
        //var_dump($objView->objPrimary);
        //var_dump($objView->objPrimary);
        //$this->arrData["htmMain"] = $objView->htmPrimary;

    }
}
               
?>