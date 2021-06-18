<?php 
$str = <<<'str'
{
    "failed": "As credenciais indicadas não coincidem com as registadas no sistema.",
    "throttle": "O número limite de tentativas de login foi atingido. Por favor tente novamente dentro de :seconds segundos."
}
str;
return json_decode($str,true);