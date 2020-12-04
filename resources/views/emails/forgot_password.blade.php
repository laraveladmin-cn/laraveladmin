@component('mail::message')
<?php
use \Illuminate\Support\Arr;
?>
# 找回密码
{{Arr::get($user,'name',Arr::get($user,'uname'))}} 您好:<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;您的找回密码验证码是: `{{$code}}`
<br/>
请在1小时内使用该验证码

谢谢,{{ config('app.name') }}
@endcomponent
