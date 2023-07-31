<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlertUsersMessageIdTable extends Migration
{

    protected $bindModel = 'App\Models\User';
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
        DB::connection($connection)->statement("ALTER TABLE  `".$prefix.$model->getTable()."`
ADD COLUMN `message_id` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '已读最新消息ID\$select2' AFTER `description`,
ADD INDEX `message_id_index`(`message_id`);");

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
        $connection = $model->getConnectionName() ?: config('database.default');
        DB::connection($connection)->statement("ALTER TABLE `" . $prefix . $model->getTable() . "`
DROP COLUMN `message_id`;");
    }
}
