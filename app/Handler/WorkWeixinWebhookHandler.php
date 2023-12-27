<?php declare(strict_types=1);

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Handler;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Handler\Slack\SlackRecord;
use Swoole\Coroutine;
use function Swoole\Coroutine;

/**
 * Sends notifications through Slack Webhooks
 *
 * @author Haralan Dobrev <hkdobrev@gmail.com>
 * @see    https://api.slack.com/incoming-webhooks
 */
class WorkWeixinWebhookHandler extends AbstractProcessingHandler
{
    /**
     * Slack Webhook token
     * @var string
     */
    protected $webhookUrl;

    /**
     * Instance of the SlackRecord util class preparing data for Slack API.
     * @var SlackRecord
     */
    protected $token='';

    protected $lock_time = 0;


    public function __construct($config) {
        if (!extension_loaded('curl')) {
            throw new MissingExtensionException('The curl extension is needed to use the WorkWeixinWebhookHandler');
        }
        $bubble = $config['bubble'] ?? true;
        parent::__construct($config['level'], $bubble);
        $this->webhookUrl = $config['host'].$config['url'];
        $this->token = $config['token'];
        $this->lock_time = Arr::get($config,'lock_time',0)?:0;
    }

    public function getWebhookUrl(): string
    {
        return $this->webhookUrl;
    }

    /**
     * {@inheritDoc}
     */
    protected function write(array $record): void
    {
        if($this->lock_time){
            $key = 'logs_work_weixin_lock:'.md5(Arr::get($record,'message',''));
            if(Cache::get($key)){
                return;
            }
            Cache::put($key,1,now()->addSecond($this->lock_time));
        }
        $postData = [
            'msgtype'=>'markdown',
            'markdown'=>[
                'content'=>$this->getFormatter()->format($record)
            ]
        ];
        $sendCallBack = $this->sendCallBack();
        if(Coroutine::getcid()>0){
            Coroutine\go($sendCallBack,$postData);
        }else{
            register_shutdown_function($sendCallBack,$postData);
        }
    }

    /**
     * 发送消息回调函数
     * @return \Closure
     */
    protected function sendCallBack(){
        return function ($postData){
            try {
                $client = new GuzzleHttpClient([
                    'timeout' => 5,
                ]);
                $response = $client->request('POST', $this->webhookUrl, [
                    RequestOptions::HEADERS=> [
                        'Content-Type' => 'application/json',
                    ],
                    RequestOptions::BODY => json_encode($postData),
                    RequestOptions::QUERY=>[
                        'key'=>$this->token
                    ]
                ]);
                $body = $response->getBody()->getContents();
                $data = json_decode($body, true);
                if (Arr::get($data, 'errcode') !== 0) {
                    $error = [
                        'action' => __METHOD__,
                        'post_data' => $postData,
                        'response' => $data?:$body
                    ];
                    Log::channel('daily')->error('WorkWeixin sendMsg Exception',$error);
                }
            } catch (GuzzleException $e) {
                $error = [
                    'action' => __METHOD__,
                    $e->getCode() => $e->getMessage(),
                    'post_data' => $postData
                ];
                Log::channel('daily')->error('WorkWeixin sendMsg Exception',$error);
            }
        };
    }


}
