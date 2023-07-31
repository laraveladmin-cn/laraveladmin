<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlertAiPromptTemplatesCueWordTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ai_prompt_templates', function (Blueprint $table) {
            $table->string('cue_word', 255)->default('')->comment('提示词内容');
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
                'cue_word'
            ]);
        });
    }


}
