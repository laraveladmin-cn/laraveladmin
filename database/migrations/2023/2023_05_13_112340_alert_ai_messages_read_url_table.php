<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlertAiMessagesReadUrlTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ai_messages', function (Blueprint $table) {
            $table->string('read_url', 255)->default('')->comment('内容阅读音频地址');
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
                'read_url'
            ]);
        });
    }

}
