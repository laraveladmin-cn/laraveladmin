<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFirmsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firms', function(Blueprint $table)
        {
            $table->increments('id')->comment('ID');
            $table->string('name')->default('')->comment('名称@required');
            $table->string('full_name')->default('')->comment('全称@required');
            $table->boolean('type')->default(1)->comment('类型:1-寿险,2-财险$checkbox');
            $table->string('url')->default('')->comment('公司网站');
            $table->string('logo')->default('')->comment('品牌LOGO$img@sometimes|image');
            $table->boolean('uname_rule')->default(0)->comment('代理账号规则:0-无规则,1-代理人工号');
            $table->boolean('password_rule')->default(0)->comment('代理账号密码:0-无规则,1-身份证后6位,2-固定值');
            $table->string('default_password')->default('')->comment('固定密码');
            $table->boolean('account_day_by_sign_at')->default(0)->comment('签单日期计算业务月份');
            $table->boolean('account_day_by_end_at')->default(0)->comment('回执录入日期计算业务月份');
            $table->boolean('url_rule')->default(0)->comment('链接规则:0-无规则,1-账号模板规则');
            $table->string('url_rule_tpl')->default('')->comment('链接规则模板');
            $table->text('description', 65535)->nullable()->comment('描述$textarea');
            $table->integer('order')->unsigned()->default(0)->comment('排序');
            $table->boolean('account_at_merge')->default(0)->comment('合并预计结算月份开关:0-关,1-开$switch');
            $table->string('service_api', 50)->default('')->comment('对接服务:guobao-国宝');
            $table->text('insure_notify', 65535)->nullable()->comment('投保须知');
            $table->timestamps();
            $table->softDeletes()->comment('删除时间');
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="保险公司$softDeletes,timestamps"';

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firms');
    }

}
