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
    "Automatic scan to generate Api document data": "Automatic scan to generate Api document data",
    "Initializing the creation of a soft connection": "Initializing the creation of a soft connection",
    "The \":link\" link has been connected to \":target\"": "The \":link\" link has been connected to \":target\"",
    "The links have been created": "The links have been created",
    "Generate software code text for software copyright application": "Generate software code text for software copyright application",
    "To enable support for relative links, please install the symfony/filesystem package": "To enable support for relative links, please install the symfony/filesystem package",
    "Failed to delete file \":file\"": "Failed to delete file \":file\""
}
str;
return json_decode($str,true);