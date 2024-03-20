<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlertLogsCreatedAtIndexTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('logs', function(Blueprint $table)
		{
            $table->index('created_at');
            $table->index('user_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('logs', function (Blueprint $table) {
            $table->dropIndex('created_at');
            $table->dropIndex('user_id');
        });
	}

}
