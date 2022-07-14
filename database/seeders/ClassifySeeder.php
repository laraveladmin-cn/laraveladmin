<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class ClassifySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //分类数据
        $data = [[
                'name'=>'人寿保险',
                'children'=>[
                    ['name'=>'定期寿险'],
                    ['name'=>'终身寿险'],
                    ['name'=>'两全保险']
                ]
            ],[
                'name'=>'年金保险',
                'children'=>[
                    ['name'=>'养老年金保险'],
                    ['name'=>'非养老年金保险']
                ]
            ],[
                'name'=>'健康保险',
                'children'=>[
                    ['name'=>'个人税收优惠型健康保险'],
                    ['name'=>'非个人税收优惠型健康保险']
                ]
            ],[
                'name'=>'意外伤害保险',
                'children'=>[]
            ],[
                'name'=>'委托管理业务',
                'children'=>[
                    ['name'=>'健康保障委托管理'],
                    ['name'=>'养老保障委托管理']
                ]
            ]];
        //数据写入


    }
}
