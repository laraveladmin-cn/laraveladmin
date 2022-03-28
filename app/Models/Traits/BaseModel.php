<?php
/**
 * 通过 PhpStorm 创建.
 * 创建人: zhangshiping
 * 日期: 16-5-20
 * 时间: 下午6:21
 */

namespace App\Models\Traits;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


trait BaseModel{

    /**
     * 统一处理日期格式
     * @param \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


    /**
     * 批量替换插入
     */
    public function scopeInsertReplaceAll($query,$datas){
        $datas = collect($datas);
        if(!$datas->count()){
            return false;
        }
        //表名
        $table = config('database.connections.'.($this->getConnectionName()?:config('database.default')).'.prefix').$this->getTable();
        //sql数据占位符
        $value = [];
        //字段名
        $field = collect(collect($datas->first())->keys())->map(function($item)use(&$value){
            $value[] = '?';
            return '`'.$item.'`';
        })->implode(',');
        $value = implode(',',$value);

        //sql拼装
        $sql = 'replace into '.$table.' ('.$field.') values ';

        $datas->chunk(500)->map(function($chunk)use($value,$sql){
            $values = [];
            $values_sql = [];
            $chunk->map(function($item) use(&$values_sql,&$values,$value){
                $values_sql[] = '('.$value.')';
                collect($item)->map(function($item1)use(&$values){
                    $values[] = $item1;
                });
            });
            $sql .= implode(',',$values_sql);
            return DB::connection($this->getConnectionName()?:config('database.default'))->insert($sql,$values);
        });
        return true;

    }

    /**
     * 多条件筛选
     * @param $query
     * @param array $options
     * @return mixed
     */
    public function scopeOptions($query,array $options=[])
    {
        //条件筛选
        collect($options['where'])->map(function($item) use(&$query){
            if(is_null($item) || $item['val']===''){
                return ;
            }
            //值处理
            if($item['exp']=='like'){
                $val = /*'%'.*/preg_replace('/([_%\'"])/','\\\$1', $item['val']).'%';
            }else if($item['exp']=='between'){
                $val = is_string($item['val']) ? explode(' - ',$item['val']):$item['val'];
            }else if(in_array($item['exp'],['in','not_in' , '&or'])){
                $val = is_string($item['val']) ? explode(',',$item['val']):$item['val'];
            }else{
                $val = $item['val'];
            }
            $exp = $item['exp']; // 表达式

            if($exp=='has'){
                if($val){
                    $query->whereHas($item['key']);
                }else{
                    $query->whereDoesntHave($item['key']);
                }
                return ;
            }elseif($exp=='or'){
                if($val!==''){
                    $query->oRwhere($item['key'],'=',$val);
                }
                return '';
            }
            if(str_contains($item['key'],'|')){ //多字段
                $query->where(function($query)use($item,$val,$exp){
                    $keys = collect(explode('|',$item['key']));
                    $keys->map(function($key)use(&$query,$val,$exp){
                        $this->relationWhere($query,$key,$exp,$val,'or');
                    });
                });
            }else{
                $this->relationWhere($query,$item['key'],$exp,$val);
            }
        });
        //排序
        isset($options['order']) AND collect($options['order'])->each(function($item,$key) use (&$query){
            $item and $query->orderBy($key,$item);
        });
        return $query;
    }


    /**
     * 关系条件筛选
     * @param $query
     * @param $key
     * @param $exp
     * @param $val
     * @param string $condition
     */
    protected function relationWhere(&$query,$key,$exp,$val,$condition='and'){
        $relation = '';
        if(str_contains($key,'.')){
            $keys = collect(explode('.',$key));
            $key = $keys->pop();
            $relation = $keys->implode('.');
        }
        if($relation){
            if($condition=='or'){
                $query->orWhereHas($relation,function($query)use($exp,$key,$val){
                    $this->jointWhere($query,$key,$exp,$val);
                });
            }else{
                $query->whereHas($relation,function($query)use($exp,$key,$val){
                    $this->jointWhere($query,$key,$exp,$val);
                });
            }
        }else{
            $this->jointWhere($query,$key,$exp,$val,$condition);
        }
    }

    /**
     * 拼接条件
     * @param $query
     * @param $key
     * @param $exp
     * @param $val
     * @param string $condition
     */
    protected function jointWhere(&$query,$key,$exp,$val,$condition='and'){
        if(is_string($key) && Str::contains($key,'`')){
            $key = DB::raw($key);
        }
        $whereMap = ['in','not_in','between'];
        $exps = [];
        if($condition=='or'){
            $exps[] = 'or';
        }
        if($exp=='null'){
            $val==1 ? $query->whereNull($key):$query->whereNotNull($key);
        }elseif(in_array($exp,$whereMap)){
            if(!is_array($val)){
                $val = explode(',',$val);
            }
            $exps[] = 'where';
            $exps[] = $exp;
            $where = Str::camel(implode('_',$exps));
            $query->$where($key,$val);
        }elseif($exp=='like'){
            $exps[] = 'where';
            $where = Str::camel(implode('_',$exps));
            $query->$where(function ($q)use($key,$exp,$val){
                $q->where($key,$exp,$val)->orWhere($key,$exp,'%'.$val); //模糊搜索命中索引
            });
        }elseif($exp=='&' && is_array($val)){
            if(!$val){
                $val = [0];
            }
            $exps[] = 'whereRaw';
            $where = Str::camel(implode('_',$exps));
            $values = [];
            $str = collect($val)->map(function ($val)use(&$values){
                $values[] = $val;
                return '& ?';
            })->implode('');
            $query->$where("{$key}{$str}",$values);
        }elseif($exp=='&or'){
            if(!$val){
                $val = [0];
            }
            $exps[] = 'whereRaw';
            $where = Str::camel(implode('_',$exps));
            $values = [];
            $str = collect($val)->map(function ($val)use($key,&$values){
                $values[] = $val;
                return "`{$key}` & ?";
            })->implode(' or ');
            $query->$where("({$str})",$values);
        }elseif($exp=='find_in_set'){
            $exps[] = 'whereRaw';
            $where = Str::camel(implode('_',$exps));
            $query->$where("FIND_IN_SET( ? ,`{$key}`)",[$val]);
        }else{
            $exps[] = 'where';
            $where = Str::camel(implode('_',$exps));
            $query->$where($key,$exp,$val);
        }
    }

    /**
     * 获取本模型数据库连接对象
     * @return mixed
     */
    public function scopeMainDB(){
        return $this->getConnection();
    }


    /**
     * 获取数据表字段信息
     * param $table
     * 返回: mixed
     */
    public function scopeGetTableInfo(){
        $table = $this->getTable();
        $connection = $this->getConnectionName() ?: config('database.default');
        $prefix = config('database.connections.'.$connection.'.prefix');
        $trueTable = $prefix.$table;

        //数据表备注信息
        $data['comment'] =  $this->getConnection()->select('SELECT TABLE_COMMENT FROM information_schema.`TABLES` WHERE TABLE_SCHEMA= :db_name AND TABLE_NAME = :tname',
            [
                'db_name'=>config('database.connections.'.$connection.'.database'),
                'tname'=>$trueTable
            ])[0]->TABLE_COMMENT;
        //数据表类型
        preg_match('/\$([A-Za-z0-9_,]{1,})/',$data['comment'],$table_types);
        $data['table_types'] = collect(explode(',',Arr::get($table_types,1)))->filter()->map(function($item){
            return Str::camel($item);
        })->toArray();
        //数据表关系
        preg_match('/\@([A-Za-z0-9_:|,]{1,})/',$data['comment'],$table_relations);
        $data['table_relations'] = collect(explode('|',Arr::get($table_relations,1)))->filter()->map(function($item){
            $item_array = explode(':',$item);
            $relation = lcfirst(Str::camel($item_array[0]));
            return [
                'name'=>in_array($relation,['hasMany','belongsToMany','hasManyThrough','morphMany']) ? Str::plural(Str::snake($item_array[1])) : Str::snake($item_array[1]),
                'relation'=>$relation,
                'model'=>Str::studly(Str::singular($item_array[1]))
            ];
        })->toArray();
        $table_comment = str_replace(Arr::get($table_types,0,''),'',$data['comment']);
        $table_comment = str_replace(Arr::get($table_relations,0,''),'',$table_comment);
        $data['table_comment'] = $table_comment;

        //字段信息
        $data['table_fields'] = collect($this->getConnection()->select('show full COLUMNS from `'.$trueTable.'`'))
            ->map(function($item){
                $comment = explode('@',$item->Comment);
                $item->validator = Arr::get($comment,'1',''); //字段验证
                $comment = explode('$',$comment[0]);
                $item->showType = (!Arr::get($comment,1) && Str::endsWith($item->Field,'_at')) ? 'time' : Arr::get($comment,'1',''); //字段显示类型
                $item->showType = in_array($item->Field,['deleted_at','left_margin','right_margin','level','remember_token']) ? 'hidden' :  $item->showType;
                $comment = explode(':',$comment[0]);
                $info = ['created_at'=>'Created At','updated_at'=>'Updated At','deleted_at'=>'Deleted At'];
                $item->info = isset($info[$item->Field]) ? $info[$item->Field]: $comment[0]; //字段说明
                $item->info =  $item->info ?: $item->Field;
                $comment = explode(',',Arr::get($comment,'1',''));
                $item->values = collect($comment)->map(function($item){
                    return explode('-',$item);
                })->pluck('1','0')->filter(function($item){
                    return $item;
                })->toArray(); //字段值
                $item->showType = (!$item->showType && $item->values) ? 'radio' : $item->showType;
                $item->showType = !$item->showType ? 'text' : $item->showType;
                return collect($item)->toArray();
            })->toArray();
        return $data;
    }

    /**
     * 获取字段显示映射信息
     * @return array
     */
    public function scopeGetFieldsMap($query,$key='',$decode=false,$trans=false){
        if(!isset($this->fieldsShowMaps)){
            $maps = [];
        }elseif($key){
            $maps = Arr::get($this->fieldsShowMaps,$key);
            if($trans){
                $maps = collect($maps)->map(function ($value)use($key){
                    if($value && is_string($value)){
                        return trans_path($value,'_shared.tables.'.$this->getTable().'.maps.'.$key);
                    }else{
                        return $value;
                    }
                })->toArray();
            }
            if($decode){
                $maps = array_flip(collect($maps)->toArray());
            }
        }else{
            $maps = $this->fieldsShowMaps;
            if($trans){
                $maps = collect($maps)->map(function ($map,$key){
                    return collect($map)->map(function ($value)use($key){
                        if($value && is_string($value)){
                            return trans_path($value,'_shared.tables.'.$this->getTable().'.maps.'.$key);
                        }else{
                            return $value;
                        }
                    })->toArray();
                })->toArray();
            }
            if($decode){
                $maps = collect($maps)->map(function ($map){
                    return array_flip($map);
                })->toArray();
            }
        }
        return collect($maps);
    }

    /**
     * 获取字段默认值
     * @return array
     */
    public function scopeGetFieldsDefault($query,$key=''){
        if(!isset($this->fieldsDefault)){
            $data = collect([]);
            if($key){
                return $data->get($key);
            }
            return $data;
        }
        $data = collect($this->fieldsDefault);
        if($key){
            return $data->get($key);
        }
        return $data;
    }

    /**
     * 获取字段默认值
     * @return array
     */
    public function scopeGetFieldsName($query,$key=''){
        if(!isset($this->fieldsName)){
            $data = collect([]);
            if($key){
                return $data->get($key,'');
            }
            return $data;
        }
        $data = collect($this->fieldsName);
        if($key){
            return $data->get($key,'');
        }
        return $data;
    }


    /**
     * 获取本模型数据库连接对象
     * @return mixed
     */
    public function scopeGetTableName($query){
        return $this->getConnection()->getTablePrefix().$this->getTable();
    }

    public function scopeGetTableComment($query){
        return isset($this->tableComment)?$this->tableComment:'';
    }

    public function scopeGetItemName(){
        return isset($this->itemName)?$this->itemName:'';
    }

    public function scopeGetClassName(){
        return __CLASS__;
    }

    public function scopeIgnoreUpdateAt($q){
        $this->timestamps = false;
    }

    public function scopeGetFillables($q){
        return $this->fillable?:[];
    }

    public function scopeCommaMapValue($q,$key){
        return collect(self::getFieldsMap($key,true))->implode(',');
    }


}
