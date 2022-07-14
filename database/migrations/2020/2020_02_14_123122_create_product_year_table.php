<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductYearTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_year', function(Blueprint $table)
		{
			$table->increments('id')->comment('ID');
			$table->integer('year_id')->unsigned()->default(0)->index()->comment('年期ID');
			$table->integer('product_id')->unsigned()->default(0)->index()->comment('产品ID');
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="险种年期"';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('product_year');
	}

}
