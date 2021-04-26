<?php
if(!file_exists(__DIR__.'/front.json')){
    return [];
}
return \Illuminate\Support\Arr::get(json_decode(file_get_contents(__DIR__.'/front.json'),true)?:[],'_shared',[]);
