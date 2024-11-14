<?php
class Template extends Document{
    public $strTemplatePath;
    //THE DATA TO BE INSERTED INTO THE TEMPLATE
    public $arrData;
   
    public function __construct($strTemplatePath,$arrData=false) {
        parent::__construct($strTemplatePath);
        $this->strTemplatePath = $strTemplatePath;
        if($arrData){
            $this->arrData = $arrData;
        }else{
            $this->arrData = [];
        }
        //$GLOBALS["TEMPLATE"]["RESOURCE_PATH"]
        $this->appendDeps("../res");
    }
    public function appendDeps($strDirPath){
        //scan directory and add all css and js files to the document
        $dir = new DirectoryIterator($strDirPath);
        foreach ($dir as $file) {
            if ($file->isDir() &&!$file->isDot()) {
                //WE HIT A SUB DIRECTORY SO CALL RECURSIVE
                $this->appendDeps($file->getPathname());
            } 
            else if($file->isFile()){ 
                switch($file->getExtension()){
                    case "css":
                        $this->addStylesheet($file->getPathname());
                        break;
                    case "js":
                        $this->addScript($file->getPathname());
                        break;
                    default:
                        break;
                }
            }
        }
    }
    public function addData($strKey, $strValue=false){
        if(is_array($strKey)){
            foreach ($strKey as $key => $value) {
                $this->addData($key, $value);
            }
        }else{
            $this->arrData[$strKey] = $strValue;
        }
    }
    public function remData($strKey){
        unset($this->arrData[$strKey]);
    }

    public function compile($bolHb=true) {
        if($bolHb){
            foreach ($this->arrData as $strKey => $strValue) {
                $pattern = '/\{\{' . preg_quote($strKey, '/') . '\}\}/';

                // Find all text nodes containing {{var}}
                $textNodes = $this->objDocMAP->query('//text()[contains(., "{{' . $strKey . '}}")]');
                foreach ($textNodes as $node) {
                    if($this->isHTML($strValue)){
                        $fragment = $this->createDocumentFragment();
                        $fragment->appendXML($strValue);
                        $node->parentNode->replaceChild($fragment, $node);
                    }
                    else {
                        $newValue = preg_replace($pattern, $strValue, $node->nodeValue);
                        $node->nodeValue = $newValue;
                    }
                    $newValue = preg_replace($pattern, $strValue, $node->nodeValue);
                    $node->nodeValue = $newValue;
                }

                // Find all attributes containing {{var}}
                $attributes = $this->objDocMAP->query('//@*[contains(., "{{' . $strKey . '}}")]');
                foreach ($attributes as $attr) {
                    $newValue = preg_replace($pattern, $strValue, $attr->value);
                    $attr->value = $newValue;
                }
            }
        }else {
        // Handle non-Handlebars case
        // Just replace all occurrences of {{var}} with the corresponding value
        // This is a very basic and simplistic approach and may not cover all edge cases
        // For a more robust solution, you would want to use a templating library like Mustache or Handlebars
        // Or write your own custom parser/compiler
            $arrDataTemplates = $this->objDocMAP->query("//*[@data-template]");
            foreach ($this->arrData as $strKey => $strValue) {
                $textNodes = $this->objDocMAP->query('//text()[contains(., "' . $strKey . '")]');
                foreach ($textNodes as $node) {
                    $node->nodeValue = str_replace($strKey, $strValue, $node->nodeValue);
                }

                $attributes = $this->objDocMAP->query('//@*[contains(., "' . $strKey . '")]');
                foreach ($attributes as $attr) {
                    $attr->value = str_replace($strKey, $strValue, $attr->value);
                }
            }
        }    
    
        // Update htmDocContent with the modified document
        $this->htmDocContent = $this->saveHTML();
    }
}
?>