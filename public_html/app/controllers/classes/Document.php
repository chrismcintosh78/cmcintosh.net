<?php
class Document extends DOMDocument{
    public $strDocPath;
    public $htmDocContent;
    public $objDocMAP;

    public function __construct($strDocPath=false) {
        parent::__construct();
        $this->strDocPath = $strDocPath; 
        if($strDocPath){
            $this->htmDocContent = file_get_contents($this->strDocPath);
        }else{
            $this->htmDocContent = "<!DOCTYPE html><html><head><title>Document</title></head><body></body></html>  ";
        }
        
        @$this->loadHTML($this->htmDocContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $this->objDocMAP = new DOMXPath($this);
    }
    public function addStylesheet($strFilePath){
        $objLink = $this->createElement('link');
        $objLink->setAttribute('rel','stylesheet');
        $objLink->setAttribute('type','text/css');
        $objLink->setAttribute('href',$strFilePath);
        $objHead = $this->objDocMAP->query('//head')->item(0);
        $objHead->appendChild($objLink);
    }
    public function addScript($strFilePath){
        $objScript = $this->createElement('script');
        $objScript->setAttribute('type','text/javascript');
        $objScript->setAttribute('src',$strFilePath);
        $objHead = $this->objDocMAP->query('//body')->item(0);
        $objHead->appendChild($objScript);
    }

    public function isHTML($strData){
        return preg_match("/<[^<]+>/", $strData, $m)!=0;
    }
}
?>