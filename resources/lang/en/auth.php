<?php 
$str = <<<'str'
{
    "failed": "These credentials do not match our records.",
    "throttle": "Too many login attempts. Please try again in :seconds seconds."
}
str;
return json_decode($str,true);