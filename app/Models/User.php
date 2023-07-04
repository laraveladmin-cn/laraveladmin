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

/**
 * App\Models\User
 *
 * @property int $id ID
 * @property string $uname 用户名@sometimes|required|alpha_dash|between:6,18|unique:users,uname
 * @property string $password 密码$password@sometimes|required|digits_between:6,18
 * @property string $name 昵称@required
 * @property string $avatar 头像@sometimes|required|url
 * @property string $email 电子邮箱@sometimes|required|email|unique:users,email
 * @property string $mobile_phone 手机号码@sometimes|required|mobile_phone|unique:users,mobile_phone
 * @property string $remember_token 记住登录
 * @property string $client_id 客户端ID
 * @property int $status 状态:0-注销,1-有效,2-停用$radio@nullable|in:0,1,2
 * @property \Illuminate\Support\Carbon|null $email_verified_at 激活时间
 * @property string|null $available_at 到期日期$date
 * @property string|null $description 备注$textarea
 * @property string $tag 身份标签
 * @property int $m_level 会员等级:0-坚韧黑铁,1-英勇黄铜,2-不屈白银,3-荣耀黄金,4-华贵铂金,5-璀璨钻石,6-超凡大师,7-傲世宗师,8-最强王者
 * @property int $old_m_level 原来等级
 * @property int $is_member 是否是会员:0-否,1-是
 * @property string|null $member_available_at 会员到期时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Admin|null $admin
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Log[] $logs
 * @property-read int|null $logs_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ouser[] $ousers
 * @property-read int|null $ousers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User commaMapValue($key)
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User getClassName()
 * @method static \Illuminate\Database\Eloquent\Builder|User getFieldsDefault($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|User getFieldsMap($key = '', $decode = false, $trans = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User getFieldsName($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|User getFillables()
 * @method static \Illuminate\Database\Eloquent\Builder|User getItemName()
 * @method static \Illuminate\Database\Eloquent\Builder|User getOperateId()
 * @method static \Illuminate\Database\Eloquent\Builder|User getTableComment()
 * @method static \Illuminate\Database\Eloquent\Builder|User getTableInfo()
 * @method static \Illuminate\Database\Eloquent\Builder|User getTableName()
 * @method static \Illuminate\Database\Eloquent\Builder|User ignoreUpdateAt()
 * @method static \Illuminate\Database\Eloquent\Builder|User insertReplaceAll($datas)
 * @method static \Illuminate\Database\Eloquent\Builder|User isAdmin()
 * @method static \Illuminate\Database\Eloquent\Builder|User mainDB()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User options(array $options = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User optionsWhere($where = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvailableAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMemberAvailableAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobilePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOldMLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
 */
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
        'client_id',
        'message_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
        'client_id'
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
        'client_id'=>'',
        'message_id'=>0
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
        //'client_id'=>'登录连接唯一标识',
        //'created_at' => 'Created At',
        //'updated_at' => 'Updated At',
        //'deleted_at' => 'Deleted At',
        'message_id'=>'已读最新消息ID',
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

    /**
     * 已读最新消息
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function message(){
        return $this->belongsTo(Message::class);
    }
}
