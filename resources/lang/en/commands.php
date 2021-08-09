<?php 
$str = <<<'str'
{
    "Compile and generate the front-end entry file \"index.html\"": "Compile and generate the front-end entry file \"index.html\"",
    "Execute all migration files": "Execute all migration files",
    "Is the \":file\" file already overwritten?": "Is the \":file\" file already overwritten?",
    "The \":file\" file already exists": "The \":file\" file already exists",
    "File \":file\" created successfully": "File \":file\" created successfully",
    "Failed to create file \":file\"": "Failed to create file \":file\"",
    "Generate all resources": "Generate all resources",
    "Custom template controller generation": "Custom template controller generation",
    "Created At": "Created At",
    "Updated At": "Updated At",
    "Deleted At": "Deleted At",
    "Custom template model generation": "Custom template model generation",
    "Custom template data fill file generation": "Custom template data fill file generation",
    "Custom template front-end view generation": "Custom template front-end view generation",
    "The application language is not set to English to execute": "The application language is not set to English to execute",
    "From \":old\" to \":new\"": "From \":old\" to \":new\"",
    "Failed to translate \":old\"": "Failed to translate \":old\"",
    "Failed to translate \":old\" into \":lang\"": "Failed to translate \":old\" into \":lang\"",
    "This command can only be executed in the development environment": "This command can only be executed in the development environment",
    "Automatic scan to generate Api document data": "Automatic scan to generate Api document data"
}
str;
return json_decode($str,true);