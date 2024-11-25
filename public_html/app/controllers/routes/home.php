<?php
class Home{
    public $objTemplate;
    public $objView;
    public $objModel;
    public $arrData;
    public function __construct($strSubRoute=""){
<<<<<<< HEAD
      //  $strModelPath = $GLOBALS["APP_PATH"] . 'models/home.json';

        $jsnPageData = file_get_contents($strModelPath);
       // $objModel = json_decode($jsnPageData);
        $objModel = new stdClass();

        $objModel->strPageName = "Home";
        $objModel->arrParams = [
                        ];
        
        $objView = new View($objModel);
       /* */
        print "home";
        //var_dump($objView->objPrimary);
        //var_dump($objView->objPrimary);
        //$this->arrData["htmMain"] = $objView->htmPrimary;
=======
      $strModelPath = $GLOBALS["APP_PATH"] . 'models/home.xml';
      $xml = new SimpleXMLElement(file_get_contents($strModelPath));
      $arrParams = $xml->xpath('//param');
      $arrKeyVals = [];
      foreach ($arrParams as $param) {
          $dataview = (string)$param['data-view'];
          if (!empty($dataview)) {
              $arrKeyVals[$dataview] = (string)$param;
          }
      }

       // $objModel = json_decode($jsnPageData);
        $objModel = new stdClass($arrKeyVals);

        $objModel->strPageName = "Home";
        $arrKeyVals["strPageName"] = "Home";
        $objView = new View($arrKeyVals);
>>>>>>> 5867a93 (done)

    }
}
               
?>