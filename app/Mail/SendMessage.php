<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMessage extends Mailable
{
    use SerializesModels,Queueable;
    protected $subject_name;
    protected $template;
    protected $data;
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
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject_name,$template,$data)
    {
        $this->subject_name = $subject_name;
        $this->template = $template;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject_name)
            ->markdown($this->template)
            ->with($this->data?:[]);
    }
}
