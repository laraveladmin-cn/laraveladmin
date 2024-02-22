<?php

namespace App\Console\Commands;

use App\Console\BaseCommand;
use App\Http\Controllers\Open\IndexController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * 创建API接口加解密使用的非对称加密秘钥对
 */
class CreateApiSecret extends BaseCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:api-secret {--f|force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create asymmetric encryption key pair for API interface encryption and decryption';

    protected $path = 'storage/app/secret_key/api';
    protected $disk = null;
    protected $rsa_raw_js = 'resources/js/plugin/rsa_raw.js';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $app_key = config('app.key');
        if(!$app_key){
            return $this->error('请先执行命令`php artisan key:generate`生成APP_KEY后再试');
        }
        //查询秘钥是否存在
        $disk = $this->disk = Storage::disk('root');
        $exist = $disk->exists($this->path.'/server_rsa.pub');
        if(!$this->option('force') && $exist){
            $this->warn('API秘钥对已存在!'.base_path($this->path));
            return ;
        }
        if(!$disk->exists($this->path)){
            $disk->makeDirectory($this->path);
        }
        $public_key = trim($this->writeSecretFile());
        $private_key = trim($this->writeSecretFile('client'));
        $rsa_raw = <<<str
let data = {
    server_rsa_pub:`$public_key`,
    client_rsa:`$private_key`
};
export default data;
str;
        $this->disk->put($this->rsa_raw_js,$rsa_raw);
        $rsa_js = Str::replaceFirst('rsa_raw.js','rsa.js',$this->rsa_raw_js);
        $this->disk->put($rsa_js,$rsa_raw);
        $path = base_path($this->path);
        $this->info("API秘钥对生成成功秘钥存放目录在:$path\n您可将秘钥'$this->rsa_raw_js'\n文件中的data变量进行加密混淆保护后替换到文件\n'$rsa_js'中\n在线加密混淆工具:https://www.xdtool.com/jsjiami");
    }

    protected function writeSecretFile($name='server'){
        $secret_arr = $this->createSecret();
        $this->disk->put($this->path.'/'.$name.'_rsa.pub',$secret_arr['public_key']);
        $this->disk->put($this->path.'/'.$name.'_rsa',$secret_arr['private_key']);
        return $name=='server'?$secret_arr['public_key']:$secret_arr['private_key'];
    }

    /**
     * 创建秘钥
     * @return void
     */
    protected function createSecret(){
        // 生成私钥和公钥
        $config = array(
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );

        $res = openssl_pkey_new($config);
        $private_key = '';
        openssl_pkey_export($res, $private_key);

        $public_key = openssl_pkey_get_details($res);
        $public_key = $public_key["key"];
        return [
            'private_key'=>$private_key,
            'public_key'=>$public_key
        ];
    }



}
