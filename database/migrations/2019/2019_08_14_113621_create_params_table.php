<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateParamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('params', function(Blueprint $table)
		{
			$table->increments('id')->comment('ID');
			$table->integer('menu_id')->default(0)->index('api_params_menu_id_index')->comment('接口ID$select2@required|exists:menus,id');
			$table->string('name')->default('')->comment('参数名称@required');
			$table->boolean('type')->default(1)->comment('类型:1-字符串,2-数字,3-布尔值');
			$table->string('title')->default('')->comment('提示@required');
			$table->string('description')->default('')->comment('描述$textarea');
			$table->string('example')->default('')->comment('事例值');
			$table->string('validate')->default('')->comment('验证规则说明');
			$table->timestamps();
			$table->softDeletes();
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="接口参数$softDeletes,timestamps@belongsTo:memu"';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('params');
	}

}
