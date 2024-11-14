<?php
class View extends Document{
    public $strViewPath;
    public $htmPrimary;
    public $htmSecondary;

    public function __construct($strViewPath) {
        parent::__construct($strViewPath);
        $this->strViewPath = $strViewPath;
        //GET THE PRIMARY and SECONDARY nodes from the view
        $primaryNode = $this->objDocMAP->query('//primary')->item(0);
        $this->htmPrimary = $primaryNode ? $primaryNode->ownerDocument->saveHTML($primaryNode) : '';
        $this->htmSecondary = $this->objDocMAP->query('//secondary')->item(0)->nodeValue;
    }
}
?>