<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 最大连接数
     * The number of times the job may be attempted.
     * @var int
     */
    public $tries = 3;

    /**
     * 超时时长
     * @var int
     */
    public $timeout = 15;

    /**
     * 短信内容
     */
    protected $sms;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sms)
    {
        $this->sms = $sms;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sms->send();
    }
}
