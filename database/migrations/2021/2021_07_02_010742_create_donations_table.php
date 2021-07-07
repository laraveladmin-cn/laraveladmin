<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->unsignedInteger('member_id')->default(0)->comment('会员ID$select2@required|integer|exists:members,id');
            $table->unsignedInteger('sponsor_id')->default(0)->comment('赞助商ID$select2@required|integer|exists:sponsors,id');
            $table->unsignedInteger('from')->default(0)->comment('来源:1-微信,2-支付宝,3-转账$radio');
            $table->decimal('amount', 10)->unsigned()->default(0.00)->comment('捐赠金额$num@sometimes|required|min:0.02');
            $table->timestamps();//->comment('修改时间');
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
        Schema::dropIfExists('donations');
    }
}
