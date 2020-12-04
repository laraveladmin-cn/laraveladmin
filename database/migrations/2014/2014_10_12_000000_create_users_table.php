<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table)
        {
            $table->increments('id')->comment('ID');
            $table->string('uname', 20)->default('')->index()->comment('用户名@sometimes|required|alpha_dash|between:6,18|unique:users,uname');
            $table->string('password', 100)->default('')->comment('密码$password@sometimes|required|digits_between:6,18');
            $table->string('name', 50)->default('')->index('name_index')->comment('昵称@required');
            $table->string('avatar')->default('')->comment('头像@sometimes|required|url');
            $table->string('email', 100)->default('')->index()->comment('电子邮箱@sometimes|required|email|unique:users,email');
            $table->string('mobile_phone', 11)->default('')->index()->comment('手机号码@sometimes|required|mobile_phone|unique:users,mobile_phone');
            $table->string('remember_token', 100)->default('')->comment('记住登录');
            $table->boolean('status')->default(2)->comment('状态:0-注销,1-有效,2-停用$radio@nullable|in:0,1,2');
            $table->timestamp('email_verified_at')->nullable()->comment('激活时间');
            $table->text('description', 65535)->nullable()->comment('备注$textarea');
            $table->timestamps();
            $table->softDeletes();
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="用户$softDeletes,timestamps"';
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }

}
