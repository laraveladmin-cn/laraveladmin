<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id')->comment('区域ID');
            $table->string('name')->default('')->comment('名称@required');
            $table->unsignedInteger('parent_id')->default(0)->index()->comment('父ID@sometimes|required|exists:areas,id');
            $table->smallInteger('level')->default(0)->comment('层级');
            $table->integer('left_margin')->default(0)->index()->comment('左边界');
            $table->integer('right_margin')->default(0)->index()->comment('右边界');
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
        Schema::dropIfExists('areas');
    }
}
