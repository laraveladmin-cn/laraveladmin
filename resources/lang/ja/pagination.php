<?php 
$str = <<<'str'
{
    "previous": "&laquo; 前",
    "next": "次 &raquo;"
}
str;
return json_decode($str,true);