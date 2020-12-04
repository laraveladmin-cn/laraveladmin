<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenuRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menu_role', function(Blueprint $table)
		{
			$table->integer('role_id')->index()->comment('角色ID');
			$table->integer('menu_id')->index()->comment('菜单ID');
			$table->primary(['role_id','menu_id']);
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="菜单-角色"';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('menu_role');
	}

}
