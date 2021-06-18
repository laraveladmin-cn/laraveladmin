<?php 
$str = <<<'str'
{
    "status302": "Перенаправление маршрута",
    "redirectTo": "Перенаправление маршрута"
}
str;
return json_decode($str,true);