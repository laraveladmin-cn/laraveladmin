<?php 
$str = <<<'str'
{
    "previous": "&laquo; Zurück",
    "next": "Weiter &raquo;"
}
str;
return json_decode($str,true);