<?php
class Template extends Document {
    private $arrTemplateData; // Key-value pairs for template placeholders
    private $arrViewData = []; // Key-value pairs for view-specific data

    /**
     * Constructor
     * 
     * @param string $strTemplatePath Path to the template file.
     * @param array $arrTemplateData Key-value pairs for template placeholders (optional).
     */
    public function __construct($strTemplatePath, array $arrTemplateData = []) {
        parent::__construct($strTemplatePath);

        $this->arrTemplateData = $arrTemplateData;
        $this->applyTemplateData();
        $this->appendDeps($GLOBALS["RESOURCE_PATH"]);
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
    /**
     * Add key-value pairs to the view data array.
     * 
     * @param mixed $key A string key or an array/object of key-value pairs.
     * @param mixed $value The value associated with the key (ignored if $key is an array or object).
     */
    public function addData($key, $value = null) {
        if (is_array($key) || is_object($key)) {
            foreach ($key as $strKey => $mixValue) {
                $this->arrViewData[$strKey] = $mixValue;
            }
        } elseif (is_string($key)) {
            $this->arrViewData[$key] = $value;
        }
    }

    /**
     * Remove a key from the view data array.
     * 
     * @param string $strKey The key to remove.
     */
    public function remData($strKey) {
        if (isset($this->arrViewData[$strKey])) {
            unset($this->arrViewData[$strKey]);
        }
    }

    /**
     * Insert a view into the document.
     * 
     * @param string $strViewPath The path to the view file.
     * @param string $strVar The identifier for the target node (data-view="var").
     * @throws Exception If the view file or target node is not found.
     */
    public function insertView($strViewPath, $strVar) {
        if (!file_exists($strViewPath)) {
            throw new Exception("View file not found: $strViewPath");
        }

        $htmViewContent = file_get_contents($strViewPath);
        $objTargetNode = $this->querySelectorOne("[data-view='$strVar']");

        if (!$objTargetNode) {
            throw new Exception("Target node with data-view='$strVar' not found in the template.");
        }

        $this->setInnerHTML($objTargetNode, $htmViewContent);
    }

    /**
     * Apply the template data to the document.
     */
    private function applyTemplateData() {
        foreach ($this->arrTemplateData as $strKey => $mixValue) {
            $objNodes = $this->querySelector("[data-template='$strKey']");
            if ($objNodes) {
                foreach ($objNodes as $objNode) {
                    $this->setInnerHTML($objNode, $mixValue);
                }
            }
        }
    }

    /**
     * Compile the document by replacing `{{key}}` placeholders with values from `arrViewData`.
     */
    public function compile() {
        foreach ($this->arrViewData as $strKey => $mixValue) {
            $strPattern = "/{{\s*$strKey\s*}}/";
            $objTextNodes = $this->getXPath()->query('//text()');
            foreach ($objTextNodes as $objNode) {
                if (preg_match($strPattern, $objNode->nodeValue)) {
                    if ($this->isHTML($mixValue)) {
                        $objFragment = $this->createDocumentFragment();
                        @$objFragment->appendXML($mixValue);
                        $objNode->parentNode->replaceChild($objFragment, $objNode);
                    } else {
                        $objNode->nodeValue = preg_replace($strPattern, $mixValue, $objNode->nodeValue);
                    }
                }
            }
        }
    
        // Serialize the document to HTML
        $htmlContent = $this->saveHTML();
    
        // Decode URL-encoded HTML to handle encoded placeholders
        $decodedContent = urldecode($htmlContent);
    
        // Debugging: Output intermediate content
        //print "<HTMLSTART>" . htmlspecialchars($decodedContent) . "<HTMLEND>";
    
        // Perform regex replacements for any remaining placeholders
        $decodedContent = preg_replace_callback('/{{\s*(.*?)\s*}}/', function($matches) {
            $strKey = trim($matches[1]);
            return isset($this->arrViewData[$strKey]) ? $this->arrViewData[$strKey] : $matches[0];
        }, $decodedContent);
    
        // Reload the modified HTML back into the DOMDocument
        $this->loadHTML($decodedContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    }
    

    /**
     * Check if a value is a PHP expression.
     * 
     * @param string $strValue The value to check.
     * @return bool True if it is a PHP expression, false otherwise.
     */

    private function isPHPExpression($strValue) {
        return is_string($strValue) && preg_match('/^\s*return\s+.+;\s*$/', $strValue);
    }
}

?>
