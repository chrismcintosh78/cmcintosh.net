<?php

// Load JSON data from file
$jsonData = file_get_contents('/var/www/html/cmcintosh.net/public_html/app/models/home.json');

// Decode JSON data into a PHP array
$dataArray = json_decode($jsonData, true);

// Check if decoding was successful
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "Error decoding JSON: " . json_last_error_msg();
    exit;
}

// Access the data
$introPara1 = $dataArray['intro']['para1'];
$introPara2 = $dataArray['intro']['para2'];

// Debugging output
echo "Intro Paragraph 1: " . $introPara1 . "\n";
echo "Intro Paragraph 2: " . $introPara2 . "\n";

?>