<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlertUsersAddrTable extends Migration
{

    protected $bindModel='App\Models\User';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $model = new $this->bindModel();
        $prefix = $model->getConnection()->getTablePrefix();
        $connection = $model->getConnectionName()?: config('database.default');
        DB::connection($connection)->statement("ALTER TABLE `".$prefix.$model->getTable()."`
ADD COLUMN `addr` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址' AFTER `description`,
ADD COLUMN `lng` decimal(10, 6) NULL DEFAULT NULL COMMENT '坐标经度' AFTER `addr`,
ADD COLUMN `lat` decimal(10, 6) NULL DEFAULT NULL COMMENT '坐标纬度' AFTER `lng`;");
        $sql = <<<'sql'
CREATE DEFINER = `root` @`%` FUNCTION `GETDISTANCE` ( lat1 DOUBLE, lng1 DOUBLE, lat2 DOUBLE, lng2 DOUBLE ) RETURNS DOUBLE READS SQL DATA DETERMINISTIC BEGIN
	DECLARE
		RAD DOUBLE;
	DECLARE
		EARTH_RADIUS DOUBLE DEFAULT 6378137;
	DECLARE
		radLat1 DOUBLE;
	DECLARE
		radLat2 DOUBLE;
	DECLARE
		radLng1 DOUBLE;
	DECLARE
		radLng2 DOUBLE;
	DECLARE
		s DOUBLE;

	SET RAD = PI( ) / 180.0;

	SET radLat1 = lat1 * RAD;

	SET radLat2 = lat2 * RAD;

	SET radLng1 = lng1 * RAD;

	SET radLng2 = lng2 * RAD;

	SET s = ACOS( COS( radLat1 ) * COS( radLat2 ) * COS( radLng1 - radLng2 ) + SIN( radLat1 ) * SIN( radLat2 ) ) * EARTH_RADIUS;

	SET s = ROUND( s * 10000 ) / 10000;
	RETURN s;

END
sql;
        DB::connection($connection)->statement($sql);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $model = new $this->bindModel();
        $prefix = $model->getConnection()->getTablePrefix();
        $connection = $model->getConnectionName()?: config('database.default');
        DB::connection($connection)->statement("ALTER TABLE `".$prefix.$model->getTable()."`
DROP COLUMN `addr`,
DROP COLUMN `lng`,
DROP COLUMN `lat`;");
    }
}
