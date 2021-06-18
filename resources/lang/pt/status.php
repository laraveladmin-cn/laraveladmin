<?php 
$str = <<<'str'
{
    "status302": "Redirecionamento Da rota",
    "redirectTo": "Redirecionamento de rota"
}
str;
return json_decode($str,true);