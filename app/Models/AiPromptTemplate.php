<?php
/**
 * 提示词模板模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class AiPromptTemplate extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'ai_prompt_templates';
    //没有主键ID
    protected $itemName = '提示词模板';
    //批量赋值白名单
    protected $fillable = [
       'name',
       'content',
       'options',
        'cue_word'
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段值map
    protected $fieldsShowMaps = [];
    //字段默认值
    protected $fieldsDefault = [
        'name' => '',
        'content' => '',
        'options'=>[],
        'cue_word'=>''
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'ID',
        'name' => '模板名称',
        'content' => '可选项模板内容',
        'options' => '可选项',
        'cue_word'=>'提示词内容',
        'created_at' => '创建时间',
        'updated_at' => '修改时间',
        'deleted_at' => '删除时间'
    ];

    /**
     * 获取多选值
     * @param  $value
     * @return  array
     */
    public function getOptionsAttribute($value)
    {
        return json_decode($value,true);
    }

    /**
     * 设置多选值
     * @param  $value
     * @return  array
     */
    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = $value?json_encode($value):null;
    }

    /**
     * 组装获得提示词
     */
    public function scopeGetPrompt($q,$data){
        $cue_word = $data['cue_word']??'';
        $prompt = $data['content']??'';
        $options = $data['options']??[];
        //获取参数
        $params = [
        ];
        collect($options)->each(function($item) use (&$params){
            $params[$item['name']] = Arr::get($item['items'],$item['value'].'.value');
        });
        return ($cue_word?$cue_word."\n":'').$this->render($prompt,$params);
    }

    public function render($tmp,$data){
        collect($data)->map(function ($value,$key)use(&$tmp){
            $tmp = str_replace('{{'.$key.'}}',$value,$tmp);
        });
        return $tmp;
    }




}
