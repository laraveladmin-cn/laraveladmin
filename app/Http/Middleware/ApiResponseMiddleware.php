<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ApiResponseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if($request->header('Format-Response')){
            if(get_class($response)=='Illuminate\Http\JsonResponse'){
                $content = json_decode($response->getContent(),true);
            }else{
                $content = $response->getContent();
            }
            $code = $response->getStatusCode();
            if($code==422 || (200<=$code && $code<300)){
                $data = [
                    'code'=>$code,
                    'data'=>$content
                ];
                if($alert = Arr::get($content,'alert')){
                    $data['msg'] = $alert;
                }elseif ($code==422){
                    if($content && is_array($content)){
                        $errors = Arr::get($content,'errors');
                        if($errors){
                            $msg = collect($errors)->map(function ($items){
                                if(is_array($items)){
                                    return collect($items)->implode(';');
                                }
                                return $items;
                            })->implode(';');
                        }else{
                            $msg = Arr::get($content,'message','');
                        }
                    }else{
                        $msg =  $response->getContent();
                    }
                    $data['msg'] = alert([
                        'message' =>$msg
                    ], 422);
                }
                $response->setContent(json_encode($data));
                $response->setStatusCode(200);
            }
        }
        return $response;
    }
}
