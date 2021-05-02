<?php 
$str = <<<'str'
{
    "previous": "&laquo; Previous",
    "next": "Next &raquo;"
}
str;
return json_decode($str,true);