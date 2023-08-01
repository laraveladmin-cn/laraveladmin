<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlertUsersMessageIdTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ai_messages', function (Blueprint $table) {
            $table->integer('message_id')->unsigned()->default(0)->index()->comment('已读最新消息ID$select2');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ai_messages', function (Blueprint $table) {
            $table->dropColumn([
                'message_id'
            ]);
        });
    }
}
