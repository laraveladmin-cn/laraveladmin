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
            $table->bigIncrements('id')->comment('ID');
            $table->unsignedInteger('chat_id')->default(0)->index()->comment('聊天室ID$select2');
            $table->unsignedTinyInteger('role')->default(0)->comment('角色:0-系统,1-用户,2-回答$radio');
            $table->string('conternt', 255)->default('')->comment('内容$textarea');
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
