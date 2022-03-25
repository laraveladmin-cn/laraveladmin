<?php
/**
 * 通过 PhpStorm 创建.
 * 创建人: zhangshiping
 * 日期: 16-5-5
 * 时间: 上午10:26
 *
 * 自定义辅助函数
 */
use \Illuminate\Support\Arr;
use \Illuminate\Support\Facades\Lang;
use \Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

/**
 * 前端弹窗参数返回
 * @param array $data
 * @param int $status
 * @return array
 */
function alert($data = [], $status = 200)
{
    //默认值
    $defult = [
        200 => [
            'showClose' => true, //显示关闭按钮
            'title' => trans('The operation successful!'), //消息内容
            'message' => '', //消息内容
            'type' => 'success', //消息类型
            'position' => 'top',
            'iconClass' => 'fa-check', //图标
            'customClass' => '', //自定义样式
            'duration' => 3000, //显示时间毫秒
            'show' => true //是否自动弹出
        ],
        'other' => [
            'showClose' => true, //显示关闭按钮
            'title' => trans('The operation failure!'), //消息内容
            'message' => '', //消息内容
            'type' => 'danger', //消息类型
            'position' => 'top',
            'iconClass' => 'fa-close', //图标
            'customClass' => '', //自定义样式
            'duration' => 3000, //显示时间毫秒
            'show' => true //是否自动弹出
        ]
    ];
    return collect(isset($defult[$status]) ? $defult[$status] : $defult['other'])->merge($data)->toArray();
}

/**
 * 关系数据处理
 * @param $data
 * @param array $result
 * @return array
 */
function getRelationData($data, &$result = [])
{
    if (!is_array($data)) {
        return $data;
    } else {
        collect($data)->map(function ($item, $k) use (&$result) {
            if (str_contains($k, '.')) {
                $keys = explode('.', $k);
                $first = $keys[0];
                unset($keys[0]);
                $result[$first][implode('.', $keys)] = $item;
            } else {
                $result[$k] = $item;
            }
        });
        foreach ($result as $key => $value) {
            if (is_array($value)) {
                $result[$key] = getRelationData($value);
            }
        }
    }
    return $result;
}

/**
 * 转换成一级key
 * @param $data
 * @param array $result
 * @param string $k
 * @return array
 */
function toLateralKey($data, &$result = [], $k = '')
{
    if (!is_array($data)) {
        return $data;
    } else {
        foreach ($data as $key => $item) {
            if (!is_array($item)) {
                $result[] = $k ? $k . '.' . $item : $item;
            } else {
                toLateralKey($item, $result, $k ? $k . '.' . $key : $key);
            }
        }
        if ($k && !count($data)) {
            $result[] = $k;
        }
    }
    return $result;
}

/**
 * 二进制数转多选值
 * @param $value
 * @param array $options
 */
function multiple($value, array $options)
{
    $result = [];
    $i = 0;
    foreach ($options as $option) {
        $val = pow(2, $i);
        if ($val & $value) {
            $result[] = $val;
        }
        $i++;
    }
    return $result;
}

/**
 * 多选值转二进制数
 * @param array $options
 * @return int
 */
function multipleToNum($options)
{
    if (!is_array($options)) {
        return $options;
    }
    $num = 0;
    foreach ($options as $option) {
        $num = $num | $option;
    }
    return $num;
}


/**
 * 关系可选项
 * @param $row
 * @param $key
 * @return array
 */
function mapOption($row, $key, $primary_key = 'id')
{
    $relation_key = str_replace('_id', '', $key);
    return ($row[$primary_key] && Arr::get($row, $relation_key)) ? [Arr::get($row, $relation_key)] : [];
}



function checkDateFormat($date)
{
    //匹配日期格式
    if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts))
    {
        //检测是否为日期
        if(checkdate($parts[2],$parts[3],$parts[1]))
            return true;
        else
            return false;
    }
    else
        return false;
}

function timeFormat($time){
    $day = floor($time/86400);
    $day_str = $day>0 ? $day.'天 ':'';
    return $day_str.date('H:i:s',$time%86400);
}

function formatToTime($str){
    $res = explode('天',str_replace('　','',str_replace(' ','',$str)));
    if(count($res)>1){
        $day = intval($res[0]);
        $hour_str = $res[1];
    }else{
        $clock = explode(':',$res[0]);
        $hour_count = Arr::get($clock,0);
        $day = floor($hour_count/24);
        $clock[0] = $hour_count%24;
        $hour_str = implode(':',$clock);
    }
    return $day*3600*24+strtotime('1970-01-01 '.$hour_str);

}

function renderer($tmp,$data){
    collect($data)->map(function ($value,$key)use(&$tmp){
        $tmp = str_replace('{$'.$key.'}',$value,$tmp);
    });
    return $tmp;
}

//获取当前时间毫秒
function msectime()
{
    list($msec, $sec) = explode(' ', microtime());
    $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    return $msectime;
}

/**
 * 可能跳转重定向页面
 * ajax,jsonp,script等请求不予跳转
 *
 * 参数 null $to
 * 参数 int $status
 * 返回: \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
 */
function orRedirect($to = null, $status = 200){
    return Response::returns([
        'title'=>Lang::get('status.status302'),
        'content'=>Lang::get('status.redirectTo').$to,
        'redirect' => $to
    ],$status);
}

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 */
function listToTree($list, $pk='id', $pid = 'parent_id', $child = 'children', $root = 0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

function treeToList($datas,$ckey = 'children',&$result = []){
    if(!is_array($datas)){
        return $datas;
    }else{
        foreach($datas as $data){
            if(!isset($data[$ckey])){
                $result[] = $data;
            }else{
                $chileds = $data[$ckey];
                unset($data[$ckey]);
                $result[] = $data;
                treeToList($chileds,$ckey,$result);
            }
        }
    }
    return $result;
}

function generateTree2($rows, $id='id', $pid='parent_id'){
    $items = array();
    foreach ($rows as $row) $items[$row[$id]] = $row;
    foreach ($items as $item) $items[$item[$pid]]['son'][$item[$id]] = &$items[$item[$id]];
    return isset($items[0]['son']) ? $items[0]['son'] : array();
}


function getRoutePrefix($web_api_model='api'){
    $web_api_model = $web_api_model=='web'?'web':'api';
    $route_prefix = config('laravel_admin.'.$web_api_model.'_route_prefix','');
    return $route_prefix?'/'.$route_prefix:'';
}

if (! function_exists('menv')) {
    /**
     * Gets the value of an environment variable by getenv() or $_ENV.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function menv($key, $default = null)
    {
        $value = env($key);
        if(!is_null($value)){
            return $value;
        }elseif (isset($_ENV[$key])) {
            $value = $_ENV[$key];
        } elseif (isset($_SERVER[$key])) {
            $value = $_SERVER[$key];
        }
        return is_null($value) ? value($default) : $value;
    }
}
if (! function_exists('trans_path')) {
    /**
     * Translate the given message.
     *
     * @param  string|null  $key
     * @param  array  $replace
     * @param  string|null  $locale
     * @return \Illuminate\Contracts\Translation\Translator|string|array|null
     */
    function trans_path($key = null,$path='', $replace = [], $locale = null)
    {
        $prefix = '';
        if($path && !is_null($key)){
            $prefix = $path.'.';
            $key = $prefix.$key;
        }
        $res = trans($key,$replace,$locale);
        if(is_string($res) && $prefix && !is_null($key) && \Illuminate\Support\Str::startsWith($res,$prefix)){
            return \Illuminate\Support\Str::replaceFirst($prefix,'',$res);
        }
        return $res;
    }
}

if (! function_exists('front_trans_conversion')) {
    /**
     * Translate the given message.
     *
     * @param  string|null  $key
     * @param  array  $replace
     * @param  string|null  $locale
     * @return \Illuminate\Contracts\Translation\Translator|string|array|null
     */
    function front_trans_conversion(&$data)
    {
        if(is_array($data)){
            foreach ($data as $key=>&$value){
                if(is_array($value)){
                    front_trans_conversion($value);
                }else{
                    $value = str_replace('}','',str_replace('{',':',$value));
                }
            }
        }
        return $data;
    }
}

if (! function_exists('excelDate')) {
    /***
     * excel导入的时间格式处理
     * @param $date
     * @return mixed|string|null
     */
    function excelDate($date){
        $date = trim($date);
        if(!$date){
            return null;
        }elseif (gettype($date)=='object'){ //时间对象
            $date = $date->toDateString();
        }elseif (is_numeric($date)){
            if(strlen($date)==6 && checkdate(substr($date,0,4),substr($date,4,2),'01')){
                $date = substr($date,0,4).'-'.substr($date,4,2);
            }else{
                $date = gmdate('Y-m-d',($date - 25569) * 3600 * 24);//格式化时间,不是用date哦, 时区相差8小时的
            }
        }elseif(str_contains($date,'.')){
            $date = str_replace('.','-',$date);
        }elseif(str_contains($date,'/')){
            $date = str_replace('/','-',$date);
        }elseif(!str_contains($date,'-') && strlen($date)==8){
            $date = substr($date,0,4).'-'.substr($date,4,2).'-'.substr($date,6,2);
        }
        if(count(explode('-',$date))<3){
            $date = $date.'-01';
        }
        if($date){
            $date_array = explode('-',preg_replace("/ [0-9]{2}:[0-9]{2}:[0-9]{2}/",'',$date));
            if(!strtotime($date) || !checkdate(Arr::get($date_array,1),Arr::get($date_array,2),Arr::get($date_array,0))){ //错误时间格式
                $date = null;
            }
        }
        if($date){
            $date = collect(explode('-',$date))->map(function ($value){
                if(strlen($value)==1){
                    return '0'.$value;
                }
                return $value;
            })->implode('-');
        }
        return $date;
    }
}



