<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->unsignedInteger('user_id')->default(0)->index('user_id_index')->comment('用户ID$select2@nullable|exists:users,id');
            $table->unsignedTinyInteger('type')->default(1)->comment('类型:0-提醒,1-消息,2-重要$icheckRadio@required|in:0,1,2');
            $table->string('title', 255)->default('')->comment('标题@required');
            $table->string('content', 255)->default('')->comment('内容$markdown');
            $table->unsignedInteger('operate_id')->default(0)->index()->comment('操作者');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
