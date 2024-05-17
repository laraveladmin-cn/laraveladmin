<?php 
$str = <<<'str'
{
    "failed": "Diese Kombination aus Zugangsdaten wurde nicht in unserer Datenbank gefunden.",
    "throttle": "Zu viele Loginversuche. Versuchen Sie es bitte in :seconds Sekunden nochmal."
}
str;
return json_decode($str,true);