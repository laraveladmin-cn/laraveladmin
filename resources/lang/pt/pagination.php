<?php 
$str = <<<'str'
{
    "previous": "&laquo; Anterior",
    "next": "Próxima &raquo;"
}
str;
return json_decode($str,true);