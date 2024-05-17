<?php 
$str = <<<'str'
{
    "status302": "Reindirizzamento del percorso",
    "redirectTo": "Reindirizza il percorso a"
}
str;
return json_decode($str,true);