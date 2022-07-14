<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePclassifysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pclassifys', function(Blueprint $table)
		{
			$table->increments('id')->comment('ID');
			$table->string('name', 60)->default('')->comment('名称@required');
			$table->text('description', 65535)->nullable()->comment('备注$textarea');
			$table->integer('parent_id')->default(0)->index('classifys_parent_id_index')->comment('父级ID$parent@sometimes|required|exists:classifys,id');
			$table->smallInteger('level')->default(0)->comment('层级');
			$table->integer('left_margin')->default(0)->index('classifys_left_margin_index')->comment('左边界');
			$table->integer('right_margin')->default(0)->index('classifys_right_margin_index')->comment('右边界');
			$table->timestamps();
			$table->softDeletes();
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="险种分组$softDeletes,timestamps"';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('pclassifys');
	}

}
