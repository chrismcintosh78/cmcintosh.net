<?php
class Contact{
    public $objTemplate;
    public $objView;
    public $objModel;
    public $arrData;
    public function __construct($strSubRoute=""){
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
        $arrKeyVals["strPageName"] = $strClassName;
        $objView = new View($arrKeyVals);
    }
}
               
?>
