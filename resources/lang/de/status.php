<?php 
$str = <<<'str'
{
    "status302": "Routenumleitung",
    "redirectTo": "Weiterleitung der Route zu"
}
str;
return json_decode($str,true);