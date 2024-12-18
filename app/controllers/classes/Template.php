<?php
class Template extends Document{
    public $strTemplatePath;
    //THE DATA TO BE INSERTED INTO THE TEMPLATE
    public $arrData;
   
    public static function Compile($strHtml, $objJson) {
        // Use a regular expression to find all placeholders in the format {{key}} or {{key[index]}} or {{parent.child}}
        return preg_replace_callback('/{{\s*([\w\.\[\]]+)\s*}}/', function($matches) use ($objJson) {
            $expression = $matches[1];
            // Replace dots with '->' for object property access
            $expression = preg_replace('/\.(\w+)/', '->{"$1"}', $expression);
            // Replace array access syntax
            $expression = preg_replace('/\[(\d+)\]/', '[$1]', $expression);

            // Use eval to evaluate the expression
            try {
                $value = null;
                eval('$value = $objJson->' . $expression . ';');
                return $value !== null ? $value : $matches[0];
            } catch (Exception $e) {
                return $matches[0]; // Return the original placeholder if evaluation fails
            }
        }, $strHtml);
    }    
    
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
    public function addData($key, $strValue=false){
        if(is_array($key) or is_object($key)){
            foreach ($key as $arrKey => $arrValue) {
                $this->addData($arrKey, $arrValue);
            }   
        }else if(is_string($key))  {
            $this->arrData[$key] = $strValue;
        }
    }
    public function remData($strKey){
        unset($this->arrData[$strKey]);
    }

    public function _compile($bolHb=true) {
        if($bolHb){
            foreach ($this->arrData as $strKey => $strValue) {
                $pattern = '/\{\{' . preg_quote($strKey, '/') . '\}\}/';
                //SEE IF strValue is a DOMDocument node, if so, render its innerHTMLnodes containing {{var}}
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
                }

                // Find all attributes containing {{var}}
                $attributes = $this->objDocMAP->query('//@*[contains(., "{{' . $strKey . '}}")]');
                foreach ($attributes as $attr) {
                    $newValue = preg_replace($pattern, $strValue, $attr->value);
                    $attr->value = $newValue;
                }
            }
                // Get the current HTML content
            $htmlContent = $this->saveHTML();

            // Replace any remaining handlebars in attributes
            $htmlContent = preg_replace_callback('/\{\{([\w\.\[\]]+)\}\}/', function($matches) {
                $key = $matches[1];
                return isset($this->arrData[$key]) ? $this->arrData[$key] : $matches[0];
            }, $htmlContent);

            // Load the modified HTML back into the document
            $this->loadHTML($htmlContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            // Update htmDocContent with the modified document
            $this->htmDocContent = $this->saveHTML();
        }

        /*
  
        */
        // Update htmDocContent with the modified document
        $this->htmDocContent = $this->saveHTML();
    }
}
?>