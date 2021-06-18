<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateYearsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('years', function(Blueprint $table)
		{
			$table->increments('id')->comment('ID');
			$table->string('name')->default('')->comment('名称@required');
			$table->integer('value')->unsigned()->default(0)->comment('值@required|integer');
			$table->text('description', 65535)->nullable()->comment('描述$textarea');
			$table->timestamps();
			$table->softDeletes()->comment('删除时间');
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="年期$softDeletes,timestamps"';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('years');
	}

}
