<?php 
$str = <<<'str'
{
    "reset": "Your password has been reset!",
    "sent": "We have e-mailed your password reset link!",
    "throttled": "throttled",
    "token": "This password reset token is invalid.",
    "user": "We can't find a user with that e-mail address.",
    "password": "Passwords must be at least eight characters and match the confirmation."
}
str;
return json_decode($str,true);