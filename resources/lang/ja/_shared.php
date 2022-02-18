<?php
$file = \Illuminate\Support\Str::replaceFirst('lang','shared_lang',__DIR__.'/front.json');
if(!file_exists($file)){
    return [];
}
$_shared = \Illuminate\Support\Arr::get(json_decode(file_get_contents($file),true)?:[],'_shared',[]);
return front_trans_conversion($_shared);
