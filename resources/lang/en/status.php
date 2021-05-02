<?php 
$str = <<<'str'
{
    "status302": "Route redirection",
    "redirectTo": "Routing is redirected to"
}
str;
return json_decode($str,true);