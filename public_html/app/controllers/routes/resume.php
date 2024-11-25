<?php
class Resume{
    public $objTemplate;
    public $objView;
    public $objModel;
    public $arrData;
    public function __construct($strSubRoute=""){
      //  $strModelPath = $GLOBALS["APP_PATH"] . 'models/home.json';

        //$jsnPageData = file_get_contents($strModelPath);
       // $objModel = json_decode($jsnPageData);
        $objModel = new stdClass();
        $objModel->strPageName = "Resume";///"
        $objModel->arrParams = [
                        ];
        $objView = new View($objModel);
       /* */
        print "home";
        //var_dump($objView->objPrimary);
        //var_dump($objView->objPrimary);
        //$this->arrData["htmMain"] = $objView->htmPrimary;

    }
}
               
?>