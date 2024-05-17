<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBanksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('banks', function(Blueprint $table)
		{
			$table->smallInteger('id', true)->unsigned()->comment('ID');
			$table->string('name', 50)->default('')->comment('名称@required');
			$table->string('full_name', 50)->default('')->comment('全称@required');
			$table->smallInteger('order')->unsigned()->default(0)->comment('排序@sometimes|integer');
			$table->timestamps();
			$table->softDeletes();
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="银行$softDeletes,timestamps"';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('banks');
	}

}
