<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlertAiMessagesContentTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ai_messages', function (Blueprint $table) {
            $table->text('content', 65535)->nullable()->comment('内容$textarea')->change();
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
            $table->string('content', 255)->default('')->comment('内容$textarea')->change();
        });
    }
}
