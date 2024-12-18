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
    public function querySelector($selector) {
        $xpath = new DOMXPath($this);
        $selector = $this->cssToXPath($selector);
        return $xpath->query($selector);
    }

    public function querySelectorOne($selector) {
        $nodes = $this->querySelector($selector);
        return $nodes ? $nodes->item(0) : null;
    }

    public function setInnerHTML(DOMElement $element, $content) {
        // Clear existing children
        while ($element->firstChild) {
            $element->removeChild($element->firstChild);
        }

        // Load new content
        $fragment = $this->createDocumentFragment();
        $fragment->appendXML($content);
        $element->appendChild($fragment);
    }

    public function getInnerHTML(DOMElement $element) {
        $innerHTML = '';
        foreach ($element->childNodes as $child) {
            $innerHTML .= $this->saveHTML($child);
        }
        return $innerHTML;
    }

    public function appendChildHTML(DOMElement $parent, $childHTML) {
        $fragment = $this->createDocumentFragment();
        $fragment->appendXML($childHTML);
        $parent->appendChild($fragment);
    }

    public function removeElement($selector) {
        $element = $this->querySelectorOne($selector);
        if ($element && $element->parentNode) {
            $element->parentNode->removeChild($element);
        }
    }
     // Convert CSS selectors to XPath
     private function cssToXPath($selector) {
        // Simplified CSS to XPath conversion
        if (strpos($selector, '#') === 0) {
            return "//*[@id='" . substr($selector, 1) . "']";
        } elseif (strpos($selector, '.') === 0) {
            return "//*[contains(concat(' ', normalize-space(@class), ' '), ' " . substr($selector, 1) . " ')]";
        } else {
            return "//" . $selector;
        }
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