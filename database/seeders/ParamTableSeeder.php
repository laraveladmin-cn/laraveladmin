<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use \Illuminate\Support\Facades\DB;
class ParamTableSeeder extends Seeder
{
    protected $bindModel='App\Models\Param';
    protected $params = [];
    protected $now_at = '';
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $this->now_at = \Carbon\Carbon::now()->toDateTimeString();
        //初始化数据表
        DB::table('params')->truncate();
        $class = $this->bindModel;
        $file = storage_path('developments/api-doc.json');
        $data = json_decode(file_get_contents($file),true)?:[];
        collect(Arr::get($data,'menus',[]))->map(function ($menu){
            collect(['params','body_params','route_params'])->each(function ($value,$key)use ($menu){
                collect(Arr::get($menu,$value,[]))->each(function ($param)use ($menu,$key){
                    $param['menu_id'] = $menu['id'];
                    $param['use'] = $key;
                    $param['created_at'] = $param['updated_at']  = $this->now_at;
                    $this->params[] = $param;
                });
            });
        });
        $class::insertReplaceAll($this->params);
    }
}
