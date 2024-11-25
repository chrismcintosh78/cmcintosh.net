<?php
class _route{
    public $objTemplate;
    public $objView;
    public $objModel;
    public $arrData;
    public function __construct($strSubRoute=""){
      $strModelPath = $GLOBALS["APP_PATH"] . 'models/'.$_ROUTE.'.xml';
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

        $objModel->strPageName = $_ROUTE;
        $arrKeyVals["strPageName"] = $_ROUTE;
        $objView = new View($arrKeyVals);

    }
}
               
?>