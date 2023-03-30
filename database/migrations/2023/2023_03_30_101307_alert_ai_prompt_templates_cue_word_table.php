<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlertAiPromptTemplatesCueWordTable extends Migration
{
    protected $bindModel='App\Models\AiPromptTemplate';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $model = new $this->bindModel();
        $prefix = $model->getConnection()->getTablePrefix();
        $connection = $model->getConnectionName()?: config('database.default');
        DB::connection($connection)->statement("ALTER TABLE `".$prefix.$model->getTable()."`
ADD COLUMN `cue_word` varchar(255) NULL COMMENT '提示词内容' AFTER `name`,
MODIFY COLUMN `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '' COMMENT '可选项模板内容\$textarea@required' AFTER `name`;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $model = new $this->bindModel();
        $prefix = $model->getConnection()->getTablePrefix();
        $connection = $model->getConnectionName()?: config('database.default');
        DB::connection($connection)->statement("ALTER TABLE `".$prefix.$model->getTable()."`
DROP COLUMN `cue_word`;");
    }
}
