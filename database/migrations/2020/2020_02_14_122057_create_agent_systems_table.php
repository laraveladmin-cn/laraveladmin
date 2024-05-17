<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAgentSystemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agent_systems', function(Blueprint $table)
		{
			$table->increments('id')->comment('ID');
			$table->string('name')->default('')->comment('名称@required');
			$table->string('full_name')->default('')->comment('全称@required');
			$table->string('url')->default('')->comment('网站地址');
			$table->string('user_name', 100)->default('')->comment('用户名');
			$table->string('password', 100)->default('')->comment('密码');
			$table->string('ip', 100)->default('')->comment('绑定IP');
			$table->string('mac')->default('')->comment('服务器唯一标识');
			$table->timestamps();
			$table->softDeletes()->comment('删除时间');
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="经代系统$softDeletes,timestamps"';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('agent_systems');
	}

}
