<?php 
$str = <<<'str'
{
    "status302": "路由重定向",
    "redirectTo": "路由重定向至"
}
str;
return json_decode($str,true);