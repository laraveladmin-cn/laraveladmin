<?php 
$str = <<<'str'
{
    "previous": "&laquo; Anterior",
    "next": "Siguiente &raquo;"
}
str;
return json_decode($str,true);