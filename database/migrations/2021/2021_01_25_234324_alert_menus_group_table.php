<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlertMenusGroupTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->integer('resource_id')->default(0)->comment('所属资源');
            $table->string('group', 100)->default('')->comment('后台路由所属组');
            $table->string('action', 255)->default('')->comment('绑定控制器方法');
            $table->string('env', 100)->default('')->comment('使用环境');
            $table->string('plug_in_key', 100)->default('')->comment('插件菜单唯一标识');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn([
                'resource_id',
                'group',
                'action',
                'env',
                'plug_in_key'
            ]);
        });
    }
}
