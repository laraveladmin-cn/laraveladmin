<?php 
$str = <<<'str'
{
    "status302": "Redirection du routage",
    "redirectTo": "Redirection vers"
}
str;
return json_decode($str,true);