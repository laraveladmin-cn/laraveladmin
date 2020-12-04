<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOusersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ousers', function(Blueprint $table)
		{
			$table->increments('id')->comment('ID');
			$table->integer('user_id')->unsigned()->default(0)->index('ouser_user_id_index')->comment('用户ID');
			$table->boolean('type')->default(0)->comment('类型:1-qq,2-weixin,3-weibo$select');
			$table->string('open_id')->default('')->comment('用户唯一标识');
			$table->text('data', 65535)->comment('用户信息');
			$table->timestamps();
			$table->softDeletes()->comment('删除时间');
			$table->index(['type','open_id']);
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="三方用户$softDeletes,timestamps@belongsTo:user"';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ousers');
	}

}
