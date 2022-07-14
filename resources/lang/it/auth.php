<?php 
$str = <<<'str'
{
    "failed": "Credenziali non corrispondenti ai dati registrati.",
    "throttle": "Troppi tentativi di accesso. Riprova tra :seconds secondi."
}
str;
return json_decode($str,true);