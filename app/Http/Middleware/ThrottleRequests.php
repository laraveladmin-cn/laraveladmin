<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;

class ThrottleRequests extends \Illuminate\Routing\Middleware\ThrottleRequests
{
    /**
     * Resolve request signature.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     *
     * @throws \RuntimeException
     */
    protected function resolveRequestSignature($request)
    {
        if ($user = $request->user()) {
            return sha1($user->getAuthIdentifier());
        } elseif ($route = $request->route()) {
            $ip = RequestFacade::header('x-real-ip',$request->ip()); //swoole兼容中获取真实ip
            return sha1($route->getDomain().'|'.$ip);
        }

        throw new \RuntimeException(trans('Unable to generate the request signature, Route unavailable'));
    }
}
