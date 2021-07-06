<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->unsignedInteger('user_id')->default(0)->index()->comment('用户ID$select2@integer|exists:users,id|unique:members,user_id');
            $table->unsignedInteger('parent_id')->default(0)->index()->comment('推荐人ID$select2@sometimes|required|exists:members,id');
            $table->unsignedSmallInteger('level')->default(0)->comment('层级');
            $table->unsignedInteger('left_margin')->default(0)->comment('左边界');
            $table->unsignedInteger('right_margin')->default(0)->comment('右边界');
            $table->timestamps();//->comment('更新时间');
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
        Schema::dropIfExists('members');
    }
}
