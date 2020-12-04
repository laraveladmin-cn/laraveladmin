<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConfigsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('configs', function(Blueprint $table)
		{
			$table->increments('id')->comment('ID');
			$table->string('name')->default('')->comment('名称');
			$table->string('description')->default('')->comment('描述$textarea');
			$table->string('key', 100)->default('')->index()->comment('键');
			$table->text('value', 65535)->comment('值');
			$table->boolean('type')->default(1)->comment('类型:1-字符串,2-json,3-数字');
			$table->boolean('itype')->default(1)->comment('输入类型:1-input,2-textarea,3-markdown');
            $table->text('options', 65535)->nullable()->comment('组件属性');
			$table->timestamps();
			$table->softDeletes()->comment('删除时间');
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="配置$softDeletes,timestamps"';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('configs');
	}

}
