<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use \Illuminate\Support\Facades\DB;

class ResponseTableSeeder extends Seeder
{
    protected $bindModel='App\Models\Response';
    protected $responses = [];
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
        DB::table('responses')->truncate();
        $class = $this->bindModel;
        $file = storage_path('developments/api-doc.json');
        $data = json_decode(file_get_contents($file),true)?:[];
        collect(Arr::get($data,'menus',[]))->map(function ($menu){
            collect(Arr::get($menu,'responses',[]))->each(function ($param)use ($menu){
                $param['menu_id'] = $menu['id'];
                $param['created_at'] = $param['updated_at']  = $this->now_at;
                $this->responses[] = $param;
            });
        });
        $class::insertReplaceAll($this->responses);
    }
}
