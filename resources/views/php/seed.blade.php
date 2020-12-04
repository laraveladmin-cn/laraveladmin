{!! $php !!}
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class {{$class}}TableSeeder extends Seeder
{
    protected $bindModel='{{$model}}';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $class = $this->bindModel;
        $json_data=<<<'{{$json}}'
{!! $data !!}
{{$json}};
        $data = json_decode($json_data,true);
        $class::insertReplaceAll($data);
    }
}
