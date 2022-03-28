<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class MapController extends Controller
{
    /**
     * 高德地图搜索
     * @return mixed
     */
    public function searchAmap(){
        $url = 'https://restapi.amap.com/v5/place/text';
        $prams = Request::only(['keywords','types','city','citylimit','children','offset','page','extensions','sig','output','callback']);
        $prams['key'] = config('laravel_admin.amap.web_api.key','');
        try {
            $response = (new Client([
                'timeout'  => 5,
            ]))->request('get', $url, ['query'=>$prams]);
            if ($response->getStatusCode() == 200) {
                $stringBody = $response->getBody()->getContents();
                $data = json_decode($stringBody,true);
                if(Arr::get($data,'status')==1){
                    return Response::returns($data);
                }
            }
        } catch (\Exception $e) {
        }
        return Response::returns([]);
    }

    /**
     * 谷歌地图关键字搜索
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function searchGoogle(){
        $url = 'https://maps.googleapis.com/maps/api/geocode/json';
        $prams = Request::only([  'address',
            'bounds',
            'key',
            'region',
            'language',
            'result_type',
            'location_type',
            'latlng',
            'place_id',
            'components'
            ]);
        $prams['key'] = config('laravel_admin.google.web_api.key','');
        try {
            $response = (new Client([
                'timeout'  => 5,
            ]))->request('get', $url, ['query'=>$prams]);
            $status = $response->getStatusCode();
            if ($status == 200) {
                $stringBody = $response->getBody()->getContents();
                $data = json_decode($stringBody,true);
                if(Arr::get($data,'status')=='OK'){
                    return Response::returns($data);
                }
            }
        } catch (\Exception $e) {
        }
        return Response::returns([]);
    }

}
