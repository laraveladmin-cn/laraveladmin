<?php

namespace App\Console;

use Illuminate\Console\Command;

class BaseCommand extends Command
{

    /**
     * 翻译路径前缀
     * @var string
     */
    protected $transPath='commands';

    /**
     * 命令描述翻译处理
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function getDescription(){
        return trans_path($this->description,$this->transPath);
    }

}
