<?php 
$str = <<<'str'
{
    "failed": "Неверное имя пользователя или пароль.",
    "throttle": "Слишком много попыток входа. Пожалуйста, попробуйте еще раз через :seconds секунд."
}
str;
return json_decode($str,true);