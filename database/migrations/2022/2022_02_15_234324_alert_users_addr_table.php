<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlertUsersAddrTable extends Migration
{

    protected $bindModel='App\Models\User';

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
ADD COLUMN `addr` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址' AFTER `description`,
ADD COLUMN `lng` decimal(10, 6) NULL DEFAULT NULL COMMENT '坐标经度' AFTER `addr`,
ADD COLUMN `lat` decimal(10, 6) NULL DEFAULT NULL COMMENT '坐标纬度' AFTER `lng`;");
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
DROP COLUMN `addr`,
DROP COLUMN `lng`,
DROP COLUMN `lat`;");
    }
}
