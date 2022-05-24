<?php 
$str = <<<'str'
{
    "previous": "&laquo; Precedente",
    "next": "Successivo &raquo;"
}
str;
return json_decode($str,true);