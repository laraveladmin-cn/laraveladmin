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
class FeishuWebhookHandler extends AbstractProcessingHandler
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
            throw new MissingExtensionException('The curl extension is needed to use the FeishuWebhookHandler');
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

    protected function makeSign($time = '')
    {
        $timestamp = $time ? $time : time();
        $secret = $this->token;
        $string = "{$timestamp}\n{$secret}";
        return base64_encode(hash_hmac('sha256', "", $string, true));
    }

    /**
     * {@inheritDoc}
     */
    protected function write(array $record): void
    {
        if($this->lock_time){
            $key = 'logs_feishu_lock:'.md5(Arr::get($record,'message',''));
            if(Cache::get($key)){
                return;
            }
            Cache::put($key,1,now()->addSecond($this->lock_time));
        }
        $timestamp = time();
        $postData = [
            "timestamp" => $timestamp,
            "sign" => $this->makeSign($timestamp),
            "msg_type" => "text",
            "content" => [
                "text" => $this->getFormatter()->format($record),
            ]
        ];
        $sendCallBack = $this->sendCallBack();
        if(class_exists('Swoole\\Coroutine') && Coroutine::getcid()>0){
            Coroutine\go($sendCallBack,$postData);
        }elseif(php_sapi_name() === 'fpm-fcgi'){
            register_shutdown_function($sendCallBack,$postData);
        }else{
            $sendCallBack($postData);
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
                    'headers' => [
                        'content-type' => 'application/json',
                    ],
                    RequestOptions::JSON => $postData,
                ]);
                $body = $response->getBody()->getContents();

                $data = json_decode($body, true);
                if (Arr::get($data, 'StatusMessage') != 'success') {
                    $error = [
                        'action' => __METHOD__,
                        'url'=>$this->webhookUrl,
                        'post_data' => $postData,
                        'response' => $data
                    ];
                    Log::channel('daily')->error('FeishuBot sendMsg Exception',$error);
                }
            } catch (GuzzleException $e) {
                $error = [ 'action' => __METHOD__, $e->getCode() => $e->getMessage(), 'post_data' => $postData];
                Log::channel('daily')->error('FeishuBot sendMsg Exception',$error);
            }
        };
    }


}
