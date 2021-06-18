<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlertFirmsReceiptTmpTable extends Migration
{

    protected $bindModel='App\Models\Firm';

    /**
     * Run the migrations.
     *
     * 返回: void
     */
    public function up()
    {
        $model = new $this->bindModel();
        $prefix = $model->getConnection()->getTablePrefix();
        $connection = $model->getConnectionName()?: config('database.default');
        DB::connection($connection)->statement("ALTER TABLE `".$prefix.$model->getTable()."`
ADD COLUMN `receipt_type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '回执模板类型:0-pdf,1-markdown' AFTER `insure_notify`,
ADD COLUMN `receipt_url` varchar(255) NOT NULL DEFAULT '' COMMENT '回执模板' AFTER `receipt_type`,
ADD COLUMN `receipt_tmp` text NULL COMMENT '回执模板' AFTER `receipt_url`;");


    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        $model = new $this->bindModel();
        $prefix = $model->getConnection()->getTablePrefix();
        $connection = $model->getConnectionName()?: config('database.default');
        DB::connection($connection)->statement("ALTER TABLE `".$prefix.$model->getTable()."`
DROP COLUMN `receipt_type`,
DROP COLUMN `receipt_url`,
DROP COLUMN `receipt_tmp`;");
    }
}
