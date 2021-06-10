<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class QiNiuController extends Controller
{
    /**
     * 七牛云token
     */
    public function getToken()
    {
        $disk = Request::get('disk', 'qiniu');
        $prefix = 'filesystems.disks.' . $disk . '.';
        $accessKey = config($prefix . 'access_key');//env('QINIU_ACCESS_KEY');
        $secretKey = config($prefix . 'secret_key');//env('QINIU_SECRET_KEY');
        $bucket = config($prefix . 'bucket');//env('QINIU_BUCKET');
        $auth = new \Qiniu\Auth($accessKey, $secretKey);
        $token = $auth->uploadToken($bucket, null, 3600);
        return [
            'token' => $token,
            'domain' => config($prefix . 'transport') . '://' . config($prefix . 'domains.default')
        ];

    }




}
