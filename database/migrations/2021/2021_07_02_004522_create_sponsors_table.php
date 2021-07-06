<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('name', 100)->nullable()->comment('赞助商@sometimes|required|alpha_dash|between:2,100');
            $table->string('url')->nullable()->comment('链接$url@sometimes|required|active_url');
            $table->string('logo')->nullable()->comment('LOGO图标$upload@sometimes|required|active_url');
            $table->timestamps()->comment('修改时间');
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
        Schema::dropIfExists('sponsors');
    }
}
