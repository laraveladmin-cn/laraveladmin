<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;
use \App\Models\Menu;
use \App\Models\MenuRole;


/**
 * 将菜单ID变更成uuid
 */
class AlertMenusUuidTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //dd(11);
        //return ;
        $id_info = collect(
            collect(Menu::getTableInfo())
                ->get('table_fields')
        )->keyBy('Field')
            ->get('id');
        $type = \Illuminate\Support\Arr::get($id_info,'Type','');
        if(\Illuminate\Support\Str::startsWith($type,'char')){
            return;
        }
        Schema::table('menus', function (Blueprint $table) {
            $table->uuid('uuid')
                ->default('')
                ->comment('ID');
            $table->uuid('parent_uuid')
                ->default('')
                ->comment('父级ID@sometimes|required|exists:menus,id');
            $table->uuid('resource_uuid')
                ->default('')
                ->comment('所属资源');
        });
        Schema::table('menu_role', function (Blueprint $table) {
            $table->uuid('menu_uuid')
                ->default('')
                ->comment('菜单ID');
        });
        Schema::table('logs', function (Blueprint $table) {
            $table->uuid('menu_uuid')
                ->default('')
                ->comment('菜单ID');
        });
        Schema::table('params', function (Blueprint $table) {
            $table->uuid('menu_uuid')
                ->default('')
                ->comment('接口ID$select2@required|exists:menus,id');
        });
        Schema::table('responses', function (Blueprint $table) {
            $table->uuid('menu_uuid')
                ->default('')
                ->comment('接口ID@required|exists:menus,id');
        });
        //生成唯一标识键
        DB::table('menus')
            ->where('uuid','')
            ->update([
                'uuid'=>DB::raw('UUID()')
            ]);
        //修改关联数据项
        Menu::query()
            ->where('menus.parent_uuid','')
            ->where('menus.parent_id','>',0)
            ->join('menus as parents', 'menus.parent_id', '=', 'parents.id')
            ->update([
                'menus.parent_uuid' => DB::raw('parents.uuid')
            ]);
        Menu::query()
            ->where('menus.resource_uuid','')
            ->where('menus.resource_id','>',0)
            ->join('menus as resources', 'menus.resource_id', '=', 'resources.id')
            ->update([
                'menus.resource_uuid' => DB::raw('resources.uuid')
            ]);
        MenuRole::query()
            ->where('menu_uuid','')
            ->where('menu_id','>',0)
            ->join('menus', 'menu_role.menu_id', '=', 'menus.id')
            ->update([
                'menu_uuid' => DB::raw('menus.uuid')
            ]);
        \App\Models\Log::query()
            ->where('menu_uuid','')
            ->where('menu_id','>',0)
            ->join('menus', 'logs.menu_id', '=', 'menus.id')
            ->update([
                'menu_uuid' => DB::raw('menus.uuid')
            ]);
        \App\Models\Param::query()
            ->where('menu_uuid','')
            ->where('menu_id','>',0)
            ->join('menus', 'params.menu_id', '=', 'menus.id')
            ->update([
                'menu_uuid' => DB::raw('menus.uuid')
            ]);
        \App\Models\Response::query()
            ->where('menu_uuid','')
            ->where('menu_id','>',0)
            ->join('menus', 'responses.menu_id', '=', 'menus.id')
            ->update([
                'menu_uuid' => DB::raw('menus.uuid')
            ]);
        $this->replaceId('storage/developments/api-doc-common.json');
        $this->replaceId('storage/developments/api-doc.json');
        $this->replaceId('routes/route.json',true);


        Schema::table('menu_role', function (Blueprint $table) {
            $table->dropPrimary(['role_id','menu_id']);
            $table->dropIndex('menu_role_menu_id_index');
            $table->dropColumn(['menu_id']);
            $table->renameColumn('menu_uuid','menu_id');
            $table->index('menu_id');
            $table->primary(['role_id','menu_id']);
        });

        Schema::table('logs', function (Blueprint $table) {
            $table->dropIndex('logs_user_id_index');
            $table->dropColumn(['menu_id']);
            $table->renameColumn('menu_uuid','menu_id');
            $table->index('menu_id');
        });

        Schema::table('params', function (Blueprint $table) {
            $table->dropIndex('params_menu_id_index');
            $table->dropColumn(['menu_id']);
            $table->renameColumn('menu_uuid','menu_id');
            $table->index('menu_id');
        });
        Schema::table('responses', function (Blueprint $table) {
            $table->dropIndex('responses_menu_id_index');
            $table->dropColumn(['menu_id']);
            $table->renameColumn('menu_uuid','menu_id');
            $table->index('menu_id');
        });


        Schema::table('menus', function (Blueprint $table) {
            $table->dropIndex('menus_parent_id_index');
            $table->dropColumn(['parent_id']);
            $table->renameColumn('parent_uuid','parent_id');
            $table->index('parent_id');

            $table->dropColumn(['resource_id']);
            $table->renameColumn('resource_uuid','resource_id');

            $table->dropColumn(['id']);
            $table->renameColumn('uuid','id');
            $table->primary('id');
        });




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }

    protected function replaceId($file,$is_route=false){
        $fields = $is_route?['id','parent_id','end_id']:['id'];
        $disk = \Illuminate\Support\Facades\Storage::disk('root');
        //修正api文档中的ID
        if($disk->exists($file)){
            $json = $disk->get($file);
            $json_data = json_decode($json,true);
            if(isset($json_data['menus'])){
                $json_data['menus'] = collect($json_data['menus'])
                    ->map(function ($menu)use ($fields){
                        foreach ($fields as $field){
                            if(isset($menu[$field]) && is_numeric($menu[$field])){
                                $uuid = Menu::query()
                                    ->where('id',$menu[$field])
                                    ->value('uuid');
                                if($uuid){
                                    $menu[$field] = $uuid;
                                }
                            }
                        }
                        return $menu;
                    })->toArray();
                $disk->put($file,json_encode($json_data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT).PHP_EOL);
            }
            if(isset($json_data['resource'])){
                $json_data['resource'] = collect($json_data['resource'])
                    ->map(function ($menu)use ($fields){
                        foreach ($fields as $field){
                            if(isset($menu[$field]) && is_numeric($menu[$field])){
                               $uuid = Menu::query()
                                    ->where('id',$menu[$field])
                                    ->value('uuid');
                                if($uuid){
                                    $menu[$field] = $uuid;
                                }
                            }
                        }
                        if(isset($menu['options']['only'])){
                            $menu['options']['only'] = collect($menu['options']['only'])
                                ->map(function ($item){
                                    if(isset($item['id']) && is_numeric($item['id'])){
                                        $uuid = Menu::query()
                                            ->where('id',$item['id'])
                                            ->value('uuid');
                                        if($uuid){
                                            $item['id'] = $uuid;
                                        }
                                    }
                                    return $item;
                            })->toArray();
                        }
                        return $menu;
                    })->toArray();
                $disk->put($file,json_encode($json_data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT).PHP_EOL);
            }
        }
    }
}
