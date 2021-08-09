<?php

namespace App\Models;

use App\Facades\LifeData;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable,BaseModel,SoftDeletes,HasApiTokens;
    protected $itemName='用户';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uname',
        'password',
        'name',
        'email',
        'mobile_phone',
        'status',
        'description',
        'avatar',
        'province_id',
        'city_id',
        'area_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at'
        //'uname','email'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    /**
     * 字段值map
     * @var array
     */
    protected $fieldsShowMaps = [
        'status'=>[
            'Cancellation',
            'Effective',
            'Out of service'
        ]
    ];

    /**
     * 字段默认值
     * @var array
     */
    protected $fieldsDefault = [
        'uname'=>'',
        'password'=>'',
        'name'=>'',
        'email'=>'',
        'mobile_phone'=>'',
        'remember_token'=>null,
        'status'=>1,
        'description'=>null,
        'avatar'=>'',
        'province_id'=>0,
        'city_id'=>0,
        'area_id'=>0
    ];

    //字段默认值
    protected $fieldsName = [
        'uname' => 'User name',
        'password' => 'Password',
        'name' => 'Name',
        'avatar' => 'Head portrait',
        'email' => 'E-mail',
        'mobile_phone' => 'Phone number',
        //'remember_token' => '记住登录',
        'status' => 'State',
        'description' => 'Remarks',
        //'created_at' => 'Created At',
        //'updated_at' => 'Updated At',
        //'deleted_at' => 'Deleted At',
        'province_id'=>'Province ID',
        'city_id'=>'City ID',
        'area_id'=>'Zone ID',
        'id' => 'ID',
    ];

    /**
     * Password加密设置
     * @param  $value
     * @return  array
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value.'');
    }


    /**
     * 用户-后台用户
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function admin(){
        return $this->hasOne('App\Models\Admin');
    }

    /**
     * 用户操作日志
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs(){
        return $this->hasMany('App\Models\Log');
    }

    /**
     * 三方登录用户
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ousers(){
        return $this->hasMany('App\Models\Ouser');
    }

    /* 所属省份 */
    public function province(){
        return $this->belongsTo('App\Models\Area','province_id');
    }
    /* 所属市 */
    public function city(){
        return $this->belongsTo('App\Models\Area','city_id');
    }
    /* 所属区 */
    public function area(){
        return $this->belongsTo('App\Models\Area');
    }

    public function scopeIsAdmin($query){
        return LifeData::remember('_is_admin',function ()use($query){
            $user = Auth::user();
            return $user ? !!$user->admin : false;
        });
    }

    public function scopeGetOperateId($q){
        $main = Auth::user();
        return Arr::get($main,'id',0);
    }
}
