<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlertMenusGroupTable extends Migration
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
ADD COLUMN `resource_id` int(0) NOT NULL DEFAULT 0 COMMENT '所属资源' AFTER `status`,
ADD COLUMN `group` varchar(100) NOT NULL DEFAULT '' COMMENT '后台路由所属组' AFTER `resource_id`,
ADD COLUMN `action` varchar(255) NOT NULL DEFAULT '' COMMENT '绑定控制器方法' AFTER `group`,
ADD COLUMN `env` varchar(100) NOT NULL DEFAULT '' COMMENT '使用环境' AFTER `action`,
ADD COLUMN `plug_in_key` varchar(255) NOT NULL DEFAULT '' COMMENT '插件菜单唯一标识' AFTER `env`;");
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
DROP COLUMN `resource_id`,
DROP COLUMN `group`,
DROP COLUMN `action`,
DROP COLUMN `env`,
DROP COLUMN `plug_in_key`;");
    }
}
