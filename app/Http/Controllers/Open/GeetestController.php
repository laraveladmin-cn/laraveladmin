<?php

namespace App\Http\Controllers\Open;

use App\Services\SessionService;
use Illuminate\Support\Facades\Request as RequestFacade;
use ZBrettonYe\Geetest\Geetest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class GeetestController extends Controller
{
    /**
     * Get geetest.
     */
    public function geetest()
    {
        $data = [
            'user_id' => @Auth::user()?@Auth::user()->id:'UnLoginUser',
            'client_type' => 'web',
            'ip_address' => RequestFacade::header('x-real-ip',RequestFacade::ip())
        ];
        $status = Geetest::preProcess($data);
        SessionService::put('gtserver', $status);
        SessionService::put('user_id', $data['user_id']);
        return Geetest::getResponseStr();
    }
}
