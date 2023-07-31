<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlertAiChatsAbstractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ai_chats', function (Blueprint $table) {
            $table->text('abstract', 65535)->nullable()->comment('摘要$textarea');
            $table->integer('message_id')->unsigned()->default(0)->comment('已摘要到ID');
            $table->text('abstract_res', 65535)->nullable()->comment('摘要响应结果$textarea');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ai_chats', function (Blueprint $table) {
            $table->dropColumn([
                'abstract',
                'message_id',
                'abstract_res'
            ]);
        });
    }




}
