<?php
class Home{
    public $objTemplate;
    public $objView;
    public $objModel;
    public $arrData;
    public $arrRoutes;
    public function __construct($strSubRoute=""){
        $this->arrRoutes = [];
        
        $strClassName = get_class($this);
        $strModelPath = $GLOBALS["APP_PATH"] . 'models/'.lcfirst($strClassName).'.xml';
        $xml = new SimpleXMLElement(file_get_contents($strModelPath));
        $arrParams = $xml->xpath('//param');
        $arrKeyVals = [];
        foreach ($arrParams as $param) {
            $dataview = (string)$param['data-view'];
            if (!empty($dataview)) {
                $arrKeyVals[$dataview] = (string)$param;
            }
        }
        $arrKeyVals["VIEW_PAGE_TITLE"] = $GLOBALS["CONFIG"]["APP"]["NAME"] . "::" . ucfirst($strClassName);
        $arrKeyVals["strPageName"] = $strClassName;
        $objView = new View($arrKeyVals);
    }
}
               
?>
