<?php 
$str = <<<'str'
{
    "failed": "使用者名稱或密碼錯誤",
    "throttle": "嘗試登入太多次，請在 :seconds 秒後再試。"
}
str;
return json_decode($str,true);