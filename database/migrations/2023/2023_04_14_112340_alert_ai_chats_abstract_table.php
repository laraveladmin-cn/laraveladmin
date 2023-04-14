<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlertAiChatsAbstractTable extends Migration
{

    protected $bindModel='App\Models\AiChat';

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
ADD COLUMN `abstract` text NULL COMMENT '摘要\$textarea' AFTER `name`,
ADD COLUMN `message_id` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '已摘要到ID' AFTER `abstract`,
ADD COLUMN `abstract_res` text NULL COMMENT '摘要响应结果' AFTER `message_id`;");
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
DROP COLUMN `abstract`,
DROP COLUMN `message_id`,
DROP COLUMN `abstract_res`;");
    }
}
