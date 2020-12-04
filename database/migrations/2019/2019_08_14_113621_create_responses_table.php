<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResponsesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('responses', function(Blueprint $table)
		{
			$table->increments('id')->comment('ID');
			$table->integer('menu_id')->default(0)->index('api_responses_menu_id_index')->comment('接口ID@required|exists:menus,id');
			$table->string('name')->default('')->comment('结果字段@required|alpha_dash');
			$table->string('description')->default('')->comment('描述$textarea');
			$table->timestamps();
			$table->softDeletes();
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="接口响应$softDeletes,timestamps@belongsTo:memu"';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('responses');
	}

}
