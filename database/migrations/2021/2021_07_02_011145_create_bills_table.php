<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->unsignedInteger('member_id')->default(0)->comment('会员ID');
            $table->unsignedInteger('donation_id')->default(0)->comment('捐赠ID');
            $table->decimal('amount', 10)->unsigned()->default(0.00)->comment('金额');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态:0-未提现,1-已提现');
            $table->timestamps()->comment('修改时间');
            $table->softDeletes()->comment('删除时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
