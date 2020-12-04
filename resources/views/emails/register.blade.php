@component('mail::message')
<?php
use \Illuminate\Support\Arr;
?>
# 用户注册
您好:<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;您的账号注册验证码是: `{{$code}}`
<br/>
请在1小时内使用该验证码

谢谢,{{ config('app.name') }}
@endcomponent
