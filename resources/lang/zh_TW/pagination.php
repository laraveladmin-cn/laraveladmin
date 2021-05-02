<?php 
$str = <<<'str'
{
    "previous": "&laquo; 上一頁",
    "next": "下一頁 &raquo;"
}
str;
return json_decode($str,true);