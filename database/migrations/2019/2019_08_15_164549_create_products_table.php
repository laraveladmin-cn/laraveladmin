<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id')->comment('ID');
			$table->string('uid')->default('')->unique('uid')->comment('唯一标识');
			$table->integer('firm_id')->unsigned()->default(0)->index('firm_id')->comment('保险公司ID');
			$table->integer('classify_id')->unsigned()->default(0)->index('classify_id')->comment('一级分类ID@required|integer|exists:classifys,id');
			$table->integer('classify2_id')->unsigned()->default(0)->index('classify2_id')->comment('二级分类ID@required|integer|exists:classifys,id');
            $table->integer('pclassify_id')->unsigned()->default(0)->index('pclassify_id')->comment('险种分组ID@required|integer|exists:pclassifys,id');
            $table->string('name')->default('')->comment('名称');
			$table->boolean('is_long_time')->default(1)->index('is_long_time')->comment('长期险种:0-否,1-是$select@in:0,1');
			$table->boolean('class')->default(0)->comment('类别:0-传统型产品,1-新型产品');
			$table->boolean('buy_type')->default(0)->comment('购买方式:1-个人,2-团体');
			$table->boolean('pay_type')->default(0)->comment('交费方式:1-一次性交费,2-分期交费,4-灵活交费$checkbox');
			$table->boolean('attr')->default(0)->comment('产品属性:0-无,1-学生平安险,2-女性专属产品,3-少儿专属产品,4-老年专属产品,5-航空意外险');
			$table->string('pdf_url')->default('')->comment('文档地址');
			$table->string('company_no')->default('')->comment('保险公司文件编号');
			$table->string('no')->default('')->comment('文件编号');
			$table->boolean('status')->default(1)->comment('状态:0-停售,1-在售,2-停用');
			$table->dateTime('issue_at')->nullable()->comment('发布时间');
			$table->date('stop_at')->nullable()->comment('停售日期');
			$table->timestamps();
			$table->softDeletes()->comment('删除时间');
            //设置表备注
            $table->charset = config('database.connections.'.config('database.default').'.charset').
                ' COMMENT="险种$softDeletes,timestamps"';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('products');
	}

}
