<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function(Blueprint $table)
		{
			$table->increments('id')->comment('ID');
			$table->integer('tmp_id')->unsigned()->default(0)->comment('模板ID');
			$table->string('name')->default('')->comment('名称@required');
			$table->boolean('is_tmp')->default(0)->comment('设置模板:0-否,1-是');
			$table->text('description', 65535)->nullable()->comment('描述$textarea');
			$table->integer('parent_id')->default(0)->index()->comment('父级ID@sometimes|required|exists:roles,id');
			$table->smallInteger('level')->default(0)->comment('层级');
			$table->integer('left_margin')->default(0)->index()->comment('左边界');
			$table->integer('right_margin')->default(0)->index()->comment('右边界');
			$table->timestamps();
			$table->softDeletes();
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="角色$softDeletes,timestamps"';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('roles');
	}

}
