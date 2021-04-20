<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class YearTableSeeder extends Seeder
{
    protected $bindModel='App\Models\Year';
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $class = $this->bindModel;
        $json_data=<<<'JSON'
[{"id":1,"name":"1年","value":1,"description":"1年","created_at":"2017-07-04 08:01:29","updated_at":"2017-07-04 08:01:29","deleted_at":null},{"id":2,"name":"2年","value":2,"description":"2年","created_at":"2017-07-04 08:01:29","updated_at":"2017-07-04 08:01:29","deleted_at":null},{"id":3,"name":"3年","value":3,"description":"3年","created_at":"2017-07-04 08:01:29","updated_at":"2017-07-04 08:01:29","deleted_at":null},{"id":4,"name":"4年","value":4,"description":"4年","created_at":"2017-07-04 08:01:29","updated_at":"2017-07-04 08:01:29","deleted_at":null},{"id":5,"name":"5年","value":5,"description":"5年","created_at":"2017-07-04 08:01:29","updated_at":"2017-07-04 08:01:29","deleted_at":null},{"id":6,"name":"6年","value":6,"description":"6年","created_at":"2017-07-04 08:01:29","updated_at":"2017-07-04 08:01:29","deleted_at":null},{"id":7,"name":"7年","value":7,"description":"7年","created_at":"2017-07-04 08:01:29","updated_at":"2017-07-04 08:01:29","deleted_at":null},{"id":8,"name":"8年","value":8,"description":"8年","created_at":"2017-07-04 08:01:29","updated_at":"2017-07-04 08:01:29","deleted_at":null},{"id":9,"name":"9年","value":9,"description":"9年","created_at":"2017-07-04 08:01:29","updated_at":"2017-07-04 08:01:29","deleted_at":null},{"id":10,"name":"10年","value":10,"description":"10年","created_at":"2017-07-04 08:01:29","updated_at":"2017-07-04 08:01:29","deleted_at":null},{"id":11,"name":"11年","value":11,"description":"11年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":12,"name":"12年","value":12,"description":"12年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":13,"name":"13年","value":13,"description":"13年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":14,"name":"14年","value":14,"description":"14年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":15,"name":"15年","value":15,"description":"15年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":16,"name":"16年","value":16,"description":"16年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":17,"name":"17年","value":17,"description":"17年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":18,"name":"18年","value":18,"description":"18年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":19,"name":"19年","value":19,"description":"19年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":20,"name":"20年","value":20,"description":"20年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":21,"name":"21年","value":21,"description":"21年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":22,"name":"22年","value":22,"description":"22年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":23,"name":"23年","value":23,"description":"23年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":24,"name":"24年","value":24,"description":"24年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":25,"name":"25年","value":25,"description":"25年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":26,"name":"26年","value":26,"description":"26年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":27,"name":"27年","value":27,"description":"27年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":28,"name":"28年","value":28,"description":"28年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":29,"name":"29年","value":29,"description":"29年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":30,"name":"30年","value":30,"description":"30年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":31,"name":"31年","value":31,"description":"31年","created_at":"2017-07-04 08:01:30","updated_at":"2017-07-04 08:01:30","deleted_at":null},{"id":32,"name":"32年","value":32,"description":"32年","created_at":"2017-08-27 21:45:34","updated_at":"2017-08-27 21:45:34","deleted_at":null},{"id":33,"name":"33年","value":33,"description":"33年","created_at":"2017-08-27 21:45:48","updated_at":"2017-08-27 21:45:48","deleted_at":null},{"id":34,"name":"34年","value":34,"description":"34年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":35,"name":"35年","value":35,"description":"35年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":36,"name":"36年","value":36,"description":"36年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":37,"name":"37年","value":37,"description":"37年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":38,"name":"38年","value":38,"description":"38年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":39,"name":"39年","value":39,"description":"39年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":40,"name":"40年","value":40,"description":"40年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":41,"name":"41年","value":41,"description":"41年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":42,"name":"42年","value":42,"description":"42年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":43,"name":"43年","value":43,"description":"43年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":44,"name":"44年","value":44,"description":"44年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":45,"name":"45年","value":45,"description":"45年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":46,"name":"46年","value":46,"description":"46年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":47,"name":"47年","value":47,"description":"47年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":48,"name":"48年","value":48,"description":"48年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":49,"name":"49年","value":49,"description":"49年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":50,"name":"50年","value":50,"description":"50年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":51,"name":"51年","value":51,"description":"51年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":52,"name":"52年","value":52,"description":"52年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":53,"name":"53年","value":53,"description":"53年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":54,"name":"54年","value":54,"description":"54年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":55,"name":"55年","value":55,"description":"55年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":56,"name":"56年","value":56,"description":"56年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":57,"name":"57年","value":57,"description":"57年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":58,"name":"58年","value":58,"description":"58年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":59,"name":"59年","value":59,"description":"59年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":60,"name":"60年","value":60,"description":"60年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":61,"name":"61年","value":61,"description":"61年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":62,"name":"62年","value":62,"description":"62年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":63,"name":"63年","value":63,"description":"63年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":64,"name":"64年","value":64,"description":"64年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":65,"name":"65年","value":65,"description":"65年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":66,"name":"66年","value":66,"description":"66年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":67,"name":"67年","value":67,"description":"67年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":68,"name":"68年","value":68,"description":"68年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":69,"name":"69年","value":69,"description":"69年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":70,"name":"70年","value":70,"description":"70年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":71,"name":"71年","value":71,"description":"71年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":72,"name":"72年","value":72,"description":"72年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":73,"name":"73年","value":73,"description":"73年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":74,"name":"74年","value":74,"description":"74年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":75,"name":"75年","value":75,"description":"75年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":76,"name":"76年","value":76,"description":"76年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":77,"name":"77年","value":77,"description":"77年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":78,"name":"78年","value":78,"description":"78年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":79,"name":"79年","value":79,"description":"79年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":80,"name":"80年","value":80,"description":"80年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":81,"name":"81年","value":81,"description":"81年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":82,"name":"82年","value":82,"description":"82年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":83,"name":"83年","value":83,"description":"83年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":84,"name":"84年","value":84,"description":"84年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":85,"name":"85年","value":85,"description":"85年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":86,"name":"86年","value":86,"description":"86年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":87,"name":"87年","value":87,"description":"87年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":88,"name":"88年","value":88,"description":"88年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":89,"name":"89年","value":89,"description":"89年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":90,"name":"90年","value":90,"description":"90年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":91,"name":"91年","value":91,"description":"91年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":92,"name":"92年","value":92,"description":"92年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":93,"name":"93年","value":93,"description":"93年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":94,"name":"94年","value":94,"description":"94年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":95,"name":"95年","value":95,"description":"95年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":96,"name":"96年","value":96,"description":"96年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":97,"name":"97年","value":97,"description":"97年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":98,"name":"98年","value":98,"description":"98年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":99,"name":"99年","value":99,"description":"99年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":100,"name":"100年","value":100,"description":"100年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":101,"name":"101年","value":101,"description":"101年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":102,"name":"102年","value":102,"description":"102年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":103,"name":"103年","value":103,"description":"103年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":104,"name":"104年","value":104,"description":"104年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null},{"id":105,"name":"105年","value":105,"description":"105年","created_at":"2020-02-05 11:08:23","updated_at":"2020-02-05 11:08:23","deleted_at":null}]
JSON;
        $data = json_decode($json_data,true);
        $class::insertReplaceAll($data);
    }
}