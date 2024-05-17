<?php 
$str = <<<'str'
{
    "reset": "A palavra-passe foi redefinida!",
    "sent": "O lembrete para a palavra-passe foi enviado!",
    "throttled": "Por favor aguarde, antes de tentar novamente.",
    "token": "Este código de recuperação da palavra-passe é inválido.",
    "user": "Não existe nenhum utilizador com o e-mail indicado.",
    "password": "A senha deve ser pelo Menos SEIS caracteres e deve coincidir com a senha de confirmação."
}
str;
return json_decode($str,true);