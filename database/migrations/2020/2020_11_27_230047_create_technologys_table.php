<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnologysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technologys', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('name', 60)->default('')->comment('名称@required|min:2|max:8');
            $table->string('url')->default('')->comment('链接地址$url@nullable|url');
            $table->string('logo')->default('')->comment('LOGO图片$upload@required|url');
            $table->string('description')->default('')->comment('描述$textarea@required|min:20|max:150');
            $table->timestamps();
            $table->softDeletes()->comment('删除时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technologys');
    }
}
