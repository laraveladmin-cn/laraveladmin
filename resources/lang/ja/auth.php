<?php 
$str = <<<'str'
{
    "failed": "認証情報と一致するレコードがありません。",
    "throttle": "ログインの試行回数が多すぎます。:seconds 秒後にお試しください。"
}
str;
return json_decode($str,true);