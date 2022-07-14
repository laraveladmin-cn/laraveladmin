<?php 
$str = <<<'str'
{
    "failed": "Ces identifiants ne correspondent pas à nos enregistrements",
    "throttle": "Tentatives de connexion trop nombreuses. Veuillez essayer de nouveau dans :seconds secondes."
}
str;
return json_decode($str,true);