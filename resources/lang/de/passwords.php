<?php 
$str = <<<'str'
{
    "reset": "Das Passwort wurde zurückgesetzt!",
    "sent": "Passworterinnerung wurde gesendet!",
    "throttled": "Please wait before retrying.",
    "token": "Der Passwort-Wiederherstellungs-Schlüssel ist ungültig oder abgelaufen.",
    "user": "Es konnte leider kein Nutzer mit dieser E-Mail-Adresse gefunden werden.",
    "password": "Das Passwort sollte mindestens sechs Zeichen haben und mit dem Bestätigungspasswort übereinstimmen."
}
str;
return json_decode($str,true);