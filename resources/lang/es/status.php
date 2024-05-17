<?php 
$str = <<<'str'
{
    "status302": "Redirección de enrutamiento",
    "redirectTo": "Redirección de enrutamiento a"
}
str;
return json_decode($str,true);