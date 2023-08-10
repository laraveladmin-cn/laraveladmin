<?php
require 'vendor/autoload.php';

$composer = json_decode(file_get_contents('composer.json'), true);
$args = $_SERVER['argv'];
$args_str = implode(' ',$args);
$packages = $composer['require'];
$flog = true;
foreach ($packages as $package => $version) {
    if(strpos($package,'/') && !is_dir(__DIR__.'/vendor/'.$package)){
        $flog = true;
        echo "\033[32m安装 {$package}:{$version}...\033[0m\n";
        shell_exec("composer require {$package}:{$version} -vvv");
        echo "\033[32m{$package}:{$version}安装完成!\033[0m\n";
    }
}
if(!strpos($args_str,' --no-dev')){
    $packages = $composer['require-dev'];
    foreach ($packages as $package => $version) {
        if(strpos($package,'/') && !is_dir(__DIR__.'/vendor/'.$package)){
            $flog = true;
            echo "\033[32m安装 {$package}:{$version}...\033[0m\n";
            shell_exec("composer require --dev {$package}:{$version} -vvv");
            echo "\033[32m{$package}:{$version}安装完成!\033[0m\n";
        }
    }
}
if($flog){
    echo "\033[32m没有发现需要安装的包\033[0m\n";
}
