<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_role', function(Blueprint $table)
		{
			$table->integer('admin_id')->index()->comment('用户ID');
			$table->integer('role_id')->index()->comment('角色ID');
			$table->primary(['admin_id','role_id']);
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="后台用户-角色"';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('admin_role');
	}

}
