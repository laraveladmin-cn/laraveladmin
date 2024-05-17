<?php 
$str = <<<'str'
{
    "status302": "リダイレクト",
    "redirectTo": "ルートをリダイレクト"
}
str;
return json_decode($str,true);