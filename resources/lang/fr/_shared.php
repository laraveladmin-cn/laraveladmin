<?php
if(!file_exists(__DIR__.'/front.json')){
    return [];
}
return (function(){
    $_shared = \Illuminate\Support\Arr::get(json_decode(file_get_contents(__DIR__.'/front.json'),true)?:[],'_shared',[]);
    return front_trans_conversion($_shared);
})();
