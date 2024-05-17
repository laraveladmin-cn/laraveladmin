<?php 
$str = <<<'str'
{
    "previous": "&laquo; Précédent",
    "next": "Suivant &raquo;"
}
str;
return json_decode($str,true);