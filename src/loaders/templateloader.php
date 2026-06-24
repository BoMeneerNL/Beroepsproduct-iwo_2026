<?php
require_once __DIR__ . '/../utils.php';
disallowDirectAccess(__FILE__);



function getTemplate(string $templateName, array|null $templateData = null)
{
    if(str_starts_with($templateName, 'php%')) {
        throw new Exception("PHP templates are not meant to be gotten, only to be printed. Use printTemplate() instead.");
    }
    $files = glob(__DIR__ . "/../templates/{$templateName}.html");

    if (empty($files)) {
        throw new Exception("Template '{$templateName}' not found.");
    }
    $file = $files[0];
    $text = fread(fopen($file, 'r'), filesize($file));
    if (isset($templateData)) {
        $text = preg_replace_callback('/{{\s*(\w+)\s*}}/', function ($matches) use ($templateData) {
            $key = $matches[1];
            return isset($templateData[$key]) ? htmlspecialchars($templateData[$key]) : $matches[0];
        }, $text);
    }
    return $text;

}

function printTemplate(string $templateName, array|null $templateData = null): void
{
    try {
        if(str_starts_with($templateName, 'php%')) {
            
            $templateName = str_replace('php%', '', $templateName);
            require_once __DIR__ . "/../templates/{$templateName}.php";
        }
        else{
            echo getTemplate($templateName, $templateData);
        }
        
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}