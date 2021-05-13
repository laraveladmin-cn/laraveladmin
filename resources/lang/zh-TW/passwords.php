<?php 
$str = <<<'str'
{
    "reset": "密碼已成功重設！",
    "sent": "密碼重設郵件已發送！",
    "throttled": "請稍候再試。",
    "token": "密碼重設碼無效。",
    "user": "找不到該 E-mail 對應的使用者。",
    "password": "密碼至少是六比特字元並且應與確認密碼匹配。"
}
str;
return json_decode($str,true);