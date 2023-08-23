<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->unsignedTinyInteger('type')->default(0)->comment('类型:1-安卓,2-ios$icheckRadio@sometimes|in:0,1');
            $table->string('name', 255)->default('')->comment('名称@required');
            $table->string('description', 255)->default('')->comment('描述$textarea@required');
            $table->string('url', 255)->default('')->comment('应用程序下载地址$qiniuUpload@required|url');
            $table->string('version', 255)->default('')->comment('版本号@required');
            $table->unsignedTinyInteger('forced_update')->default(0)->comment('是否强制更新:0-否,1-是$switch@sometimes|in:0,1');
            $table->unsignedInteger('operate_id')->default(0)->index()->comment('操作人$select2');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apps');
    }
}
