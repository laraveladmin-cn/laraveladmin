<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('logs', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned()->comment('ID');
			$table->integer('menu_id')->unsigned()->default(0)->index()->comment('菜单ID');
			$table->integer('user_id')->unsigned()->default(0)->index()->comment('用户ID');
			$table->string('location', 150)->default('')->comment('位置');
			$table->string('ip', 100)->default('')->comment('IP地址');
			$table->text('parameters', 65535)->nullable()->comment('请求参数');
			$table->longtext('return', 65535)->nullable()->comment('返回数据');
			$table->timestamps();
			$table->softDeletes();
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="操作日志$softDeletes,timestamps"';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('logs');
	}

}
