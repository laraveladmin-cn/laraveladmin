<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus', function(Blueprint $table)
		{
			$table->increments('id')->comment('ID');
			$table->string('name')->default('')->comment('名称@required');
			$table->string('icons')->default('')->comment('图标@nullable|alpha_dash');
			$table->string('description')->default('')->comment('描述$textarea');
			$table->string('url')->default('')->comment('URL路径');
			$table->integer('parent_id')->default(0)->index()->comment('父级ID@sometimes|required|exists:menus,id');
			$table->integer('method')->default(1)->comment('请求方式:1-get,2-post,4-put,8-delete,16-head,32-options,64-trace,128-connect$checkbox@required|array');
			$table->integer('is_page')->default(0)->comment('是否为页面:0-否,1-是$radio@in:0,1');
			$table->boolean('disabled')->default(0)->comment('功能状态:0-启用,1-禁用$radio@in:0,1');
			$table->boolean('status')->default(2)->comment('状态:1-显示,2-不显示$radio@in:1,2');
			$table->smallInteger('level')->default(0)->comment('层级');
			$table->integer('left_margin')->default(0)->index()->comment('左边界');
			$table->integer('right_margin')->default(0)->index()->comment('右边界');
			$table->timestamps();
			$table->softDeletes();
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="菜单$softDeletes,timestamps"';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('menus');
	}

}
