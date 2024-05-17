<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlertUsersAreaIdTable extends Migration
{

    protected $bindModel='App\Models\User';

    /**
     * Run the migrations.
     *
     * 返回: void
     */
    public function up()
    {
        $model = new $this->bindModel();
        $prefix = $model->getConnection()->getTablePrefix();
        $connection = $model->getConnectionName()?: config('database.default');
        DB::connection($connection)->statement("ALTER TABLE `".$prefix.$model->getTable()."`
ADD COLUMN `province_id` int(0) UNSIGNED NOT NULL DEFAULT 0 COMMENT '省ID' AFTER `id`,
ADD COLUMN `city_id` int(0) UNSIGNED NOT NULL DEFAULT 0 COMMENT '市ID' AFTER `province_id`,
ADD COLUMN `area_id` int(0) UNSIGNED NOT NULL DEFAULT 0 COMMENT '区ID' AFTER `city_id`;");


    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        $model = new $this->bindModel();
        $prefix = $model->getConnection()->getTablePrefix();
        $connection = $model->getConnectionName()?: config('database.default');
        DB::connection($connection)->statement("ALTER TABLE `".$prefix.$model->getTable()."`
DROP COLUMN `province_id`,
DROP COLUMN `city_id`,
DROP COLUMN `area_id`;");
    }
}
