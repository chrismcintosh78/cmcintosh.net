<?php
class View{
    public $strViewPath;
    public $objPrimary;
    public $objSecondary;
    public $htmPrimary;

    public function __construct($strViewPath) {
        // Get the view template content
        $htmViewTemplate = file_get_contents($strViewPath);

        // Extract the model JSON file name from the view path
        $strModelName = basename($strViewPath, '.html') . '.json';
        $strModelPath = dirname(dirname($strViewPath)) . '/models/' . $strModelName;
        $arrPageInfo = [
                        "CONTENT_LEFT"=>"",
                        "CONTENT_CENTER"=>"",
                        "CONTENT_RIGHT"=>""
                ];

        // Load the JSON data
        if (file_exists($strModelPath)) {
            $strJsonContent = file_get_contents($strModelPath);
            $objJson = json_decode($strJsonContent);
            $arrPageInfo["CONTENT_LEFT"] = $objJson->CONTENT_LEFT;
            
            // Compile the view HTML using the JSON data
            $this->htmPrimary = Template::Compile($htmViewTemplate, $objJson);
        } else {
            // If the model file doesn't exist, use the raw template
            $this->htmPrimary = $htmViewTemplate;
        }
    }
}
?>