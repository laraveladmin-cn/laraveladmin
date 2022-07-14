<?php 
$str = <<<'str'
{
    "previous": "&laquo; 이전",
    "next": "다음 &raquo;"
}
str;
return json_decode($str,true);