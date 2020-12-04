<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use \App\Models\Menu;
use Illuminate\Support\Facades\DB;

class MenuRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        DB::table('menu_role')->truncate(); //角色权限关联表


    }
}
