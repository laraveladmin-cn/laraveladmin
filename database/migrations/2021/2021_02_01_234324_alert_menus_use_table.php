<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlertMenusUseTable extends Migration
{

    protected $bindModel='App\Models\Menu';

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
ADD COLUMN `use` int(0) UNSIGNED NOT NULL DEFAULT 0 COMMENT '路由使用地方:1-api,2-web' AFTER `right_margin`,
ADD COLUMN `as` varchar(255) NOT NULL DEFAULT '' COMMENT '路由别名' AFTER `use`,
ADD COLUMN `middleware` varchar(255) NOT NULL DEFAULT '' COMMENT '单独使用中间件' AFTER `as`,
ADD COLUMN `item_name` varchar(255) NOT NULL DEFAULT '' COMMENT '资源名称' AFTER `middleware`;");
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
DROP COLUMN `use`,
DROP COLUMN `as`,
DROP COLUMN `middleware`,
DROP COLUMN `item_name`;");
    }
}
