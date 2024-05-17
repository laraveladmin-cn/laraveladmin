<?php 
$str = <<<'str'
{
    "failed": "Estas credenciales no coinciden con nuestros registros.",
    "throttle": "Demasiados intentos de acceso. Por favor intente nuevamente en :seconds segundos."
}
str;
return json_decode($str,true);