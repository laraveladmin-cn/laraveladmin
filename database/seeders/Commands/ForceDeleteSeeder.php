<?php

namespace Database\Seeders\Commands;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ForceDeleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        collect(Storage::disk('root')->allFiles('/app/Models'))
            ->each(function($file){
                $file = Str::replaceFirst('app/Models/','',$file);
                if(Str::startsWith($file,'.') || Str::startsWith($file,'Traits/')){
                    return;
                }
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
