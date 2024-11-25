<?php
class Document extends DOMDocument {
    private $strDocPath;      // Path to the document file (if any)
    private $htmDocContent;  // Raw HTML content of the document
    private $objDocMAP;      // DOMXPath instance for querying

    /**
     * Constructor
     * 
     * @param string|false $strDocPath Path to the HTML file or false for a default document.
     */
    public function __construct($strDocPath = false) {
        parent::__construct();

        // Set document path
        $this->strDocPath = $strDocPath;

        // Load content from file or use default HTML structure
        if ($strDocPath) {
            $this->htmDocContent = file_get_contents($this->strDocPath);
        } else {
            $this->htmDocContent = "<!DOCTYPE html><html><head><title>Document</title></head><body></body></html>";
        }

        // Suppress warnings for malformed HTML
        @$this->loadHTML($this->htmDocContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Create an internal DOMXPath object for querying
        $this->objDocMAP = new DOMXPath($this);
    }

    /**
     * Get the internal DOMXPath object.
     * 
     * @return DOMXPath The DOMXPath instance for the document.
     */
    public function getXPath() {
        return $this->objDocMAP;
    }

    /**
     * Query elements using a CSS-style selector.
     * 
     * @param string $strSelector The CSS selector (e.g., "#id", ".class", "tag").
     * @return DOMNodeList|null List of matching elements or null if none found.
     */
    public function querySelector($strSelector) {
        $strXPathQuery = $this->cssToXPath($strSelector);
        return $this->objDocMAP->query($strXPathQuery);
    }

    /**
     * Query a single element using a CSS-style selector.
     * 
     * @param string $strSelector The CSS selector.
     * @return DOMElement|null The first matching element or null if none found.
     */
    public function querySelectorOne($strSelector) {
        $objNodes = $this->querySelector($strSelector);
        return $objNodes ? $objNodes->item(0) : null;
    }

    /**
     * Set the inner content of an element.
     * 
     * @param DOMElement $objElement The element to modify.
     * @param string $htmContent The new inner HTML content.
     */
    public function setInnerHTML(DOMElement $objElement, $htmContent) {
        // Clear existing children
        while ($objElement->firstChild) {
            $objElement->removeChild($objElement->firstChild);
        }

        // Load new content
        $objFragment = $this->createDocumentFragment();
        $objFragment->appendXML($htmContent);
        $objElement->appendChild($objFragment);
    }

    /**
     * Get the inner HTML of an element.
     * 
     * @param DOMElement $objElement The element to retrieve the content from.
     * @return string The inner HTML of the element.
     */
    public function getInnerHTML(DOMElement $objElement) {
        $htmInnerHTML = '';
        foreach ($objElement->childNodes as $objChild) {
            $htmInnerHTML .= $this->saveHTML($objChild);
        }
        return $htmInnerHTML;
    }

    /**
     * Check if a string is valid HTML.
     * 
     * @param string $htmContent The string to validate.
     * @return bool True if the string is valid HTML, otherwise false.
     */
    public function isHTML($htmContent) {
        $objTempDoc = new DOMDocument();
        libxml_use_internal_errors(true);
        $bolIsValid = $objTempDoc->loadHTML($htmContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        return $bolIsValid;
    }
    public function addStylesheet($strFilePath) {
        // Create a <link> element for the stylesheet
        $objLink = $this->createElement('link');
        $objLink->setAttribute('rel', 'stylesheet');
        $objLink->setAttribute('type', 'text/css');
        $objLink->setAttribute('href', $strFilePath);
    
        // Locate the <head> element using XPath
        $objHead = $this->getXPath()->query('//head')->item(0);
    
        if ($objHead) {
            // Append the <link> element to the <head>
            $objHead->appendChild($objLink);
        } else {
            throw new Exception('No <head> element found in the document.');
        }
    }
    
    public function addScript($strFilePath) {
        // Create a <script> element for the JavaScript file
        $objScript = $this->createElement('script');
        $objScript->setAttribute('type', 'text/javascript');
        $objScript->setAttribute('src', $strFilePath);
    
        // Locate the <body> element using XPath
        $objBody = $this->getXPath()->query('//body')->item(0);
    
        if ($objBody) {
            // Append the <script> element to the <body>
            $objBody->appendChild($objScript);
        } else {
            throw new Exception('No <body> element found in the document.');
        }
    }
    /**
     * Convert a CSS selector to an XPath query.
     * 
     * @param string $strSelector The CSS selector.
     * @return string The equivalent XPath query.
     */

    
    private function cssToXPath($strSelector) {
        if (strpos($strSelector, '#') === 0) {
            // Convert ID selectors to XPath
            return "//*[@id='" . substr($strSelector, 1) . "']";
        } elseif (strpos($strSelector, '.') === 0) {
            // Convert class selectors to XPath
            return "//*[contains(concat(' ', normalize-space(@class), ' '), ' " . substr($strSelector, 1) . " ')]";
        } elseif (preg_match('/^\[([^\]=]+)=["\']?([^"\']+)["\']?\]$/', $strSelector, $matches)) {
            // Convert attribute selectors (e.g., [data-template="variable"]) to XPath
            $strAttr = $matches[1];
            $strValue = $matches[2];
            return "//*[@" . $strAttr . "='" . $strValue . "']";
        } else {
            // Default to tag name
            return "//" . $strSelector;
        }
    }
}

?>