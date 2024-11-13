<?php
class Document
{
    public $objDocument;
    public $objDocumentMap;

    public function __construct(String $strFile)
    {
        $this->objDocument = new DOMDocument();
        @$this->objDocument->loadHTML($strFile, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $this->objDocumentMap = new DOMXPath($this->objDocument);
    }
    public function createNode($strTagName, $strInnerHTML=""){
        $node = $this->objDocument->createElement($strTagName);
        if($strInnerHTML!= ""){
            $node->appendChild($this->objDocument->createTextNode($strInnerHTML));
        }
        return $node;
    } 
    public function query($strQuery){
        return $this->objDocumentMap->query($strQuery);
    }
    public function getTags($strTag){
        $strQuery = "//$strTag";
        return $this->objDocumentMap->query($strQuery);
    }
    public function append($objDest, $objSrc){
        $objDest->appendXML($objSrc->saveXML());
    }
    public function addElementToHead($html)
    {
        $head = $this->objDocumentMap->query('//head')->item(0);
        $fragment = $this->objDocument->createDocumentFragment();
        $fragment->appendXML($html);
        $head->appendChild($fragment);
    }
    public function addElementToBody($html)
    {
        $body = $this->objDocumentMap->query('//body')->item(0);
        $fragment = $this->objDocument->createDocumentFragment();
        $fragment->appendXML($html);
        $body->appendChild($fragment);
    }
    public function writeText($objElement, $strText){
        $objElement->innerHTML = $strText;
    }
    public function removeElementById($id)
    {
        $element = $this->objDocumentMap->query("//*[@id='$id']")->item(0);
        if ($element) {
            $element->parentNode->removeChild($element);
        }
    }
    public function setAttribute($xquery, $strProp, $strVal)
    {
        $elements = $this->objDocumentMap->query($xquery);
        foreach ($elements as $element) {
            $element->setAttribute($strProp, $strVal);
        }
    }
    public function getInnerHtmlById($id)
    {
        $element = $this->objDocumentMap->query("//*[@id='$id']")->item(0);
        if ($element) {
            $innerHTML = '';
            $children = $element->childNodes;
            foreach ($children as $child) {
                $innerHTML .= $element->ownerDocument->saveHTML($child);
            }
            return $innerHTML;
        }
        return null;
    }

    public function getElementById($id)
    {
        return $this->objDocumentMap->query("//*[@id='$id']")->item(0);
    }

    public function getElementsByTagName($tagName)
    {
        return $this->objDocument->getElementsByTagName($tagName);
    }

    public function getElementsByClassName($className)
    {
        return $this->objDocumentMap->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $className ')]");
    }

    public function getNodesByXPath($xpathQuery)
    {
        return $this->objDocumentMap->query($xpathQuery);
    }

    public function getNodeValuesByXPath($xpathQuery)
    {
        $nodes = $this->objDocumentMap->query($xpathQuery);
        $values = [];
        foreach ($nodes as $node) {
            $values[] = $node->nodeValue;
        }
        return $values;
    }

    public function getInnerHtmlOfNodesByXPath($xpathQuery)
    {
        $nodes = $this->objDocumentMap->query($xpathQuery);
        $innerHTMLs = [];
        foreach ($nodes as $node) {
            $innerHTML = '';
            $children = $node->childNodes;
            foreach ($children as $child) {
                $innerHTML .= $node->ownerDocument->saveHTML($child);
            }
            $innerHTMLs[] = $innerHTML;
        }
        return $innerHTMLs;
    }
    public function is_html($string)
    {
        return preg_match("/<[^<]+>/", $string, $m) != 0;
    }
    public function saveHTML()
    {
        return $this->objDocument->saveHTML();
    }
}
?>


