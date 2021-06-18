<?php 
$str = <<<'str'
{
    "reset": "¡Tu contraseña ha sido restablecida!",
    "sent": "¡Te hemos enviado por correo el enlace para restablecer tu contraseña!",
    "throttled": "Por favor espera antes de intentar de nuevo.",
    "token": "El token de recuperación de contraseña es inválido.",
    "user": "No podemos encontrar ningún usuario con ese correo electrónico.",
    "password": "La contraseña debe tener al menos seis caracteres y coincidir con la contraseña de confirmación."
}
str;
return json_decode($str,true);