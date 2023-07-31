<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlertAiPromptTemplatesIconTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ai_prompt_templates', function (Blueprint $table) {
            $table->string('icon', 255)->default('')->comment('图标$icon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ai_prompt_templates', function (Blueprint $table) {
            $table->dropColumn([
                'icon'
            ]);
        });
    }
}
