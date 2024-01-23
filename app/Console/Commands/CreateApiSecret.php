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
        $public_key = $this->writeSecretFile();
        $private_key = $this->writeSecretFile('client');
      /*  $data = [
            'public_key'=>$public_key,
            'private_key'=>$private_key
        ];
        $cipher_str = json_encode($data);
        $encrypted = openssl_encrypt($cipher_str, 'AES-256-CBC', md5($app_key));
        $this->disk->put($this->path.'/js.txt',$encrypted);*/
        $this->info('API秘钥对生成成功:'.base_path($this->path));
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
