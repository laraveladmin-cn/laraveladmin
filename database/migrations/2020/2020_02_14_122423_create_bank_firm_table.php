<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBankFirmTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bank_firm', function(Blueprint $table)
		{
			$table->increments('id')->comment('ID');
			$table->integer('firm_id')->unsigned()->default(0)->comment('保险公司ID');
			$table->integer('bank_id')->unsigned()->default(0)->comment('银行ID');
			$table->index(['firm_id','bank_id'], 'firm_bank_index');
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="保险公司-银行"';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('bank_firm');
	}

}
