<?php 
$str = <<<'str'
{
    "previous": "&laquo; Назад",
    "next": "Вперёд &raquo;"
}
str;
return json_decode($str,true);