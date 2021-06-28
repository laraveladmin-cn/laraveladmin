<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('name', 50)->default('')->comment('名称@required|min:2|max:8');
            $table->string('icon', 30)->default('')->comment('图标$icon@nullable|alpha_dash');
            $table->string('color', 10)->default('')->comment('颜色$color@required');
            $table->string('description')->default('')->comment('描述$textarea@required|min:20|max:100');
            $table->timestamps();
            $table->softDeletes()->comment('删除时间');
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="新功能$softDeletes,timestamps"';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('features');
    }
}
