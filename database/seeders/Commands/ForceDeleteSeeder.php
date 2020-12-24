<?php

namespace Database\Seeders\Commands;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ForceDeleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        collect(Storage::allFiles(app_path('Models')))
            ->map(function($file){
                $model_str = '\\App\Models\\'.str_replace('.php','',$file);
                $model = new $model_str();
                try{
                    $deleted_at = $model->getDeletedAtColumn();
                }catch (\Exception $e){
                    $deleted_at = '';
                }
                //设置了过期时间且有软删除
                if(isset($model->past_due) && $deleted_at){
                    $past_due = $model->past_due;
                    $model->where($deleted_at,'<=',\Carbon\Carbon::now()->subSecond($past_due)->toDateTimeString())
                        ->onlyTrashed()
                        ->forceDelete();
                }
            });
    }
}
