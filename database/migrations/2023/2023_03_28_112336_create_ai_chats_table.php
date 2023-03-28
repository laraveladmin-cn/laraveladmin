<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAiChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ai_chats', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->string('client_id',255)->default('')->index()->comment('连接ID');
            $table->unsignedInteger('ouser_id')->default(0)->index()->comment('三方登录用户ID$select2');
            $table->unsignedInteger('user_id')->default(0)->index()->comment('用户ID$select2');
            $table->string('name', 255)->default('')->comment('聊天室名称$required');
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
        Schema::dropIfExists('ai_chats');
    }
}
