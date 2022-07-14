<?php 
$str = <<<'str'
{
    "reset": "La password è stata reimpostata!",
    "sent": "Promemoria della password inviato!",
    "throttled": "Please wait before retrying.",
    "token": "Questo token per la reimpostazione della password non è valido.",
    "user": "Non esiste un utente associato a questo indirizzo e-mail.",
    "password": "La password deve contenere almeno sei caratteri e corrispondere alla password di conferma."
}
str;
return json_decode($str,true);