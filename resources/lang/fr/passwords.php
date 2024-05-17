<?php 
$str = <<<'str'
{
    "reset": "Votre mot de passe a été réinitialisé !",
    "sent": "Nous vous avons envoyé par email le lien de réinitialisation du mot de passe !",
    "throttled": "Veuillez patienter avant de réessayer.",
    "token": "Ce jeton de réinitialisation du mot de passe n'est pas valide.",
    "user": "Aucun utilisateur n'a été trouvé avec cette adresse email.",
    "password": "Le mot de passe doit être d'au moins six caractères et doit correspondre au mot de passe de confirmation."
}
str;
return json_decode($str,true);