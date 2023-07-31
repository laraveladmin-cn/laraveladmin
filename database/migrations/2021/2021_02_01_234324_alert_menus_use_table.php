<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlertMenusUseTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->tinyInteger('use')->unsigned()->default(0)->comment('路由使用地方:1-api,2-web');
            $table->string('as', 255)->default('')->comment('路由别名');
            $table->string('middleware', 255)->default('')->comment('单独使用中间件');
            $table->string('item_name', 255)->default('')->comment('资源名称');
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
                'use',
                'as',
                'middleware',
                'item_name'
            ]);
        });
    }


}
