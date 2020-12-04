<?php
/**
 * 数据结构转换
 */

namespace App\Services;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class FormatterService
{

    /**
     * 数据值转码
     */
    public function encode($parms,$maps=[])
    {
        return $this->realValues($parms, $maps);
    }

    /**
     * 数据值解码
     */
    public function decode( $parms,$maps=[])
    {
        //将键值对反向
        return $this->realValues($parms, $maps);
    }

    protected function realValues($parms, $maps = [], $prefix = '')
    {
        foreach ($parms as $key => &$parm) {
            if (is_numeric($key)) {
                $key1 = $prefix;
            } else {
                $key1 = $prefix ? $prefix . '.' . $key : $key;
            }
            if (!is_array($parm)) {
                $map = Arr::get($maps, $key1);
                if ($map && $parm !== null) {
                    $parm = Arr::get($map, $parm);
                    $parm = is_null($parm) ? Arr::get($map, '@default'):$parm;
                }
            } else {
                $parm = $this->realValues($parm, $maps, $key1);
            }
        }
        return $parms;
    }

    /**
     * 数组键值互换
     * @param $arrs
     */
    protected function arrayFlip($arrs)
    {
        $res = [];
        foreach ($arrs as $key => $arr) {
            if (is_array($arr)) {
                $res[$key] = $this->arrayFlip($arr);
            } else {
                !isset($res[$arr]) AND $res[$arr] = $key;
            }
        }
        return $res;
    }

    /**
     * 查询模板中的循环数据源KEY
     * @param $tmp
     * @return bool|mixed
     */
    protected function find($tmp)
    {
        foreach ($tmp as $value) {
            if (!is_array($value)) {
                if (str_contains($value, '$index')) {
                    return $value;
                }
            } else {
                $res = $this->find($value);
                if ($res) {
                    return $res;
                }
            }
        }
        return false;
    }

    /**
     * 模板替换
     * @param $tmp
     * @param string $str
     */
    protected function replace($tmp, $str = '')
    {
        foreach ($tmp as &$value) {
            if (!is_array($value)) {
                if (str_contains($value, $str)) {
                    $value = str_replace($str, '', $value);
                } else {
                    $value = str_contains($value, '$global') ? $value : '$global.' . $value;
                }
            } else {
                $value = $this->replace($value, $str);
            }
        }
        return $tmp;
    }

    /**
     * 数据渲染
     * @param $tmp
     * @param $data
     * @return array
     */
    public function render($tmp, &$data, &$global)
    {
        if (key($tmp) === 0 && is_array($tmp) && is_array($tmp[0]) && $tmp[0]) {
            $value_map = $this->find($tmp); //待修改,获取第一个含有$index的值
            $value_map_exp = explode('$index.', $value_map);
            $value_map_start = $value_map_exp[0];
            $has = Str::endsWith($value_map_start, '.');
            $value_map_start = $has ? substr($value_map_start, 0, strlen($value_map_start) - 1) : $value_map_start;
            $data1 = Arr::get($data, $value_map_start ?: null); //判断数据是否为二维数据集合
            $res = [];
            if ($data1 && is_array($data1) && key($data1) === 0 && is_array($data1[0]) && $data1[0]) { //循环数据
                $replace_str = $has ? $value_map_start . '.$index.' : $value_map_start . '$index.';
                $tmp = $this->replace($tmp[0], $replace_str);
                $i = 0;
                $count = count($data1);
                foreach ($data1 as $row) {
                    $row['$i'] = $i;
                    $i++;
                    $row['$n'] = $i;
                    $row['$global'] = $global;
                    $row['$count'] = $count;
                    $res[] = $this->render($tmp, $row, $global);
                }
            } elseif (!str_contains($value_map, '$index')) { //直接取值
                foreach ($tmp as $key => &$item) {
                    if (is_array($item)) {
                        $item = $this->render($item, $data, $global);
                    } else {
                        $items = explode('$def:', $item);
                        $default = Arr::get($items, 1, null);
                        $items1 = explode(':', Arr::get($items, 0, ''));
                        $item = Arr::get($items1, 0);
                        $type = Arr::get($items1, 1, '');
                        if ($item == '$i') {
                            $item = Arr::get($data, $item, 0);
                        } elseif ($item == '$n') {
                            $item = Arr::get($data, $item, 1);
                        } elseif (str_contains($item, '$count')) {
                            $default_array = Arr::get($data, str_replace(['.$count', '$count'], '', $item) ?: null, []);
                            $default = is_array($default_array) ? count($default_array) : 0;
                            $item = Arr::get($data, $item, $default);
                        } else {
                            $item = Arr::get($data, $item, $default);
                        }
                        if ($type == 'string') {
                            $item = is_array($item) ? implode(',', $item) : $item . '';
                        } elseif ($type == 'number') {
                            $item = $item - 0;
                        } elseif ($type == 'div') {
                            if (!empty($item)) {
                                $item = bcdiv($item, str_pad('1', Arr::get($items1, 2, 0) + 1, '0'), 2);
                            }
                        }
                    }
                };
                return $tmp;
            }
            return $res;
        } else {
            $arrs = [];
            foreach ($tmp as $key => &$item) {  //循环数据处理
                if (is_array($item)) {
                    if (isset($item['@arr'])) {
                        $item = $this->render([$item], $data, $global);
                        $arrs[] = $key;
                    } else {
                        $item = $this->render($item, $data, $global);
                    }
                } else {
                    $items = explode('$def:', $item);
                    $default = Arr::get($items, 1, null);
                    $items1 = explode(':', Arr::get($items, 0, ''));
                    $item = Arr::get($items1, 0);
                    $type = Arr::get($items1, 1, '');
                    if ($item == '$i') {
                        $item = Arr::get($data, $item, 0);
                    } elseif ($item == '$n') {
                        $item = Arr::get($data, $item, 1);
                    } elseif (str_contains($item, '$count')) {
                        $default_array = Arr::get($data, str_replace(['.$count', '$count'], '', $item) ?: null, []);
                        $default = is_array($default_array) ? count($default_array) : 0;
                        $item = Arr::get($data, $item, $default);
                    } else {
                        $item = Arr::get($data, $item, $default);
                    }
                    if ($type == 'string') {
                        $item = is_array($item) ? implode(',', $item) : $item . '';
                    } elseif ($type == 'number') {
                        $item = $item - 0;
                    } elseif ($type == 'div') {
                        if (!empty($item)) {
                            $item = bcdiv($item, str_pad('1', Arr::get($items1, 2, 0) + 1, '0'), 2);
                        }
                    }
                }
            };
            if ($arrs) { //去除多级数组
                foreach ($arrs as $arr) {
                    $item = $tmp[$arr];
                    unset($tmp[$arr]);
                    foreach ($item as $i) {
                        unset($i['@arr']);
                        $tmp[] = $i;
                    }
                }
            }
            return $tmp;
        }
    }

}
