<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class ResponseTableSeeder extends Seeder
{
    protected $bindModel='App\Models\Response';
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $class = $this->bindModel;
        $json_data=<<<'JSON'
[
    {
        "id": 1,
        "menu_id": 5,
        "name": "count",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 2,
        "menu_id": 5,
        "name": "count.$index",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 3,
        "menu_id": 5,
        "name": "count.$index.name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 4,
        "menu_id": 5,
        "name": "count.$index.value",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 5,
        "menu_id": 5,
        "name": "count.$index.class",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 6,
        "menu_id": 5,
        "name": "count.$index.icon",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 7,
        "menu_id": 5,
        "name": "count.$index.url",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 8,
        "menu_id": 5,
        "name": "count.$index._trans_name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 9,
        "menu_id": 9,
        "name": "list.data.$index",
        "description": "用户对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 10,
        "menu_id": 9,
        "name": "list.data.$index.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 11,
        "menu_id": 9,
        "name": "list.data.$index.uname",
        "description": "用户名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 12,
        "menu_id": 9,
        "name": "list.data.$index.name",
        "description": "姓名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 13,
        "menu_id": 9,
        "name": "list.data.$index.mobile_phone",
        "description": "手机号码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 14,
        "menu_id": 9,
        "name": "list.data.$index.email",
        "description": "电子邮箱",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 15,
        "menu_id": 9,
        "name": "list.data.$index.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 16,
        "menu_id": 9,
        "name": "list.data.$index.created_at",
        "description": "创建时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 17,
        "menu_id": 9,
        "name": "list.data.$index.updated_at",
        "description": "修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 18,
        "menu_id": 9,
        "name": "options.where.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 19,
        "menu_id": 9,
        "name": "options.where.created_at",
        "description": "创建时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 20,
        "menu_id": 9,
        "name": "options.where.created_at.0",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 21,
        "menu_id": 9,
        "name": "options.where.admin",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 22,
        "menu_id": 9,
        "name": "options.where.name|uname",
        "description": "姓名或用户名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 23,
        "menu_id": 9,
        "name": "options.where.name|uname|mobile_phone|email",
        "description": "姓名或用户名或手机号码或电子邮箱",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 24,
        "menu_id": 9,
        "name": "options.where.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 25,
        "menu_id": 9,
        "name": "options.order.updated_at",
        "description": "修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 26,
        "menu_id": 9,
        "name": "options.order.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 27,
        "menu_id": 9,
        "name": "maps.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 28,
        "menu_id": 9,
        "name": "maps.status.0",
        "description": "注销",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 29,
        "menu_id": 9,
        "name": "maps.status.1",
        "description": "有效",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 30,
        "menu_id": 9,
        "name": "maps.status.2",
        "description": "停用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 31,
        "menu_id": 9,
        "name": "keywordsMap.name|uname|mobile_phone|email",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 32,
        "menu_id": 9,
        "name": "excel.exportFields.uname",
        "description": "用户名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 33,
        "menu_id": 9,
        "name": "excel.exportFields.password",
        "description": "密码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 34,
        "menu_id": 9,
        "name": "excel.exportFields.name",
        "description": "姓名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 35,
        "menu_id": 9,
        "name": "excel.exportFields.avatar",
        "description": "头像",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 36,
        "menu_id": 9,
        "name": "excel.exportFields.email",
        "description": "电子邮箱",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 37,
        "menu_id": 9,
        "name": "excel.exportFields.mobile_phone",
        "description": "手机号码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 38,
        "menu_id": 9,
        "name": "excel.exportFields.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 39,
        "menu_id": 9,
        "name": "excel.exportFields.description",
        "description": "备注",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 40,
        "menu_id": 9,
        "name": "excel.exportFields.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 41,
        "menu_id": 10,
        "name": "data.$index",
        "description": "用户对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 42,
        "menu_id": 10,
        "name": "data.$index.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 43,
        "menu_id": 10,
        "name": "data.$index.uname",
        "description": "用户名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 44,
        "menu_id": 10,
        "name": "data.$index.name",
        "description": "姓名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 45,
        "menu_id": 10,
        "name": "data.$index.mobile_phone",
        "description": "手机号码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 46,
        "menu_id": 10,
        "name": "data.$index.email",
        "description": "电子邮箱",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 47,
        "menu_id": 10,
        "name": "data.$index.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 48,
        "menu_id": 10,
        "name": "data.$index.created_at",
        "description": "创建时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 49,
        "menu_id": 10,
        "name": "data.$index.updated_at",
        "description": "修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 50,
        "menu_id": 11,
        "name": "data.$index",
        "description": "用户对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 51,
        "menu_id": 11,
        "name": "data.$index.$index",
        "description": "excel数据项",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 52,
        "menu_id": 11,
        "name": "data.$index.0",
        "description": "用户名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 53,
        "menu_id": 11,
        "name": "data.$index.1",
        "description": "密码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 54,
        "menu_id": 11,
        "name": "data.$index.2",
        "description": "姓名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 55,
        "menu_id": 11,
        "name": "data.$index.3",
        "description": "电子邮箱",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 56,
        "menu_id": 11,
        "name": "data.$index.4",
        "description": "手机号码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 57,
        "menu_id": 11,
        "name": "data.$index.5",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 58,
        "menu_id": 11,
        "name": "data.$index.6",
        "description": "备注",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 59,
        "menu_id": 11,
        "name": "data.$index.7",
        "description": "头像",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 60,
        "menu_id": 11,
        "name": "data.$index.8",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 61,
        "menu_id": 13,
        "name": "row",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 62,
        "menu_id": 13,
        "name": "row.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 63,
        "menu_id": 13,
        "name": "row.uname",
        "description": "用户名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 64,
        "menu_id": 13,
        "name": "row.password",
        "description": "密码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 65,
        "menu_id": 13,
        "name": "row.name",
        "description": "姓名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 66,
        "menu_id": 13,
        "name": "row.email",
        "description": "电子邮箱",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 67,
        "menu_id": 13,
        "name": "row.mobile_phone",
        "description": "手机号码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 68,
        "menu_id": 13,
        "name": "row.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 69,
        "menu_id": 13,
        "name": "row.description",
        "description": "备注",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 70,
        "menu_id": 13,
        "name": "row.avatar",
        "description": "头像",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 71,
        "menu_id": 13,
        "name": "maps.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 72,
        "menu_id": 13,
        "name": "maps.status.0",
        "description": "注销",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 73,
        "menu_id": 13,
        "name": "maps.status.1",
        "description": "有效",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 74,
        "menu_id": 13,
        "name": "maps.status.2",
        "description": "停用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 75,
        "menu_id": 17,
        "name": "list.data.$index",
        "description": "角色对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 76,
        "menu_id": 17,
        "name": "list.data.$index.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 77,
        "menu_id": 17,
        "name": "list.data.$index.name",
        "description": "名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 78,
        "menu_id": 17,
        "name": "list.data.$index.description",
        "description": "描述",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 79,
        "menu_id": 17,
        "name": "list.data.$index.parent_id",
        "description": "父级ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 80,
        "menu_id": 17,
        "name": "list.data.$index.level",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 81,
        "menu_id": 17,
        "name": "list.data.$index.updated_at",
        "description": "修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 82,
        "menu_id": 17,
        "name": "list.data.$index.admins_count",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 83,
        "menu_id": 17,
        "name": "list.data.$index.parent",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 84,
        "menu_id": 17,
        "name": "options.where.roles.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 85,
        "menu_id": 17,
        "name": "options.where.is_tmp",
        "description": "是否模板",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 86,
        "menu_id": 17,
        "name": "options.where.name",
        "description": "名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 87,
        "menu_id": 17,
        "name": "options.order.left_margin",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 88,
        "menu_id": 17,
        "name": "options.order.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 89,
        "menu_id": 17,
        "name": "maps.is_tmp",
        "description": "是否模板",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 90,
        "menu_id": 17,
        "name": "maps.is_tmp.0",
        "description": "否",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 91,
        "menu_id": 17,
        "name": "maps.is_tmp.1",
        "description": "是",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 92,
        "menu_id": 17,
        "name": "maps.parent",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 93,
        "menu_id": 17,
        "name": "maps.parent.is_tmp",
        "description": "角色是否模板",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 94,
        "menu_id": 17,
        "name": "maps.parent.is_tmp.0",
        "description": "否",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 95,
        "menu_id": 17,
        "name": "maps.parent.is_tmp.1",
        "description": "是",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 96,
        "menu_id": 17,
        "name": "mapsRelations.parent",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 97,
        "menu_id": 17,
        "name": "excel.exportFields.tmp_id",
        "description": "模板ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 98,
        "menu_id": 17,
        "name": "excel.exportFields.name",
        "description": "名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 99,
        "menu_id": 17,
        "name": "excel.exportFields.is_tmp",
        "description": "是否模板",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 100,
        "menu_id": 17,
        "name": "excel.exportFields.description",
        "description": "描述",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 101,
        "menu_id": 17,
        "name": "excel.exportFields.parent_id",
        "description": "父级ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 102,
        "menu_id": 17,
        "name": "excel.exportFields.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 103,
        "menu_id": 18,
        "name": "data.$index",
        "description": "角色对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 104,
        "menu_id": 18,
        "name": "data.$index.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 105,
        "menu_id": 18,
        "name": "data.$index.name",
        "description": "名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 106,
        "menu_id": 18,
        "name": "data.$index.description",
        "description": "描述",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 107,
        "menu_id": 18,
        "name": "data.$index.parent_id",
        "description": "父级ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 108,
        "menu_id": 18,
        "name": "data.$index.level",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 109,
        "menu_id": 18,
        "name": "data.$index.updated_at",
        "description": "修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 110,
        "menu_id": 18,
        "name": "data.$index.admins_count",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 111,
        "menu_id": 18,
        "name": "data.$index.parent",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 112,
        "menu_id": 19,
        "name": "data.$index",
        "description": "角色对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 113,
        "menu_id": 19,
        "name": "data.$index.$index",
        "description": "excel数据项",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 114,
        "menu_id": 19,
        "name": "data.$index.0",
        "description": "名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 115,
        "menu_id": 19,
        "name": "data.$index.1",
        "description": "描述",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 116,
        "menu_id": 19,
        "name": "data.$index.2",
        "description": "父级ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 117,
        "menu_id": 19,
        "name": "data.$index.3",
        "description": "模板ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 118,
        "menu_id": 19,
        "name": "data.$index.4",
        "description": "是否模板",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 119,
        "menu_id": 19,
        "name": "data.$index.5",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 120,
        "menu_id": 21,
        "name": "row",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 121,
        "menu_id": 21,
        "name": "row.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 122,
        "menu_id": 21,
        "name": "row.name",
        "description": "名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 123,
        "menu_id": 21,
        "name": "row.description",
        "description": "描述",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 124,
        "menu_id": 21,
        "name": "row.parent_id",
        "description": "父级ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 125,
        "menu_id": 21,
        "name": "row.tmp_id",
        "description": "模板ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 126,
        "menu_id": 21,
        "name": "row.is_tmp",
        "description": "是否模板",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 127,
        "menu_id": 21,
        "name": "row.menus",
        "description": "菜单",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 128,
        "menu_id": 21,
        "name": "row.tmp",
        "description": "角色",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 129,
        "menu_id": 21,
        "name": "row.tmp.id",
        "description": "角色ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 130,
        "menu_id": 21,
        "name": "row.tmp.name",
        "description": "角色名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 131,
        "menu_id": 21,
        "name": "row.menu_ids",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 132,
        "menu_id": 21,
        "name": "maps.is_tmp",
        "description": "是否模板",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 133,
        "menu_id": 21,
        "name": "maps.is_tmp.0",
        "description": "否",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 134,
        "menu_id": 21,
        "name": "maps.is_tmp.1",
        "description": "是",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 135,
        "menu_id": 21,
        "name": "maps.menus",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 136,
        "menu_id": 21,
        "name": "maps.menus.method",
        "description": "菜单请求方式",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 137,
        "menu_id": 21,
        "name": "maps.menus.method.1",
        "description": "get",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 138,
        "menu_id": 21,
        "name": "maps.menus.method.2",
        "description": "post",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 139,
        "menu_id": 21,
        "name": "maps.menus.method.4",
        "description": "put",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 140,
        "menu_id": 21,
        "name": "maps.menus.method.8",
        "description": "delete",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 141,
        "menu_id": 21,
        "name": "maps.menus.method.16",
        "description": "head",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 142,
        "menu_id": 21,
        "name": "maps.menus.method.32",
        "description": "options",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 143,
        "menu_id": 21,
        "name": "maps.menus.method.64",
        "description": "trace",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 144,
        "menu_id": 21,
        "name": "maps.menus.method.128",
        "description": "connect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 145,
        "menu_id": 21,
        "name": "maps.menus.method.256",
        "description": "patch",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 146,
        "menu_id": 21,
        "name": "maps.menus.is_page",
        "description": "菜单是否为页面",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 147,
        "menu_id": 21,
        "name": "maps.menus.is_page.0",
        "description": "否",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 148,
        "menu_id": 21,
        "name": "maps.menus.is_page.1",
        "description": "是",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 149,
        "menu_id": 21,
        "name": "maps.menus.status",
        "description": "菜单状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 150,
        "menu_id": 21,
        "name": "maps.menus.status.1",
        "description": "显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 151,
        "menu_id": 21,
        "name": "maps.menus.status.2",
        "description": "不显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 152,
        "menu_id": 21,
        "name": "maps.menus.disabled",
        "description": "菜单功能状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 153,
        "menu_id": 21,
        "name": "maps.menus.disabled.0",
        "description": "启用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 154,
        "menu_id": 21,
        "name": "maps.menus.disabled.1",
        "description": "禁用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 155,
        "menu_id": 21,
        "name": "maps.menus.use",
        "description": "菜单路由使用地方",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 156,
        "menu_id": 21,
        "name": "maps.menus.use.1",
        "description": "api",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 157,
        "menu_id": 21,
        "name": "maps.menus.use.2",
        "description": "web",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 158,
        "menu_id": 21,
        "name": "maps.menus.env",
        "description": "菜单使用环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 159,
        "menu_id": 21,
        "name": "maps.menus.env.local",
        "description": "开发环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 160,
        "menu_id": 21,
        "name": "maps.menus.env.testing",
        "description": "测试环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 161,
        "menu_id": 21,
        "name": "maps.menus.env.staging",
        "description": "预上线环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 162,
        "menu_id": 21,
        "name": "maps.menus.env.production",
        "description": "正式环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 163,
        "menu_id": 21,
        "name": "maps.menus.group",
        "description": "菜单所属组",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 164,
        "menu_id": 21,
        "name": "maps.menus.group.none",
        "description": "none",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 165,
        "menu_id": 21,
        "name": "maps.menus.group.open",
        "description": "open",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 166,
        "menu_id": 21,
        "name": "maps.menus.group.home",
        "description": "home",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 167,
        "menu_id": 21,
        "name": "maps.menus.group.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 168,
        "menu_id": 21,
        "name": "maps.menus.middleware",
        "description": "菜单单独使用中间件",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 169,
        "menu_id": 21,
        "name": "maps.menus.middleware.auth",
        "description": "auth",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 170,
        "menu_id": 21,
        "name": "maps.menus.middleware.auth.basic",
        "description": "auth.basic",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 171,
        "menu_id": 21,
        "name": "maps.menus.middleware.bindings",
        "description": "bindings",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 172,
        "menu_id": 21,
        "name": "maps.menus.middleware.cache.headers",
        "description": "cache.headers",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 173,
        "menu_id": 21,
        "name": "maps.menus.middleware.can",
        "description": "can",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 174,
        "menu_id": 21,
        "name": "maps.menus.middleware.guest",
        "description": "guest",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 175,
        "menu_id": 21,
        "name": "maps.menus.middleware.password.confirm",
        "description": "password.confirm",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 176,
        "menu_id": 21,
        "name": "maps.menus.middleware.signed",
        "description": "signed",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 177,
        "menu_id": 21,
        "name": "maps.menus.middleware.throttle",
        "description": "throttle",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 178,
        "menu_id": 21,
        "name": "maps.menus.middleware.verified",
        "description": "verified",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 179,
        "menu_id": 21,
        "name": "maps.menus.middleware.log",
        "description": "log",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 180,
        "menu_id": 21,
        "name": "maps.menus.middleware.api_client",
        "description": "api_client",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 181,
        "menu_id": 21,
        "name": "maps.menus.middleware.auth.redirect",
        "description": "auth.redirect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 182,
        "menu_id": 21,
        "name": "maps.menus.middleware.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 183,
        "menu_id": 21,
        "name": "maps.menus.middleware.activated",
        "description": "activated",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 184,
        "menu_id": 21,
        "name": "maps.tmp",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 185,
        "menu_id": 21,
        "name": "maps.tmp.is_tmp",
        "description": "角色是否模板",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 186,
        "menu_id": 21,
        "name": "maps.tmp.is_tmp.0",
        "description": "否",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 187,
        "menu_id": 21,
        "name": "maps.tmp.is_tmp.1",
        "description": "是",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 188,
        "menu_id": 21,
        "name": "maps.tmp_id",
        "description": "模板ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 189,
        "menu_id": 21,
        "name": "maps.optional_parents",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 190,
        "menu_id": 21,
        "name": "maps.permissions",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 191,
        "menu_id": 21,
        "name": "mapsRelations.menus",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 192,
        "menu_id": 21,
        "name": "mapsRelations.tmp",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 193,
        "menu_id": 25,
        "name": "list.data.$index",
        "description": "日志对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 194,
        "menu_id": 25,
        "name": "list.data.$index.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 195,
        "menu_id": 25,
        "name": "list.data.$index.user_id",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 196,
        "menu_id": 25,
        "name": "list.data.$index.menu_id",
        "description": "菜单ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 197,
        "menu_id": 25,
        "name": "list.data.$index.location",
        "description": "位置",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 198,
        "menu_id": 25,
        "name": "list.data.$index.ip",
        "description": "IP地址",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 199,
        "menu_id": 25,
        "name": "list.data.$index.parameters",
        "description": "请求参数",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 200,
        "menu_id": 25,
        "name": "list.data.$index.created_at",
        "description": "创建时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 201,
        "menu_id": 25,
        "name": "list.data.$index.user",
        "description": "用户对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 202,
        "menu_id": 25,
        "name": "list.data.$index.user.id",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 203,
        "menu_id": 25,
        "name": "list.data.$index.user.name",
        "description": "用户姓名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 204,
        "menu_id": 25,
        "name": "list.data.$index.user.uname",
        "description": "用户用户名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 205,
        "menu_id": 25,
        "name": "list.data.$index.menu",
        "description": "菜单对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 206,
        "menu_id": 25,
        "name": "list.data.$index.menu.id",
        "description": "菜单ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 207,
        "menu_id": 25,
        "name": "list.data.$index.menu.name",
        "description": "菜单名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 208,
        "menu_id": 25,
        "name": "list.data.$index.menu.parent_id",
        "description": "菜单父级ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 209,
        "menu_id": 25,
        "name": "list.data.$index.menu.resource_id",
        "description": "菜单所属资源ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 210,
        "menu_id": 25,
        "name": "list.data.$index.menu.parent",
        "description": "菜单对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 211,
        "menu_id": 25,
        "name": "list.data.$index.menu.parent.id",
        "description": "菜单ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 212,
        "menu_id": 25,
        "name": "list.data.$index.menu.parent.name",
        "description": "菜单名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 213,
        "menu_id": 25,
        "name": "list.data.$index.menu.parent.item_name",
        "description": "菜单",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 214,
        "menu_id": 25,
        "name": "options.where.menu_id",
        "description": "菜单ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 215,
        "menu_id": 25,
        "name": "options.where.user_id",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 216,
        "menu_id": 25,
        "name": "options.where.parameters",
        "description": "请求参数",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 217,
        "menu_id": 25,
        "name": "options.where.created_at",
        "description": "创建时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 218,
        "menu_id": 25,
        "name": "options.where.created_at.0",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 219,
        "menu_id": 25,
        "name": "options.order.updated_at",
        "description": "修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 220,
        "menu_id": 25,
        "name": "options.order.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 221,
        "menu_id": 25,
        "name": "maps.user",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 222,
        "menu_id": 25,
        "name": "maps.user.status",
        "description": "用户状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 223,
        "menu_id": 25,
        "name": "maps.user.status.0",
        "description": "注销",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 224,
        "menu_id": 25,
        "name": "maps.user.status.1",
        "description": "有效",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 225,
        "menu_id": 25,
        "name": "maps.user.status.2",
        "description": "停用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 226,
        "menu_id": 25,
        "name": "maps.menu",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 227,
        "menu_id": 25,
        "name": "maps.menu.method",
        "description": "菜单请求方式",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 228,
        "menu_id": 25,
        "name": "maps.menu.method.1",
        "description": "get",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 229,
        "menu_id": 25,
        "name": "maps.menu.method.2",
        "description": "post",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 230,
        "menu_id": 25,
        "name": "maps.menu.method.4",
        "description": "put",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 231,
        "menu_id": 25,
        "name": "maps.menu.method.8",
        "description": "delete",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 232,
        "menu_id": 25,
        "name": "maps.menu.method.16",
        "description": "head",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 233,
        "menu_id": 25,
        "name": "maps.menu.method.32",
        "description": "options",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 234,
        "menu_id": 25,
        "name": "maps.menu.method.64",
        "description": "trace",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 235,
        "menu_id": 25,
        "name": "maps.menu.method.128",
        "description": "connect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 236,
        "menu_id": 25,
        "name": "maps.menu.method.256",
        "description": "patch",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 237,
        "menu_id": 25,
        "name": "maps.menu.is_page",
        "description": "菜单是否为页面",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 238,
        "menu_id": 25,
        "name": "maps.menu.is_page.0",
        "description": "否",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 239,
        "menu_id": 25,
        "name": "maps.menu.is_page.1",
        "description": "是",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 240,
        "menu_id": 25,
        "name": "maps.menu.status",
        "description": "菜单状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 241,
        "menu_id": 25,
        "name": "maps.menu.status.1",
        "description": "显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 242,
        "menu_id": 25,
        "name": "maps.menu.status.2",
        "description": "不显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 243,
        "menu_id": 25,
        "name": "maps.menu.disabled",
        "description": "菜单功能状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 244,
        "menu_id": 25,
        "name": "maps.menu.disabled.0",
        "description": "启用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 245,
        "menu_id": 25,
        "name": "maps.menu.disabled.1",
        "description": "禁用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 246,
        "menu_id": 25,
        "name": "maps.menu.use",
        "description": "菜单路由使用地方",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 247,
        "menu_id": 25,
        "name": "maps.menu.use.1",
        "description": "api",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 248,
        "menu_id": 25,
        "name": "maps.menu.use.2",
        "description": "web",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 249,
        "menu_id": 25,
        "name": "maps.menu.env",
        "description": "菜单使用环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 250,
        "menu_id": 25,
        "name": "maps.menu.env.local",
        "description": "开发环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 251,
        "menu_id": 25,
        "name": "maps.menu.env.testing",
        "description": "测试环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 252,
        "menu_id": 25,
        "name": "maps.menu.env.staging",
        "description": "预上线环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 253,
        "menu_id": 25,
        "name": "maps.menu.env.production",
        "description": "正式环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 254,
        "menu_id": 25,
        "name": "maps.menu.group",
        "description": "菜单所属组",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 255,
        "menu_id": 25,
        "name": "maps.menu.group.none",
        "description": "none",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 256,
        "menu_id": 25,
        "name": "maps.menu.group.open",
        "description": "open",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 257,
        "menu_id": 25,
        "name": "maps.menu.group.home",
        "description": "home",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 258,
        "menu_id": 25,
        "name": "maps.menu.group.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 259,
        "menu_id": 25,
        "name": "maps.menu.middleware",
        "description": "菜单单独使用中间件",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 260,
        "menu_id": 25,
        "name": "maps.menu.middleware.auth",
        "description": "auth",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 261,
        "menu_id": 25,
        "name": "maps.menu.middleware.auth.basic",
        "description": "auth.basic",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 262,
        "menu_id": 25,
        "name": "maps.menu.middleware.bindings",
        "description": "bindings",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 263,
        "menu_id": 25,
        "name": "maps.menu.middleware.cache.headers",
        "description": "cache.headers",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 264,
        "menu_id": 25,
        "name": "maps.menu.middleware.can",
        "description": "can",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 265,
        "menu_id": 25,
        "name": "maps.menu.middleware.guest",
        "description": "guest",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 266,
        "menu_id": 25,
        "name": "maps.menu.middleware.password.confirm",
        "description": "password.confirm",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 267,
        "menu_id": 25,
        "name": "maps.menu.middleware.signed",
        "description": "signed",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 268,
        "menu_id": 25,
        "name": "maps.menu.middleware.throttle",
        "description": "throttle",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 269,
        "menu_id": 25,
        "name": "maps.menu.middleware.verified",
        "description": "verified",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 270,
        "menu_id": 25,
        "name": "maps.menu.middleware.log",
        "description": "log",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 271,
        "menu_id": 25,
        "name": "maps.menu.middleware.api_client",
        "description": "api_client",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 272,
        "menu_id": 25,
        "name": "maps.menu.middleware.auth.redirect",
        "description": "auth.redirect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 273,
        "menu_id": 25,
        "name": "maps.menu.middleware.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 274,
        "menu_id": 25,
        "name": "maps.menu.middleware.activated",
        "description": "activated",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 275,
        "menu_id": 25,
        "name": "maps.menu.parent",
        "description": "菜单",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 276,
        "menu_id": 25,
        "name": "maps.menu.parent.method",
        "description": "菜单请求方式",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 277,
        "menu_id": 25,
        "name": "maps.menu.parent.method.1",
        "description": "get",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 278,
        "menu_id": 25,
        "name": "maps.menu.parent.method.2",
        "description": "post",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 279,
        "menu_id": 25,
        "name": "maps.menu.parent.method.4",
        "description": "put",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 280,
        "menu_id": 25,
        "name": "maps.menu.parent.method.8",
        "description": "delete",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 281,
        "menu_id": 25,
        "name": "maps.menu.parent.method.16",
        "description": "head",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 282,
        "menu_id": 25,
        "name": "maps.menu.parent.method.32",
        "description": "options",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 283,
        "menu_id": 25,
        "name": "maps.menu.parent.method.64",
        "description": "trace",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 284,
        "menu_id": 25,
        "name": "maps.menu.parent.method.128",
        "description": "connect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 285,
        "menu_id": 25,
        "name": "maps.menu.parent.method.256",
        "description": "patch",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 286,
        "menu_id": 25,
        "name": "maps.menu.parent.is_page",
        "description": "菜单是否为页面",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 287,
        "menu_id": 25,
        "name": "maps.menu.parent.is_page.0",
        "description": "否",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 288,
        "menu_id": 25,
        "name": "maps.menu.parent.is_page.1",
        "description": "是",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 289,
        "menu_id": 25,
        "name": "maps.menu.parent.status",
        "description": "菜单状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 290,
        "menu_id": 25,
        "name": "maps.menu.parent.status.1",
        "description": "显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 291,
        "menu_id": 25,
        "name": "maps.menu.parent.status.2",
        "description": "不显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 292,
        "menu_id": 25,
        "name": "maps.menu.parent.disabled",
        "description": "菜单功能状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 293,
        "menu_id": 25,
        "name": "maps.menu.parent.disabled.0",
        "description": "启用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 294,
        "menu_id": 25,
        "name": "maps.menu.parent.disabled.1",
        "description": "禁用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 295,
        "menu_id": 25,
        "name": "maps.menu.parent.use",
        "description": "菜单路由使用地方",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 296,
        "menu_id": 25,
        "name": "maps.menu.parent.use.1",
        "description": "api",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 297,
        "menu_id": 25,
        "name": "maps.menu.parent.use.2",
        "description": "web",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 298,
        "menu_id": 25,
        "name": "maps.menu.parent.env",
        "description": "菜单使用环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 299,
        "menu_id": 25,
        "name": "maps.menu.parent.env.local",
        "description": "开发环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 300,
        "menu_id": 25,
        "name": "maps.menu.parent.env.testing",
        "description": "测试环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 301,
        "menu_id": 25,
        "name": "maps.menu.parent.env.staging",
        "description": "预上线环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 302,
        "menu_id": 25,
        "name": "maps.menu.parent.env.production",
        "description": "正式环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 303,
        "menu_id": 25,
        "name": "maps.menu.parent.group",
        "description": "菜单所属组",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 304,
        "menu_id": 25,
        "name": "maps.menu.parent.group.none",
        "description": "none",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 305,
        "menu_id": 25,
        "name": "maps.menu.parent.group.open",
        "description": "open",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 306,
        "menu_id": 25,
        "name": "maps.menu.parent.group.home",
        "description": "home",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 307,
        "menu_id": 25,
        "name": "maps.menu.parent.group.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 308,
        "menu_id": 25,
        "name": "maps.menu.parent.middleware",
        "description": "菜单单独使用中间件",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 309,
        "menu_id": 25,
        "name": "maps.menu.parent.middleware.auth",
        "description": "auth",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 310,
        "menu_id": 25,
        "name": "maps.menu.parent.middleware.auth.basic",
        "description": "auth.basic",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 311,
        "menu_id": 25,
        "name": "maps.menu.parent.middleware.bindings",
        "description": "bindings",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 312,
        "menu_id": 25,
        "name": "maps.menu.parent.middleware.cache.headers",
        "description": "cache.headers",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 313,
        "menu_id": 25,
        "name": "maps.menu.parent.middleware.can",
        "description": "can",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 314,
        "menu_id": 25,
        "name": "maps.menu.parent.middleware.guest",
        "description": "guest",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 315,
        "menu_id": 25,
        "name": "maps.menu.parent.middleware.password.confirm",
        "description": "password.confirm",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 316,
        "menu_id": 25,
        "name": "maps.menu.parent.middleware.signed",
        "description": "signed",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 317,
        "menu_id": 25,
        "name": "maps.menu.parent.middleware.throttle",
        "description": "throttle",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 318,
        "menu_id": 25,
        "name": "maps.menu.parent.middleware.verified",
        "description": "verified",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 319,
        "menu_id": 25,
        "name": "maps.menu.parent.middleware.log",
        "description": "log",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 320,
        "menu_id": 25,
        "name": "maps.menu.parent.middleware.api_client",
        "description": "api_client",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 321,
        "menu_id": 25,
        "name": "maps.menu.parent.middleware.auth.redirect",
        "description": "auth.redirect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 322,
        "menu_id": 25,
        "name": "maps.menu.parent.middleware.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 323,
        "menu_id": 25,
        "name": "maps.menu.parent.middleware.activated",
        "description": "activated",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 324,
        "menu_id": 25,
        "name": "maps.menu_id",
        "description": "菜单ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 325,
        "menu_id": 25,
        "name": "maps.user_id",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 326,
        "menu_id": 25,
        "name": "mapsRelations.user",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 327,
        "menu_id": 25,
        "name": "mapsRelations.menu",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 328,
        "menu_id": 25,
        "name": "excel.exportFields.menu.name",
        "description": "菜单操作菜单",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 329,
        "menu_id": 25,
        "name": "excel.exportFields.user.name",
        "description": "用户操作者",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 330,
        "menu_id": 25,
        "name": "excel.exportFields.location",
        "description": "位置",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 331,
        "menu_id": 25,
        "name": "excel.exportFields.ip",
        "description": "IP地址",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 332,
        "menu_id": 25,
        "name": "excel.exportFields.parameters",
        "description": "请求参数",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 333,
        "menu_id": 25,
        "name": "excel.exportFields.return",
        "description": "返回数据",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 334,
        "menu_id": 25,
        "name": "excel.exportFields.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 335,
        "menu_id": 26,
        "name": "data.$index",
        "description": "日志对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 336,
        "menu_id": 26,
        "name": "data.$index.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 337,
        "menu_id": 26,
        "name": "data.$index.user_id",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 338,
        "menu_id": 26,
        "name": "data.$index.menu_id",
        "description": "菜单ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 339,
        "menu_id": 26,
        "name": "data.$index.location",
        "description": "位置",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 340,
        "menu_id": 26,
        "name": "data.$index.ip",
        "description": "IP地址",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 341,
        "menu_id": 26,
        "name": "data.$index.parameters",
        "description": "请求参数",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 342,
        "menu_id": 26,
        "name": "data.$index.created_at",
        "description": "创建时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 343,
        "menu_id": 26,
        "name": "data.$index.user",
        "description": "用户对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 344,
        "menu_id": 26,
        "name": "data.$index.user.id",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 345,
        "menu_id": 26,
        "name": "data.$index.user.name",
        "description": "用户姓名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 346,
        "menu_id": 26,
        "name": "data.$index.user.uname",
        "description": "用户用户名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 347,
        "menu_id": 26,
        "name": "data.$index.menu",
        "description": "菜单对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 348,
        "menu_id": 26,
        "name": "data.$index.menu.id",
        "description": "菜单ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 349,
        "menu_id": 26,
        "name": "data.$index.menu.name",
        "description": "菜单名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 350,
        "menu_id": 26,
        "name": "data.$index.menu.parent_id",
        "description": "菜单父级ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 351,
        "menu_id": 26,
        "name": "data.$index.menu.resource_id",
        "description": "菜单所属资源ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 352,
        "menu_id": 26,
        "name": "data.$index.menu.parent",
        "description": "菜单对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 353,
        "menu_id": 26,
        "name": "data.$index.menu.parent.id",
        "description": "菜单ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 354,
        "menu_id": 26,
        "name": "data.$index.menu.parent.name",
        "description": "菜单名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 355,
        "menu_id": 26,
        "name": "data.$index.menu.parent.item_name",
        "description": "菜单",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 356,
        "menu_id": 27,
        "name": "data.$index",
        "description": "日志对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 357,
        "menu_id": 27,
        "name": "data.$index.$index",
        "description": "excel数据项",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 358,
        "menu_id": 27,
        "name": "data.$index.0",
        "description": "操作菜单",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 359,
        "menu_id": 27,
        "name": "data.$index.1",
        "description": "操作者",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 360,
        "menu_id": 27,
        "name": "data.$index.2",
        "description": "位置",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 361,
        "menu_id": 27,
        "name": "data.$index.3",
        "description": "IP地址",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 362,
        "menu_id": 27,
        "name": "data.$index.4",
        "description": "请求参数",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 363,
        "menu_id": 27,
        "name": "data.$index.5",
        "description": "返回数据",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 364,
        "menu_id": 27,
        "name": "data.$index.6",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 365,
        "menu_id": 29,
        "name": "row",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 366,
        "menu_id": 29,
        "name": "row.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 367,
        "menu_id": 29,
        "name": "row.menu_id",
        "description": "菜单ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 368,
        "menu_id": 29,
        "name": "row.user_id",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 369,
        "menu_id": 29,
        "name": "row.location",
        "description": "位置",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 370,
        "menu_id": 29,
        "name": "row.ip",
        "description": "IP地址",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 371,
        "menu_id": 29,
        "name": "row.parameters",
        "description": "请求参数",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 372,
        "menu_id": 29,
        "name": "row.return",
        "description": "返回数据",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 373,
        "menu_id": 29,
        "name": "row.menu",
        "description": "菜单",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 374,
        "menu_id": 29,
        "name": "row.menu.id",
        "description": "菜单ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 375,
        "menu_id": 29,
        "name": "row.menu.name",
        "description": "菜单名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 376,
        "menu_id": 29,
        "name": "row.menu.url",
        "description": "菜单URL路径",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 377,
        "menu_id": 29,
        "name": "row.user",
        "description": "用户",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 378,
        "menu_id": 29,
        "name": "row.user.id",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 379,
        "menu_id": 29,
        "name": "row.user.name",
        "description": "用户姓名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 380,
        "menu_id": 29,
        "name": "maps.menu",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 381,
        "menu_id": 29,
        "name": "maps.menu.method",
        "description": "菜单请求方式",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 382,
        "menu_id": 29,
        "name": "maps.menu.method.1",
        "description": "get",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 383,
        "menu_id": 29,
        "name": "maps.menu.method.2",
        "description": "post",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 384,
        "menu_id": 29,
        "name": "maps.menu.method.4",
        "description": "put",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 385,
        "menu_id": 29,
        "name": "maps.menu.method.8",
        "description": "delete",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 386,
        "menu_id": 29,
        "name": "maps.menu.method.16",
        "description": "head",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 387,
        "menu_id": 29,
        "name": "maps.menu.method.32",
        "description": "options",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 388,
        "menu_id": 29,
        "name": "maps.menu.method.64",
        "description": "trace",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 389,
        "menu_id": 29,
        "name": "maps.menu.method.128",
        "description": "connect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 390,
        "menu_id": 29,
        "name": "maps.menu.method.256",
        "description": "patch",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 391,
        "menu_id": 29,
        "name": "maps.menu.is_page",
        "description": "菜单是否为页面",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 392,
        "menu_id": 29,
        "name": "maps.menu.is_page.0",
        "description": "否",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 393,
        "menu_id": 29,
        "name": "maps.menu.is_page.1",
        "description": "是",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 394,
        "menu_id": 29,
        "name": "maps.menu.status",
        "description": "菜单状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 395,
        "menu_id": 29,
        "name": "maps.menu.status.1",
        "description": "显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 396,
        "menu_id": 29,
        "name": "maps.menu.status.2",
        "description": "不显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 397,
        "menu_id": 29,
        "name": "maps.menu.disabled",
        "description": "菜单功能状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 398,
        "menu_id": 29,
        "name": "maps.menu.disabled.0",
        "description": "启用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 399,
        "menu_id": 29,
        "name": "maps.menu.disabled.1",
        "description": "禁用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 400,
        "menu_id": 29,
        "name": "maps.menu.use",
        "description": "菜单路由使用地方",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 401,
        "menu_id": 29,
        "name": "maps.menu.use.1",
        "description": "api",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 402,
        "menu_id": 29,
        "name": "maps.menu.use.2",
        "description": "web",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 403,
        "menu_id": 29,
        "name": "maps.menu.env",
        "description": "菜单使用环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 404,
        "menu_id": 29,
        "name": "maps.menu.env.local",
        "description": "开发环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 405,
        "menu_id": 29,
        "name": "maps.menu.env.testing",
        "description": "测试环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 406,
        "menu_id": 29,
        "name": "maps.menu.env.staging",
        "description": "预上线环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 407,
        "menu_id": 29,
        "name": "maps.menu.env.production",
        "description": "正式环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 408,
        "menu_id": 29,
        "name": "maps.menu.group",
        "description": "菜单所属组",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 409,
        "menu_id": 29,
        "name": "maps.menu.group.none",
        "description": "none",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 410,
        "menu_id": 29,
        "name": "maps.menu.group.open",
        "description": "open",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 411,
        "menu_id": 29,
        "name": "maps.menu.group.home",
        "description": "home",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 412,
        "menu_id": 29,
        "name": "maps.menu.group.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 413,
        "menu_id": 29,
        "name": "maps.menu.middleware",
        "description": "菜单单独使用中间件",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 414,
        "menu_id": 29,
        "name": "maps.menu.middleware.auth",
        "description": "auth",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 415,
        "menu_id": 29,
        "name": "maps.menu.middleware.auth.basic",
        "description": "auth.basic",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 416,
        "menu_id": 29,
        "name": "maps.menu.middleware.bindings",
        "description": "bindings",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 417,
        "menu_id": 29,
        "name": "maps.menu.middleware.cache.headers",
        "description": "cache.headers",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 418,
        "menu_id": 29,
        "name": "maps.menu.middleware.can",
        "description": "can",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 419,
        "menu_id": 29,
        "name": "maps.menu.middleware.guest",
        "description": "guest",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 420,
        "menu_id": 29,
        "name": "maps.menu.middleware.password.confirm",
        "description": "password.confirm",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 421,
        "menu_id": 29,
        "name": "maps.menu.middleware.signed",
        "description": "signed",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 422,
        "menu_id": 29,
        "name": "maps.menu.middleware.throttle",
        "description": "throttle",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 423,
        "menu_id": 29,
        "name": "maps.menu.middleware.verified",
        "description": "verified",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 424,
        "menu_id": 29,
        "name": "maps.menu.middleware.log",
        "description": "log",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 425,
        "menu_id": 29,
        "name": "maps.menu.middleware.api_client",
        "description": "api_client",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 426,
        "menu_id": 29,
        "name": "maps.menu.middleware.auth.redirect",
        "description": "auth.redirect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 427,
        "menu_id": 29,
        "name": "maps.menu.middleware.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 428,
        "menu_id": 29,
        "name": "maps.menu.middleware.activated",
        "description": "activated",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 429,
        "menu_id": 29,
        "name": "maps.user",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 430,
        "menu_id": 29,
        "name": "maps.user.status",
        "description": "用户状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 431,
        "menu_id": 29,
        "name": "maps.user.status.0",
        "description": "注销",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 432,
        "menu_id": 29,
        "name": "maps.user.status.1",
        "description": "有效",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 433,
        "menu_id": 29,
        "name": "maps.user.status.2",
        "description": "停用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 434,
        "menu_id": 29,
        "name": "maps.menu_id",
        "description": "菜单ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 435,
        "menu_id": 29,
        "name": "maps.user_id",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 436,
        "menu_id": 29,
        "name": "mapsRelations.menu",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 437,
        "menu_id": 29,
        "name": "mapsRelations.user",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 438,
        "menu_id": 33,
        "name": "list.data.$index",
        "description": "后台用户对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 439,
        "menu_id": 33,
        "name": "list.data.$index.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 440,
        "menu_id": 33,
        "name": "list.data.$index.user_id",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 441,
        "menu_id": 33,
        "name": "list.data.$index.updated_at",
        "description": "修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 442,
        "menu_id": 33,
        "name": "list.data.$index.user",
        "description": "用户对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 443,
        "menu_id": 33,
        "name": "list.data.$index.user.id",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 444,
        "menu_id": 33,
        "name": "list.data.$index.user.uname",
        "description": "用户用户名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 445,
        "menu_id": 33,
        "name": "list.data.$index.user.name",
        "description": "用户姓名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 446,
        "menu_id": 33,
        "name": "list.data.$index.user.mobile_phone",
        "description": "用户手机号码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 447,
        "menu_id": 33,
        "name": "list.data.$index.user.status",
        "description": "用户状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 448,
        "menu_id": 33,
        "name": "list.data.$index.roles",
        "description": "角色对象集合",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 449,
        "menu_id": 33,
        "name": "list.data.$index.roles.$index",
        "description": "角色对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 450,
        "menu_id": 33,
        "name": "list.data.$index.roles.$index.id",
        "description": "角色ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 451,
        "menu_id": 33,
        "name": "list.data.$index.roles.$index.name",
        "description": "角色名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 452,
        "menu_id": 33,
        "name": "list.data.$index.roles.$index.pivot",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 453,
        "menu_id": 33,
        "name": "list.data.$index.roles.$index.pivot.admin_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 454,
        "menu_id": 33,
        "name": "list.data.$index.roles.$index.pivot.role_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 455,
        "menu_id": 33,
        "name": "list.data.$index.roles_name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 456,
        "menu_id": 33,
        "name": "options.where.roles.id",
        "description": "角色ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 457,
        "menu_id": 33,
        "name": "options.where.user.name|user.uname",
        "description": "用户姓名或用户用户名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 458,
        "menu_id": 33,
        "name": "options.where.roles.name",
        "description": "角色名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 459,
        "menu_id": 33,
        "name": "options.order.updated_at",
        "description": "修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 460,
        "menu_id": 33,
        "name": "options.order.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 461,
        "menu_id": 33,
        "name": "maps.user",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 462,
        "menu_id": 33,
        "name": "maps.user.status",
        "description": "用户状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 463,
        "menu_id": 33,
        "name": "maps.user.status.0",
        "description": "注销",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 464,
        "menu_id": 33,
        "name": "maps.user.status.1",
        "description": "有效",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 465,
        "menu_id": 33,
        "name": "maps.user.status.2",
        "description": "停用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 466,
        "menu_id": 33,
        "name": "maps.roles",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 467,
        "menu_id": 33,
        "name": "maps.roles.is_tmp",
        "description": "角色是否模板",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 468,
        "menu_id": 33,
        "name": "maps.roles.is_tmp.0",
        "description": "否",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 469,
        "menu_id": 33,
        "name": "maps.roles.is_tmp.1",
        "description": "是",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 470,
        "menu_id": 33,
        "name": "mapsRelations.user",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 471,
        "menu_id": 33,
        "name": "mapsRelations.roles",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 472,
        "menu_id": 33,
        "name": "keywordsMap.user.name|user.uname",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 473,
        "menu_id": 33,
        "name": "keywordsMap.roles.name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 474,
        "menu_id": 33,
        "name": "excel.exportFields.user.uname",
        "description": "用户用户名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 475,
        "menu_id": 33,
        "name": "excel.exportFields.user.name",
        "description": "用户姓名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 476,
        "menu_id": 33,
        "name": "excel.exportFields.user.avatar",
        "description": "用户头像",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 477,
        "menu_id": 33,
        "name": "excel.exportFields.user.email",
        "description": "用户电子邮箱",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 478,
        "menu_id": 33,
        "name": "excel.exportFields.user.mobile_phone",
        "description": "用户手机号码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 479,
        "menu_id": 33,
        "name": "excel.exportFields.user.status",
        "description": "用户状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 480,
        "menu_id": 33,
        "name": "excel.exportFields.user.description",
        "description": "用户备注",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 481,
        "menu_id": 33,
        "name": "excel.exportFields.user_id",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 482,
        "menu_id": 33,
        "name": "excel.exportFields.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 483,
        "menu_id": 34,
        "name": "data.$index",
        "description": "后台用户对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 484,
        "menu_id": 34,
        "name": "data.$index.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 485,
        "menu_id": 34,
        "name": "data.$index.user_id",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 486,
        "menu_id": 34,
        "name": "data.$index.updated_at",
        "description": "修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 487,
        "menu_id": 34,
        "name": "data.$index.user",
        "description": "用户对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 488,
        "menu_id": 34,
        "name": "data.$index.user.id",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 489,
        "menu_id": 34,
        "name": "data.$index.user.uname",
        "description": "用户用户名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 490,
        "menu_id": 34,
        "name": "data.$index.user.name",
        "description": "用户姓名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 491,
        "menu_id": 34,
        "name": "data.$index.user.mobile_phone",
        "description": "用户手机号码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 492,
        "menu_id": 34,
        "name": "data.$index.user.status",
        "description": "用户状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 493,
        "menu_id": 34,
        "name": "data.$index.roles",
        "description": "角色对象集合",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 494,
        "menu_id": 34,
        "name": "data.$index.roles.$index",
        "description": "角色对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 495,
        "menu_id": 34,
        "name": "data.$index.roles.$index.id",
        "description": "角色ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 496,
        "menu_id": 34,
        "name": "data.$index.roles.$index.name",
        "description": "角色名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 497,
        "menu_id": 34,
        "name": "data.$index.roles.$index.pivot",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 498,
        "menu_id": 34,
        "name": "data.$index.roles.$index.pivot.admin_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 499,
        "menu_id": 34,
        "name": "data.$index.roles.$index.pivot.role_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 500,
        "menu_id": 34,
        "name": "data.$index.roles_name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 501,
        "menu_id": 35,
        "name": "data.$index",
        "description": "后台用户对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 502,
        "menu_id": 35,
        "name": "data.$index.$index",
        "description": "excel数据项",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 503,
        "menu_id": 35,
        "name": "data.$index.0",
        "description": "用户名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 504,
        "menu_id": 35,
        "name": "data.$index.1",
        "description": "姓名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 505,
        "menu_id": 35,
        "name": "data.$index.2",
        "description": "头像",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 506,
        "menu_id": 35,
        "name": "data.$index.3",
        "description": "电子邮箱",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 507,
        "menu_id": 35,
        "name": "data.$index.4",
        "description": "手机号码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 508,
        "menu_id": 35,
        "name": "data.$index.5",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 509,
        "menu_id": 35,
        "name": "data.$index.6",
        "description": "备注",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 510,
        "menu_id": 35,
        "name": "data.$index.7",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 511,
        "menu_id": 35,
        "name": "data.$index.8",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 512,
        "menu_id": 37,
        "name": "row",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 513,
        "menu_id": 37,
        "name": "row.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 514,
        "menu_id": 37,
        "name": "row.user_id",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 515,
        "menu_id": 37,
        "name": "row.user",
        "description": "用户",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 516,
        "menu_id": 37,
        "name": "row.user.id",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 517,
        "menu_id": 37,
        "name": "row.user.uname",
        "description": "用户用户名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 518,
        "menu_id": 37,
        "name": "row.user.password",
        "description": "用户密码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 519,
        "menu_id": 37,
        "name": "row.user.name",
        "description": "用户姓名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 520,
        "menu_id": 37,
        "name": "row.user.email",
        "description": "用户电子邮箱",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 521,
        "menu_id": 37,
        "name": "row.user.mobile_phone",
        "description": "用户手机号码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 522,
        "menu_id": 37,
        "name": "row.user.status",
        "description": "用户状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 523,
        "menu_id": 37,
        "name": "row.user.description",
        "description": "用户备注",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 524,
        "menu_id": 37,
        "name": "row.user.avatar",
        "description": "用户头像",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 525,
        "menu_id": 37,
        "name": "row.roles",
        "description": "角色",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 526,
        "menu_id": 37,
        "name": "row.role_ids",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 527,
        "menu_id": 37,
        "name": "row.bind_user",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 528,
        "menu_id": 37,
        "name": "row.user_id_back",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 529,
        "menu_id": 37,
        "name": "maps.user",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 530,
        "menu_id": 37,
        "name": "maps.user.status",
        "description": "用户状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 531,
        "menu_id": 37,
        "name": "maps.user.status.0",
        "description": "注销",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 532,
        "menu_id": 37,
        "name": "maps.user.status.1",
        "description": "有效",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 533,
        "menu_id": 37,
        "name": "maps.user.status.2",
        "description": "停用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 534,
        "menu_id": 37,
        "name": "maps.roles",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 535,
        "menu_id": 37,
        "name": "maps.user_id",
        "description": "用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 536,
        "menu_id": 37,
        "name": "mapsRelations.user",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 537,
        "menu_id": 37,
        "name": "mapsRelations.roles",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 538,
        "menu_id": 41,
        "name": "list.data.$index",
        "description": "菜单对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 539,
        "menu_id": 41,
        "name": "list.data.$index.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 540,
        "menu_id": 41,
        "name": "list.data.$index.icons",
        "description": "图标",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 541,
        "menu_id": 41,
        "name": "list.data.$index.name",
        "description": "名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 542,
        "menu_id": 41,
        "name": "list.data.$index.url",
        "description": "URL路径",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 543,
        "menu_id": 41,
        "name": "list.data.$index.parent_id",
        "description": "父级ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 544,
        "menu_id": 41,
        "name": "list.data.$index.level",
        "description": "层级",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 545,
        "menu_id": 41,
        "name": "list.data.$index.method",
        "description": "菜单对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 546,
        "menu_id": 41,
        "name": "list.data.$index.is_page",
        "description": "是否为页面",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 547,
        "menu_id": 41,
        "name": "list.data.$index.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 548,
        "menu_id": 41,
        "name": "list.data.$index.created_at",
        "description": "创建时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 549,
        "menu_id": 41,
        "name": "list.data.$index.updated_at",
        "description": "修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 550,
        "menu_id": 41,
        "name": "list.data.$index.resource_id",
        "description": "所属资源ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 551,
        "menu_id": 41,
        "name": "list.data.$index.parent",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 552,
        "menu_id": 41,
        "name": "list.data.$index._trans_name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 553,
        "menu_id": 41,
        "name": "options.where.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 554,
        "menu_id": 41,
        "name": "options.where.is_page",
        "description": "是否为页面",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 555,
        "menu_id": 41,
        "name": "options.where.method",
        "description": "请求方式",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 556,
        "menu_id": 41,
        "name": "options.where.name",
        "description": "名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 557,
        "menu_id": 41,
        "name": "options.where.name|url",
        "description": "名称或URL路径",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 558,
        "menu_id": 41,
        "name": "options.where.resource_id",
        "description": "所属资源ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 559,
        "menu_id": 41,
        "name": "options.order.left_margin",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 560,
        "menu_id": 41,
        "name": "options.order.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 561,
        "menu_id": 41,
        "name": "maps.method",
        "description": "请求方式",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 562,
        "menu_id": 41,
        "name": "maps.method.1",
        "description": "get",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 563,
        "menu_id": 41,
        "name": "maps.method.2",
        "description": "post",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 564,
        "menu_id": 41,
        "name": "maps.method.4",
        "description": "put",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 565,
        "menu_id": 41,
        "name": "maps.method.8",
        "description": "delete",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 566,
        "menu_id": 41,
        "name": "maps.method.16",
        "description": "head",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 567,
        "menu_id": 41,
        "name": "maps.method.32",
        "description": "options",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 568,
        "menu_id": 41,
        "name": "maps.method.64",
        "description": "trace",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 569,
        "menu_id": 41,
        "name": "maps.method.128",
        "description": "connect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 570,
        "menu_id": 41,
        "name": "maps.method.256",
        "description": "patch",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 571,
        "menu_id": 41,
        "name": "maps.is_page",
        "description": "是否为页面",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 572,
        "menu_id": 41,
        "name": "maps.is_page.0",
        "description": "否",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 573,
        "menu_id": 41,
        "name": "maps.is_page.1",
        "description": "是",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 574,
        "menu_id": 41,
        "name": "maps.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 575,
        "menu_id": 41,
        "name": "maps.status.1",
        "description": "显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 576,
        "menu_id": 41,
        "name": "maps.status.2",
        "description": "不显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 577,
        "menu_id": 41,
        "name": "maps.disabled",
        "description": "功能状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 578,
        "menu_id": 41,
        "name": "maps.disabled.0",
        "description": "启用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 579,
        "menu_id": 41,
        "name": "maps.disabled.1",
        "description": "禁用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 580,
        "menu_id": 41,
        "name": "maps.use",
        "description": "路由使用地方",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 581,
        "menu_id": 41,
        "name": "maps.use.1",
        "description": "api",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 582,
        "menu_id": 41,
        "name": "maps.use.2",
        "description": "web",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 583,
        "menu_id": 41,
        "name": "maps.env",
        "description": "使用环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 584,
        "menu_id": 41,
        "name": "maps.env.local",
        "description": "开发环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 585,
        "menu_id": 41,
        "name": "maps.env.testing",
        "description": "测试环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 586,
        "menu_id": 41,
        "name": "maps.env.staging",
        "description": "预上线环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 587,
        "menu_id": 41,
        "name": "maps.env.production",
        "description": "正式环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 588,
        "menu_id": 41,
        "name": "maps.group",
        "description": "所属组",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 589,
        "menu_id": 41,
        "name": "maps.group.none",
        "description": "none",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 590,
        "menu_id": 41,
        "name": "maps.group.open",
        "description": "open",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 591,
        "menu_id": 41,
        "name": "maps.group.home",
        "description": "home",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 592,
        "menu_id": 41,
        "name": "maps.group.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 593,
        "menu_id": 41,
        "name": "maps.middleware",
        "description": "单独使用中间件",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 594,
        "menu_id": 41,
        "name": "maps.middleware.auth",
        "description": "auth",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 595,
        "menu_id": 41,
        "name": "maps.middleware.auth.basic",
        "description": "auth.basic",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 596,
        "menu_id": 41,
        "name": "maps.middleware.bindings",
        "description": "bindings",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 597,
        "menu_id": 41,
        "name": "maps.middleware.cache.headers",
        "description": "cache.headers",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 598,
        "menu_id": 41,
        "name": "maps.middleware.can",
        "description": "can",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 599,
        "menu_id": 41,
        "name": "maps.middleware.guest",
        "description": "guest",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 600,
        "menu_id": 41,
        "name": "maps.middleware.password.confirm",
        "description": "password.confirm",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 601,
        "menu_id": 41,
        "name": "maps.middleware.signed",
        "description": "signed",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 602,
        "menu_id": 41,
        "name": "maps.middleware.throttle",
        "description": "throttle",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 603,
        "menu_id": 41,
        "name": "maps.middleware.verified",
        "description": "verified",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 604,
        "menu_id": 41,
        "name": "maps.middleware.log",
        "description": "log",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 605,
        "menu_id": 41,
        "name": "maps.middleware.api_client",
        "description": "api_client",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 606,
        "menu_id": 41,
        "name": "maps.middleware.auth.redirect",
        "description": "auth.redirect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 607,
        "menu_id": 41,
        "name": "maps.middleware.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 608,
        "menu_id": 41,
        "name": "maps.middleware.activated",
        "description": "activated",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 609,
        "menu_id": 41,
        "name": "maps.parent",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 610,
        "menu_id": 41,
        "name": "maps.parent.method",
        "description": "菜单请求方式",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 611,
        "menu_id": 41,
        "name": "maps.parent.method.1",
        "description": "get",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 612,
        "menu_id": 41,
        "name": "maps.parent.method.2",
        "description": "post",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 613,
        "menu_id": 41,
        "name": "maps.parent.method.4",
        "description": "put",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 614,
        "menu_id": 41,
        "name": "maps.parent.method.8",
        "description": "delete",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 615,
        "menu_id": 41,
        "name": "maps.parent.method.16",
        "description": "head",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 616,
        "menu_id": 41,
        "name": "maps.parent.method.32",
        "description": "options",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 617,
        "menu_id": 41,
        "name": "maps.parent.method.64",
        "description": "trace",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 618,
        "menu_id": 41,
        "name": "maps.parent.method.128",
        "description": "connect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 619,
        "menu_id": 41,
        "name": "maps.parent.method.256",
        "description": "patch",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 620,
        "menu_id": 41,
        "name": "maps.parent.is_page",
        "description": "菜单是否为页面",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 621,
        "menu_id": 41,
        "name": "maps.parent.is_page.0",
        "description": "否",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 622,
        "menu_id": 41,
        "name": "maps.parent.is_page.1",
        "description": "是",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 623,
        "menu_id": 41,
        "name": "maps.parent.status",
        "description": "菜单状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 624,
        "menu_id": 41,
        "name": "maps.parent.status.1",
        "description": "显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 625,
        "menu_id": 41,
        "name": "maps.parent.status.2",
        "description": "不显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 626,
        "menu_id": 41,
        "name": "maps.parent.disabled",
        "description": "菜单功能状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 627,
        "menu_id": 41,
        "name": "maps.parent.disabled.0",
        "description": "启用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 628,
        "menu_id": 41,
        "name": "maps.parent.disabled.1",
        "description": "禁用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 629,
        "menu_id": 41,
        "name": "maps.parent.use",
        "description": "菜单路由使用地方",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 630,
        "menu_id": 41,
        "name": "maps.parent.use.1",
        "description": "api",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 631,
        "menu_id": 41,
        "name": "maps.parent.use.2",
        "description": "web",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 632,
        "menu_id": 41,
        "name": "maps.parent.env",
        "description": "菜单使用环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 633,
        "menu_id": 41,
        "name": "maps.parent.env.local",
        "description": "开发环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 634,
        "menu_id": 41,
        "name": "maps.parent.env.testing",
        "description": "测试环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 635,
        "menu_id": 41,
        "name": "maps.parent.env.staging",
        "description": "预上线环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 636,
        "menu_id": 41,
        "name": "maps.parent.env.production",
        "description": "正式环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 637,
        "menu_id": 41,
        "name": "maps.parent.group",
        "description": "菜单所属组",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 638,
        "menu_id": 41,
        "name": "maps.parent.group.none",
        "description": "none",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 639,
        "menu_id": 41,
        "name": "maps.parent.group.open",
        "description": "open",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 640,
        "menu_id": 41,
        "name": "maps.parent.group.home",
        "description": "home",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 641,
        "menu_id": 41,
        "name": "maps.parent.group.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 642,
        "menu_id": 41,
        "name": "maps.parent.middleware",
        "description": "菜单单独使用中间件",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 643,
        "menu_id": 41,
        "name": "maps.parent.middleware.auth",
        "description": "auth",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 644,
        "menu_id": 41,
        "name": "maps.parent.middleware.auth.basic",
        "description": "auth.basic",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 645,
        "menu_id": 41,
        "name": "maps.parent.middleware.bindings",
        "description": "bindings",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 646,
        "menu_id": 41,
        "name": "maps.parent.middleware.cache.headers",
        "description": "cache.headers",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 647,
        "menu_id": 41,
        "name": "maps.parent.middleware.can",
        "description": "can",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 648,
        "menu_id": 41,
        "name": "maps.parent.middleware.guest",
        "description": "guest",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 649,
        "menu_id": 41,
        "name": "maps.parent.middleware.password.confirm",
        "description": "password.confirm",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 650,
        "menu_id": 41,
        "name": "maps.parent.middleware.signed",
        "description": "signed",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 651,
        "menu_id": 41,
        "name": "maps.parent.middleware.throttle",
        "description": "throttle",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 652,
        "menu_id": 41,
        "name": "maps.parent.middleware.verified",
        "description": "verified",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 653,
        "menu_id": 41,
        "name": "maps.parent.middleware.log",
        "description": "log",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 654,
        "menu_id": 41,
        "name": "maps.parent.middleware.api_client",
        "description": "api_client",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 655,
        "menu_id": 41,
        "name": "maps.parent.middleware.auth.redirect",
        "description": "auth.redirect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 656,
        "menu_id": 41,
        "name": "maps.parent.middleware.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 657,
        "menu_id": 41,
        "name": "maps.parent.middleware.activated",
        "description": "activated",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 658,
        "menu_id": 41,
        "name": "maps.resource_id",
        "description": "所属资源ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 659,
        "menu_id": 41,
        "name": "mapsRelations.parent",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 660,
        "menu_id": 41,
        "name": "excel.exportFields.name",
        "description": "名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 661,
        "menu_id": 41,
        "name": "excel.exportFields.icons",
        "description": "图标",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 662,
        "menu_id": 41,
        "name": "excel.exportFields.description",
        "description": "描述",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 663,
        "menu_id": 41,
        "name": "excel.exportFields.url",
        "description": "URL路径",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 664,
        "menu_id": 41,
        "name": "excel.exportFields.parent.name",
        "description": "菜单父级名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 665,
        "menu_id": 41,
        "name": "excel.exportFields.method",
        "description": "请求方式",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 666,
        "menu_id": 41,
        "name": "excel.exportFields.is_page",
        "description": "是否为页面",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 667,
        "menu_id": 41,
        "name": "excel.exportFields.disabled",
        "description": "功能状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 668,
        "menu_id": 41,
        "name": "excel.exportFields.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 669,
        "menu_id": 41,
        "name": "excel.exportFields.level",
        "description": "层级",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 670,
        "menu_id": 41,
        "name": "excel.exportFields.parent_id",
        "description": "父级ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 671,
        "menu_id": 41,
        "name": "excel.exportFields.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 672,
        "menu_id": 42,
        "name": "data.$index",
        "description": "菜单对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 673,
        "menu_id": 42,
        "name": "data.$index.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 674,
        "menu_id": 42,
        "name": "data.$index.icons",
        "description": "图标",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 675,
        "menu_id": 42,
        "name": "data.$index.name",
        "description": "名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 676,
        "menu_id": 42,
        "name": "data.$index.url",
        "description": "URL路径",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 677,
        "menu_id": 42,
        "name": "data.$index.parent_id",
        "description": "父级ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 678,
        "menu_id": 42,
        "name": "data.$index.level",
        "description": "层级",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 679,
        "menu_id": 42,
        "name": "data.$index.method",
        "description": "菜单对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 680,
        "menu_id": 42,
        "name": "data.$index.is_page",
        "description": "是否为页面",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 681,
        "menu_id": 42,
        "name": "data.$index.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 682,
        "menu_id": 42,
        "name": "data.$index.created_at",
        "description": "创建时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 683,
        "menu_id": 42,
        "name": "data.$index.updated_at",
        "description": "修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 684,
        "menu_id": 42,
        "name": "data.$index.resource_id",
        "description": "所属资源ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 685,
        "menu_id": 42,
        "name": "data.$index.parent",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 686,
        "menu_id": 42,
        "name": "data.$index._trans_name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 687,
        "menu_id": 43,
        "name": "data.$index",
        "description": "菜单对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 688,
        "menu_id": 43,
        "name": "data.$index.$index",
        "description": "excel数据项",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 689,
        "menu_id": 43,
        "name": "data.$index.0",
        "description": "名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 690,
        "menu_id": 43,
        "name": "data.$index.1",
        "description": "图标",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 691,
        "menu_id": 43,
        "name": "data.$index.2",
        "description": "描述",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 692,
        "menu_id": 43,
        "name": "data.$index.3",
        "description": "URL路径",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 693,
        "menu_id": 43,
        "name": "data.$index.4",
        "description": "父级名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 694,
        "menu_id": 43,
        "name": "data.$index.5",
        "description": "请求方式",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 695,
        "menu_id": 43,
        "name": "data.$index.6",
        "description": "是否为页面",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 696,
        "menu_id": 43,
        "name": "data.$index.7",
        "description": "功能状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 697,
        "menu_id": 43,
        "name": "data.$index.8",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 698,
        "menu_id": 43,
        "name": "data.$index.9",
        "description": "层级",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 699,
        "menu_id": 43,
        "name": "data.$index.10",
        "description": "父级ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 700,
        "menu_id": 43,
        "name": "data.$index.11",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 701,
        "menu_id": 45,
        "name": "row",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 702,
        "menu_id": 45,
        "name": "row.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 703,
        "menu_id": 45,
        "name": "row.name",
        "description": "名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 704,
        "menu_id": 45,
        "name": "row.disabled",
        "description": "功能状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 705,
        "menu_id": 45,
        "name": "row.icons",
        "description": "图标",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 706,
        "menu_id": 45,
        "name": "row.description",
        "description": "描述",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 707,
        "menu_id": 45,
        "name": "row.url",
        "description": "URL路径",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 708,
        "menu_id": 45,
        "name": "row.parent_id",
        "description": "父级ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 709,
        "menu_id": 45,
        "name": "row.method",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 710,
        "menu_id": 45,
        "name": "row.is_page",
        "description": "是否为页面",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 711,
        "menu_id": 45,
        "name": "row.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 712,
        "menu_id": 45,
        "name": "row.resource_id",
        "description": "所属资源ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 713,
        "menu_id": 45,
        "name": "row.group",
        "description": "所属组",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 714,
        "menu_id": 45,
        "name": "row.action",
        "description": "绑定控制器方法",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 715,
        "menu_id": 45,
        "name": "row.env",
        "description": "使用环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 716,
        "menu_id": 45,
        "name": "row.plug_in_key",
        "description": "插件菜单唯一标识",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 717,
        "menu_id": 45,
        "name": "row.use",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 718,
        "menu_id": 45,
        "name": "row.as",
        "description": "路由别名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 719,
        "menu_id": 45,
        "name": "row.middleware",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 720,
        "menu_id": 45,
        "name": "row.item_name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 721,
        "menu_id": 45,
        "name": "row.resource",
        "description": "菜单",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 722,
        "menu_id": 45,
        "name": "row.resource.id",
        "description": "菜单ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 723,
        "menu_id": 45,
        "name": "row.resource.name",
        "description": "菜单名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 724,
        "menu_id": 45,
        "name": "row.resources",
        "description": "菜单",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 725,
        "menu_id": 45,
        "name": "row.resource_ids",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 726,
        "menu_id": 45,
        "name": "row._type",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 727,
        "menu_id": 45,
        "name": "row._options",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 728,
        "menu_id": 45,
        "name": "maps.method",
        "description": "请求方式",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 729,
        "menu_id": 45,
        "name": "maps.method.1",
        "description": "get",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 730,
        "menu_id": 45,
        "name": "maps.method.2",
        "description": "post",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 731,
        "menu_id": 45,
        "name": "maps.method.4",
        "description": "put",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 732,
        "menu_id": 45,
        "name": "maps.method.8",
        "description": "delete",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 733,
        "menu_id": 45,
        "name": "maps.method.16",
        "description": "head",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 734,
        "menu_id": 45,
        "name": "maps.method.32",
        "description": "options",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 735,
        "menu_id": 45,
        "name": "maps.method.64",
        "description": "trace",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 736,
        "menu_id": 45,
        "name": "maps.method.128",
        "description": "connect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 737,
        "menu_id": 45,
        "name": "maps.method.256",
        "description": "patch",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 738,
        "menu_id": 45,
        "name": "maps.is_page",
        "description": "是否为页面",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 739,
        "menu_id": 45,
        "name": "maps.is_page.0",
        "description": "否",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 740,
        "menu_id": 45,
        "name": "maps.is_page.1",
        "description": "是",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 741,
        "menu_id": 45,
        "name": "maps.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 742,
        "menu_id": 45,
        "name": "maps.status.1",
        "description": "显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 743,
        "menu_id": 45,
        "name": "maps.status.2",
        "description": "不显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 744,
        "menu_id": 45,
        "name": "maps.disabled",
        "description": "功能状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 745,
        "menu_id": 45,
        "name": "maps.disabled.0",
        "description": "启用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 746,
        "menu_id": 45,
        "name": "maps.disabled.1",
        "description": "禁用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 747,
        "menu_id": 45,
        "name": "maps.use",
        "description": "路由使用地方",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 748,
        "menu_id": 45,
        "name": "maps.use.1",
        "description": "api",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 749,
        "menu_id": 45,
        "name": "maps.use.2",
        "description": "web",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 750,
        "menu_id": 45,
        "name": "maps.env",
        "description": "使用环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 751,
        "menu_id": 45,
        "name": "maps.env.local",
        "description": "开发环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 752,
        "menu_id": 45,
        "name": "maps.env.testing",
        "description": "测试环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 753,
        "menu_id": 45,
        "name": "maps.env.staging",
        "description": "预上线环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 754,
        "menu_id": 45,
        "name": "maps.env.production",
        "description": "正式环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 755,
        "menu_id": 45,
        "name": "maps.group",
        "description": "所属组",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 756,
        "menu_id": 45,
        "name": "maps.group.none",
        "description": "none",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 757,
        "menu_id": 45,
        "name": "maps.group.open",
        "description": "open",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 758,
        "menu_id": 45,
        "name": "maps.group.home",
        "description": "home",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 759,
        "menu_id": 45,
        "name": "maps.group.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 760,
        "menu_id": 45,
        "name": "maps.middleware",
        "description": "单独使用中间件",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 761,
        "menu_id": 45,
        "name": "maps.middleware.auth",
        "description": "auth",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 762,
        "menu_id": 45,
        "name": "maps.middleware.auth.basic",
        "description": "auth.basic",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 763,
        "menu_id": 45,
        "name": "maps.middleware.bindings",
        "description": "bindings",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 764,
        "menu_id": 45,
        "name": "maps.middleware.cache.headers",
        "description": "cache.headers",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 765,
        "menu_id": 45,
        "name": "maps.middleware.can",
        "description": "can",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 766,
        "menu_id": 45,
        "name": "maps.middleware.guest",
        "description": "guest",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 767,
        "menu_id": 45,
        "name": "maps.middleware.password.confirm",
        "description": "password.confirm",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 768,
        "menu_id": 45,
        "name": "maps.middleware.signed",
        "description": "signed",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 769,
        "menu_id": 45,
        "name": "maps.middleware.throttle",
        "description": "throttle",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 770,
        "menu_id": 45,
        "name": "maps.middleware.verified",
        "description": "verified",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 771,
        "menu_id": 45,
        "name": "maps.middleware.log",
        "description": "log",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 772,
        "menu_id": 45,
        "name": "maps.middleware.api_client",
        "description": "api_client",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 773,
        "menu_id": 45,
        "name": "maps.middleware.auth.redirect",
        "description": "auth.redirect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 774,
        "menu_id": 45,
        "name": "maps.middleware.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 775,
        "menu_id": 45,
        "name": "maps.middleware.activated",
        "description": "activated",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 776,
        "menu_id": 45,
        "name": "maps.resource",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 777,
        "menu_id": 45,
        "name": "maps.resource.method",
        "description": "菜单请求方式",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 778,
        "menu_id": 45,
        "name": "maps.resource.method.1",
        "description": "get",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 779,
        "menu_id": 45,
        "name": "maps.resource.method.2",
        "description": "post",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 780,
        "menu_id": 45,
        "name": "maps.resource.method.4",
        "description": "put",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 781,
        "menu_id": 45,
        "name": "maps.resource.method.8",
        "description": "delete",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 782,
        "menu_id": 45,
        "name": "maps.resource.method.16",
        "description": "head",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 783,
        "menu_id": 45,
        "name": "maps.resource.method.32",
        "description": "options",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 784,
        "menu_id": 45,
        "name": "maps.resource.method.64",
        "description": "trace",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 785,
        "menu_id": 45,
        "name": "maps.resource.method.128",
        "description": "connect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 786,
        "menu_id": 45,
        "name": "maps.resource.method.256",
        "description": "patch",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 787,
        "menu_id": 45,
        "name": "maps.resource.is_page",
        "description": "菜单是否为页面",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 788,
        "menu_id": 45,
        "name": "maps.resource.is_page.0",
        "description": "否",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 789,
        "menu_id": 45,
        "name": "maps.resource.is_page.1",
        "description": "是",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 790,
        "menu_id": 45,
        "name": "maps.resource.status",
        "description": "菜单状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 791,
        "menu_id": 45,
        "name": "maps.resource.status.1",
        "description": "显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 792,
        "menu_id": 45,
        "name": "maps.resource.status.2",
        "description": "不显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 793,
        "menu_id": 45,
        "name": "maps.resource.disabled",
        "description": "菜单功能状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 794,
        "menu_id": 45,
        "name": "maps.resource.disabled.0",
        "description": "启用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 795,
        "menu_id": 45,
        "name": "maps.resource.disabled.1",
        "description": "禁用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 796,
        "menu_id": 45,
        "name": "maps.resource.use",
        "description": "菜单路由使用地方",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 797,
        "menu_id": 45,
        "name": "maps.resource.use.1",
        "description": "api",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 798,
        "menu_id": 45,
        "name": "maps.resource.use.2",
        "description": "web",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 799,
        "menu_id": 45,
        "name": "maps.resource.env",
        "description": "菜单使用环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 800,
        "menu_id": 45,
        "name": "maps.resource.env.local",
        "description": "开发环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 801,
        "menu_id": 45,
        "name": "maps.resource.env.testing",
        "description": "测试环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 802,
        "menu_id": 45,
        "name": "maps.resource.env.staging",
        "description": "预上线环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 803,
        "menu_id": 45,
        "name": "maps.resource.env.production",
        "description": "正式环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 804,
        "menu_id": 45,
        "name": "maps.resource.group",
        "description": "菜单所属组",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 805,
        "menu_id": 45,
        "name": "maps.resource.group.none",
        "description": "none",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 806,
        "menu_id": 45,
        "name": "maps.resource.group.open",
        "description": "open",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 807,
        "menu_id": 45,
        "name": "maps.resource.group.home",
        "description": "home",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 808,
        "menu_id": 45,
        "name": "maps.resource.group.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 809,
        "menu_id": 45,
        "name": "maps.resource.middleware",
        "description": "菜单单独使用中间件",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 810,
        "menu_id": 45,
        "name": "maps.resource.middleware.auth",
        "description": "auth",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 811,
        "menu_id": 45,
        "name": "maps.resource.middleware.auth.basic",
        "description": "auth.basic",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 812,
        "menu_id": 45,
        "name": "maps.resource.middleware.bindings",
        "description": "bindings",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 813,
        "menu_id": 45,
        "name": "maps.resource.middleware.cache.headers",
        "description": "cache.headers",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 814,
        "menu_id": 45,
        "name": "maps.resource.middleware.can",
        "description": "can",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 815,
        "menu_id": 45,
        "name": "maps.resource.middleware.guest",
        "description": "guest",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 816,
        "menu_id": 45,
        "name": "maps.resource.middleware.password.confirm",
        "description": "password.confirm",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 817,
        "menu_id": 45,
        "name": "maps.resource.middleware.signed",
        "description": "signed",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 818,
        "menu_id": 45,
        "name": "maps.resource.middleware.throttle",
        "description": "throttle",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 819,
        "menu_id": 45,
        "name": "maps.resource.middleware.verified",
        "description": "verified",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 820,
        "menu_id": 45,
        "name": "maps.resource.middleware.log",
        "description": "log",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 821,
        "menu_id": 45,
        "name": "maps.resource.middleware.api_client",
        "description": "api_client",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 822,
        "menu_id": 45,
        "name": "maps.resource.middleware.auth.redirect",
        "description": "auth.redirect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 823,
        "menu_id": 45,
        "name": "maps.resource.middleware.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 824,
        "menu_id": 45,
        "name": "maps.resource.middleware.activated",
        "description": "activated",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 825,
        "menu_id": 45,
        "name": "maps.resources",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 826,
        "menu_id": 45,
        "name": "maps.resources.method",
        "description": "菜单请求方式",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 827,
        "menu_id": 45,
        "name": "maps.resources.method.1",
        "description": "get",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 828,
        "menu_id": 45,
        "name": "maps.resources.method.2",
        "description": "post",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 829,
        "menu_id": 45,
        "name": "maps.resources.method.4",
        "description": "put",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 830,
        "menu_id": 45,
        "name": "maps.resources.method.8",
        "description": "delete",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 831,
        "menu_id": 45,
        "name": "maps.resources.method.16",
        "description": "head",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 832,
        "menu_id": 45,
        "name": "maps.resources.method.32",
        "description": "options",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 833,
        "menu_id": 45,
        "name": "maps.resources.method.64",
        "description": "trace",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 834,
        "menu_id": 45,
        "name": "maps.resources.method.128",
        "description": "connect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 835,
        "menu_id": 45,
        "name": "maps.resources.method.256",
        "description": "patch",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 836,
        "menu_id": 45,
        "name": "maps.resources.is_page",
        "description": "菜单是否为页面",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 837,
        "menu_id": 45,
        "name": "maps.resources.is_page.0",
        "description": "否",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 838,
        "menu_id": 45,
        "name": "maps.resources.is_page.1",
        "description": "是",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 839,
        "menu_id": 45,
        "name": "maps.resources.status",
        "description": "菜单状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 840,
        "menu_id": 45,
        "name": "maps.resources.status.1",
        "description": "显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 841,
        "menu_id": 45,
        "name": "maps.resources.status.2",
        "description": "不显示",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 842,
        "menu_id": 45,
        "name": "maps.resources.disabled",
        "description": "菜单功能状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 843,
        "menu_id": 45,
        "name": "maps.resources.disabled.0",
        "description": "启用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 844,
        "menu_id": 45,
        "name": "maps.resources.disabled.1",
        "description": "禁用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 845,
        "menu_id": 45,
        "name": "maps.resources.use",
        "description": "菜单路由使用地方",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 846,
        "menu_id": 45,
        "name": "maps.resources.use.1",
        "description": "api",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 847,
        "menu_id": 45,
        "name": "maps.resources.use.2",
        "description": "web",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 848,
        "menu_id": 45,
        "name": "maps.resources.env",
        "description": "菜单使用环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 849,
        "menu_id": 45,
        "name": "maps.resources.env.local",
        "description": "开发环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 850,
        "menu_id": 45,
        "name": "maps.resources.env.testing",
        "description": "测试环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 851,
        "menu_id": 45,
        "name": "maps.resources.env.staging",
        "description": "预上线环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 852,
        "menu_id": 45,
        "name": "maps.resources.env.production",
        "description": "正式环境",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 853,
        "menu_id": 45,
        "name": "maps.resources.group",
        "description": "菜单所属组",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 854,
        "menu_id": 45,
        "name": "maps.resources.group.none",
        "description": "none",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 855,
        "menu_id": 45,
        "name": "maps.resources.group.open",
        "description": "open",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 856,
        "menu_id": 45,
        "name": "maps.resources.group.home",
        "description": "home",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 857,
        "menu_id": 45,
        "name": "maps.resources.group.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 858,
        "menu_id": 45,
        "name": "maps.resources.middleware",
        "description": "菜单单独使用中间件",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 859,
        "menu_id": 45,
        "name": "maps.resources.middleware.auth",
        "description": "auth",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 860,
        "menu_id": 45,
        "name": "maps.resources.middleware.auth.basic",
        "description": "auth.basic",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 861,
        "menu_id": 45,
        "name": "maps.resources.middleware.bindings",
        "description": "bindings",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 862,
        "menu_id": 45,
        "name": "maps.resources.middleware.cache.headers",
        "description": "cache.headers",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 863,
        "menu_id": 45,
        "name": "maps.resources.middleware.can",
        "description": "can",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 864,
        "menu_id": 45,
        "name": "maps.resources.middleware.guest",
        "description": "guest",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 865,
        "menu_id": 45,
        "name": "maps.resources.middleware.password.confirm",
        "description": "password.confirm",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 866,
        "menu_id": 45,
        "name": "maps.resources.middleware.signed",
        "description": "signed",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 867,
        "menu_id": 45,
        "name": "maps.resources.middleware.throttle",
        "description": "throttle",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 868,
        "menu_id": 45,
        "name": "maps.resources.middleware.verified",
        "description": "verified",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 869,
        "menu_id": 45,
        "name": "maps.resources.middleware.log",
        "description": "log",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 870,
        "menu_id": 45,
        "name": "maps.resources.middleware.api_client",
        "description": "api_client",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 871,
        "menu_id": 45,
        "name": "maps.resources.middleware.auth.redirect",
        "description": "auth.redirect",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 872,
        "menu_id": 45,
        "name": "maps.resources.middleware.admin",
        "description": "admin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 873,
        "menu_id": 45,
        "name": "maps.resources.middleware.activated",
        "description": "activated",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 874,
        "menu_id": 45,
        "name": "maps.resource_id",
        "description": "所属资源ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 875,
        "menu_id": 45,
        "name": "maps._options_name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 876,
        "menu_id": 45,
        "name": "maps.optional_parents",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 877,
        "menu_id": 45,
        "name": "maps._type",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 878,
        "menu_id": 45,
        "name": "maps._type.0",
        "description": "普通链接",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 879,
        "menu_id": 45,
        "name": "maps._type.1",
        "description": "资源",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 880,
        "menu_id": 45,
        "name": "maps._type.2",
        "description": "单独路由",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 881,
        "menu_id": 45,
        "name": "maps._options",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 882,
        "menu_id": 45,
        "name": "maps._options.0",
        "description": "_list",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 883,
        "menu_id": 45,
        "name": "maps._options.1",
        "description": "_export",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 884,
        "menu_id": 45,
        "name": "maps._options.2",
        "description": "_import",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 885,
        "menu_id": 45,
        "name": "maps._options.3",
        "description": "_show",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 886,
        "menu_id": 45,
        "name": "maps._options.4",
        "description": "_create",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 887,
        "menu_id": 45,
        "name": "maps._options.5",
        "description": "_update",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 888,
        "menu_id": 45,
        "name": "maps._options.6",
        "description": "_delete",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 889,
        "menu_id": 45,
        "name": "mapsRelations.resource",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 890,
        "menu_id": 45,
        "name": "mapsRelations.resources",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 891,
        "menu_id": 49,
        "name": "list.data.$index",
        "description": "系统设置对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 892,
        "menu_id": 49,
        "name": "list.data.$index.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 893,
        "menu_id": 49,
        "name": "list.data.$index.name",
        "description": "名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 894,
        "menu_id": 49,
        "name": "list.data.$index.description",
        "description": "描述",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 895,
        "menu_id": 49,
        "name": "list.data.$index.key",
        "description": "键名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 896,
        "menu_id": 49,
        "name": "list.data.$index.value",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 897,
        "menu_id": 49,
        "name": "list.data.$index.updated_at",
        "description": "修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 898,
        "menu_id": 49,
        "name": "options.where.name|key",
        "description": "名称或键名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 899,
        "menu_id": 49,
        "name": "options.order.updated_at",
        "description": "修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 900,
        "menu_id": 49,
        "name": "options.order.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 901,
        "menu_id": 49,
        "name": "maps.type",
        "description": "类型",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 902,
        "menu_id": 49,
        "name": "maps.type.1",
        "description": "字符串",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 903,
        "menu_id": 49,
        "name": "maps.type.2",
        "description": "json",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 904,
        "menu_id": 49,
        "name": "maps.type.3",
        "description": "数字",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 905,
        "menu_id": 49,
        "name": "maps.itype",
        "description": "输入框类型",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 906,
        "menu_id": 49,
        "name": "maps.itype.1",
        "description": "input",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 907,
        "menu_id": 49,
        "name": "maps.itype.2",
        "description": "textarea",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 908,
        "menu_id": 49,
        "name": "maps.itype.3",
        "description": "markdown",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 909,
        "menu_id": 49,
        "name": "maps.itype.4",
        "description": "json",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 910,
        "menu_id": 49,
        "name": "maps.itype.5",
        "description": "switch",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 911,
        "menu_id": 49,
        "name": "excel.exportFields.type",
        "description": "类型",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 912,
        "menu_id": 49,
        "name": "excel.exportFields.name",
        "description": "名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 913,
        "menu_id": 49,
        "name": "excel.exportFields.key",
        "description": "键名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 914,
        "menu_id": 49,
        "name": "excel.exportFields.itype",
        "description": "输入框类型",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 915,
        "menu_id": 49,
        "name": "excel.exportFields.options",
        "description": "组件属性",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 916,
        "menu_id": 49,
        "name": "excel.exportFields.description",
        "description": "描述",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 917,
        "menu_id": 49,
        "name": "excel.exportFields.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 918,
        "menu_id": 50,
        "name": "data.$index",
        "description": "系统设置对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 919,
        "menu_id": 50,
        "name": "data.$index.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 920,
        "menu_id": 50,
        "name": "data.$index.name",
        "description": "名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 921,
        "menu_id": 50,
        "name": "data.$index.description",
        "description": "描述",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 922,
        "menu_id": 50,
        "name": "data.$index.key",
        "description": "键名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 923,
        "menu_id": 50,
        "name": "data.$index.value",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 924,
        "menu_id": 50,
        "name": "data.$index.updated_at",
        "description": "修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 925,
        "menu_id": 51,
        "name": "data.$index",
        "description": "系统设置对象",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 926,
        "menu_id": 51,
        "name": "data.$index.$index",
        "description": "excel数据项",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 927,
        "menu_id": 51,
        "name": "data.$index.0",
        "description": "名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 928,
        "menu_id": 51,
        "name": "data.$index.1",
        "description": "描述",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 929,
        "menu_id": 51,
        "name": "data.$index.2",
        "description": "键名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 930,
        "menu_id": 51,
        "name": "data.$index.3",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 931,
        "menu_id": 51,
        "name": "data.$index.4",
        "description": "类型",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 932,
        "menu_id": 51,
        "name": "data.$index.5",
        "description": "输入框类型",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 933,
        "menu_id": 51,
        "name": "data.$index.6",
        "description": "组件属性",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 934,
        "menu_id": 51,
        "name": "data.$index.7",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 935,
        "menu_id": 53,
        "name": "row",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 936,
        "menu_id": 53,
        "name": "row.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 937,
        "menu_id": 53,
        "name": "row.name",
        "description": "名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 938,
        "menu_id": 53,
        "name": "row.description",
        "description": "描述",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 939,
        "menu_id": 53,
        "name": "row.key",
        "description": "键名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 940,
        "menu_id": 53,
        "name": "row.value",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 941,
        "menu_id": 53,
        "name": "row.type",
        "description": "类型",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 942,
        "menu_id": 53,
        "name": "row.itype",
        "description": "输入框类型",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 943,
        "menu_id": 53,
        "name": "row.options",
        "description": "组件属性",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 944,
        "menu_id": 53,
        "name": "maps.type",
        "description": "类型",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 945,
        "menu_id": 53,
        "name": "maps.type.1",
        "description": "字符串",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 946,
        "menu_id": 53,
        "name": "maps.type.2",
        "description": "json",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 947,
        "menu_id": 53,
        "name": "maps.type.3",
        "description": "数字",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 948,
        "menu_id": 53,
        "name": "maps.itype",
        "description": "输入框类型",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 949,
        "menu_id": 53,
        "name": "maps.itype.1",
        "description": "input",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 950,
        "menu_id": 53,
        "name": "maps.itype.2",
        "description": "textarea",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 951,
        "menu_id": 53,
        "name": "maps.itype.3",
        "description": "markdown",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 952,
        "menu_id": 53,
        "name": "maps.itype.4",
        "description": "json",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 953,
        "menu_id": 53,
        "name": "maps.itype.5",
        "description": "switch",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 954,
        "menu_id": 57,
        "name": "row",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 955,
        "menu_id": 57,
        "name": "row.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 956,
        "menu_id": 57,
        "name": "row.province_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 957,
        "menu_id": 57,
        "name": "row.city_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 958,
        "menu_id": 57,
        "name": "row.area_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 959,
        "menu_id": 57,
        "name": "row.uname",
        "description": "用户名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 960,
        "menu_id": 57,
        "name": "row.name",
        "description": "姓名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 961,
        "menu_id": 57,
        "name": "row.avatar",
        "description": "头像",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 962,
        "menu_id": 57,
        "name": "row.email",
        "description": "电子邮箱",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 963,
        "menu_id": 57,
        "name": "row.mobile_phone",
        "description": "手机号码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 964,
        "menu_id": 57,
        "name": "row.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 965,
        "menu_id": 57,
        "name": "row.email_verified_at",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 966,
        "menu_id": 57,
        "name": "row.description",
        "description": "备注",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 967,
        "menu_id": 57,
        "name": "row.created_at",
        "description": "创建时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 968,
        "menu_id": 57,
        "name": "row.updated_at",
        "description": "修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 969,
        "menu_id": 57,
        "name": "row.admin",
        "description": "后台用户",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 970,
        "menu_id": 57,
        "name": "row.admin.id",
        "description": "后台用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 971,
        "menu_id": 57,
        "name": "row.admin.user_id",
        "description": "后台用户用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 972,
        "menu_id": 57,
        "name": "row.admin.created_at",
        "description": "后台用户创建时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 973,
        "menu_id": 57,
        "name": "row.admin.updated_at",
        "description": "后台用户修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 974,
        "menu_id": 57,
        "name": "configUrl.backUrl",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 975,
        "menu_id": 57,
        "name": "maps.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 976,
        "menu_id": 57,
        "name": "maps.status.0",
        "description": "注销",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 977,
        "menu_id": 57,
        "name": "maps.status.1",
        "description": "有效",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 978,
        "menu_id": 57,
        "name": "maps.status.2",
        "description": "停用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 979,
        "menu_id": 59,
        "name": "row",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 980,
        "menu_id": 59,
        "name": "row.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 981,
        "menu_id": 59,
        "name": "row.old_password",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 982,
        "menu_id": 59,
        "name": "row.password",
        "description": "密码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 983,
        "menu_id": 59,
        "name": "row.password_confirmation",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 984,
        "menu_id": 59,
        "name": "row.ousers",
        "description": "三方登录用户",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 985,
        "menu_id": 59,
        "name": "row.unbind_ids",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 986,
        "menu_id": 59,
        "name": "row.email",
        "description": "电子邮箱",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 987,
        "menu_id": 59,
        "name": "row.mobile_phone",
        "description": "手机号码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 988,
        "menu_id": 59,
        "name": "configUrl.backUrl",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 989,
        "menu_id": 59,
        "name": "maps.ousers",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 990,
        "menu_id": 59,
        "name": "maps.ousers.type",
        "description": "三方登录用户",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 991,
        "menu_id": 59,
        "name": "maps.ousers.type.1",
        "description": "qq",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 992,
        "menu_id": 59,
        "name": "maps.ousers.type.2",
        "description": "weixin",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 993,
        "menu_id": 59,
        "name": "maps.ousers.type.3",
        "description": "weibo",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 994,
        "menu_id": 59,
        "name": "maps.ousers.type.4",
        "description": "weixinweb",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 995,
        "menu_id": 59,
        "name": "maps.ousers.type.5",
        "description": "official",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 996,
        "menu_id": 59,
        "name": "maps.ousers.type_show",
        "description": "三方登录用户",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 997,
        "menu_id": 61,
        "name": "logo",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 998,
        "menu_id": 61,
        "name": "name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 999,
        "menu_id": 61,
        "name": "name_short",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1000,
        "menu_id": 61,
        "name": "debug",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1001,
        "menu_id": 61,
        "name": "env",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1002,
        "menu_id": 61,
        "name": "icp",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1003,
        "menu_id": 61,
        "name": "api_url_model",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1004,
        "menu_id": 61,
        "name": "app_url",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1005,
        "menu_id": 61,
        "name": "api_url",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1006,
        "menu_id": 61,
        "name": "web_url",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1007,
        "menu_id": 61,
        "name": "domain",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1008,
        "menu_id": 61,
        "name": "lifetime",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1009,
        "menu_id": 61,
        "name": "verify",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1010,
        "menu_id": 61,
        "name": "verify.type",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1011,
        "menu_id": 61,
        "name": "verify.dataUrl",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1012,
        "menu_id": 61,
        "name": "verify.data",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1013,
        "menu_id": 61,
        "name": "verify.data.client_fail_alert",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1014,
        "menu_id": 61,
        "name": "verify.data.lang",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1015,
        "menu_id": 61,
        "name": "verify.data.product",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1016,
        "menu_id": 61,
        "name": "verify.data.http",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1017,
        "menu_id": 61,
        "name": "client_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1018,
        "menu_id": 61,
        "name": "default_language",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1019,
        "menu_id": 61,
        "name": "tinymce_key",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1020,
        "menu_id": 61,
        "name": "locales",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1021,
        "menu_id": 61,
        "name": "locales.$index",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1022,
        "menu_id": 61,
        "name": "version",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1023,
        "menu_id": 62,
        "name": "_token",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1024,
        "menu_id": 63,
        "name": "otherLogin",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1025,
        "menu_id": 63,
        "name": "otherLogin.$index",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1026,
        "menu_id": 63,
        "name": "otherLogin.$index.type",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1027,
        "menu_id": 63,
        "name": "otherLogin.$index.url",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1028,
        "menu_id": 63,
        "name": "otherLogin.$index.class",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1029,
        "menu_id": 63,
        "name": "mustVerify",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1030,
        "menu_id": 73,
        "name": "user",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1031,
        "menu_id": 73,
        "name": "user.id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1032,
        "menu_id": 73,
        "name": "user.province_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1033,
        "menu_id": 73,
        "name": "user.city_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1034,
        "menu_id": 73,
        "name": "user.area_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1035,
        "menu_id": 73,
        "name": "user.uname",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1036,
        "menu_id": 73,
        "name": "user.name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1037,
        "menu_id": 73,
        "name": "user.avatar",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1038,
        "menu_id": 73,
        "name": "user.email",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1039,
        "menu_id": 73,
        "name": "user.mobile_phone",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1040,
        "menu_id": 73,
        "name": "user.status",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1041,
        "menu_id": 73,
        "name": "user.email_verified_at",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1042,
        "menu_id": 73,
        "name": "user.description",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1043,
        "menu_id": 73,
        "name": "user.created_at",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1044,
        "menu_id": 73,
        "name": "user.updated_at",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1045,
        "menu_id": 73,
        "name": "user.admin",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1046,
        "menu_id": 73,
        "name": "user.admin.id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1047,
        "menu_id": 73,
        "name": "user.admin.user_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1048,
        "menu_id": 73,
        "name": "user.admin.created_at",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1049,
        "menu_id": 73,
        "name": "user.admin.updated_at",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1050,
        "menu_id": 73,
        "name": "user.admin.roles",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1051,
        "menu_id": 73,
        "name": "user.admin.roles.$index",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1052,
        "menu_id": 73,
        "name": "user.admin.roles.$index.id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1053,
        "menu_id": 73,
        "name": "user.admin.roles.$index.tmp_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1054,
        "menu_id": 73,
        "name": "user.admin.roles.$index.name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1055,
        "menu_id": 73,
        "name": "user.admin.roles.$index.is_tmp",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1056,
        "menu_id": 73,
        "name": "user.admin.roles.$index.description",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1057,
        "menu_id": 73,
        "name": "user.admin.roles.$index.parent_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1058,
        "menu_id": 73,
        "name": "user.admin.roles.$index.level",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1059,
        "menu_id": 73,
        "name": "user.admin.roles.$index.left_margin",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1060,
        "menu_id": 73,
        "name": "user.admin.roles.$index.right_margin",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1061,
        "menu_id": 73,
        "name": "user.admin.roles.$index.created_at",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1062,
        "menu_id": 73,
        "name": "user.admin.roles.$index.updated_at",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1063,
        "menu_id": 73,
        "name": "user.admin.roles.$index.pivot",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1064,
        "menu_id": 73,
        "name": "user.admin.roles.$index.pivot.admin_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1065,
        "menu_id": 73,
        "name": "user.admin.roles.$index.pivot.role_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1066,
        "menu_id": 73,
        "name": "lifetime",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1067,
        "menu_id": 74,
        "name": "menus",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1068,
        "menu_id": 74,
        "name": "menus.$index",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1069,
        "menu_id": 74,
        "name": "menus.$index.id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1070,
        "menu_id": 74,
        "name": "menus.$index.name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1071,
        "menu_id": 74,
        "name": "menus.$index.icons",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1072,
        "menu_id": 74,
        "name": "menus.$index.description",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1073,
        "menu_id": 74,
        "name": "menus.$index.url",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1074,
        "menu_id": 74,
        "name": "menus.$index.parent_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1075,
        "menu_id": 74,
        "name": "menus.$index.resource_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1076,
        "menu_id": 74,
        "name": "menus.$index.status",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1077,
        "menu_id": 74,
        "name": "menus.$index.level",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1078,
        "menu_id": 74,
        "name": "menus.$index.left_margin",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1079,
        "menu_id": 74,
        "name": "menus.$index.right_margin",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1080,
        "menu_id": 74,
        "name": "menus.$index.method",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1081,
        "menu_id": 74,
        "name": "menus.$index._trans_name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1082,
        "menu_id": 74,
        "name": "menus.$index._trans_description",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1083,
        "menu_id": 74,
        "name": "menus.$index.parent",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1084,
        "menu_id": 79,
        "name": "client_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1085,
        "menu_id": 81,
        "name": "row",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1086,
        "menu_id": 81,
        "name": "row.id",
        "description": "ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1087,
        "menu_id": 81,
        "name": "row.province_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1088,
        "menu_id": 81,
        "name": "row.city_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1089,
        "menu_id": 81,
        "name": "row.area_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1090,
        "menu_id": 81,
        "name": "row.uname",
        "description": "用户名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1091,
        "menu_id": 81,
        "name": "row.name",
        "description": "姓名",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1092,
        "menu_id": 81,
        "name": "row.avatar",
        "description": "头像",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1093,
        "menu_id": 81,
        "name": "row.email",
        "description": "电子邮箱",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1094,
        "menu_id": 81,
        "name": "row.mobile_phone",
        "description": "手机号码",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1095,
        "menu_id": 81,
        "name": "row.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1096,
        "menu_id": 81,
        "name": "row.email_verified_at",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1097,
        "menu_id": 81,
        "name": "row.description",
        "description": "备注",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1098,
        "menu_id": 81,
        "name": "row.created_at",
        "description": "创建时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1099,
        "menu_id": 81,
        "name": "row.updated_at",
        "description": "修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1100,
        "menu_id": 81,
        "name": "row.admin",
        "description": "后台用户",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1101,
        "menu_id": 81,
        "name": "row.admin.id",
        "description": "后台用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1102,
        "menu_id": 81,
        "name": "row.admin.user_id",
        "description": "后台用户用户ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1103,
        "menu_id": 81,
        "name": "row.admin.created_at",
        "description": "后台用户创建时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1104,
        "menu_id": 81,
        "name": "row.admin.updated_at",
        "description": "后台用户修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1105,
        "menu_id": 81,
        "name": "row.admin.roles",
        "description": "角色",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1106,
        "menu_id": 81,
        "name": "row.admin.roles.$index",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1107,
        "menu_id": 81,
        "name": "row.admin.roles.$index.id",
        "description": "角色ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1108,
        "menu_id": 81,
        "name": "row.admin.roles.$index.tmp_id",
        "description": "角色模板ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1109,
        "menu_id": 81,
        "name": "row.admin.roles.$index.name",
        "description": "角色名称",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1110,
        "menu_id": 81,
        "name": "row.admin.roles.$index.is_tmp",
        "description": "角色是否模板",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1111,
        "menu_id": 81,
        "name": "row.admin.roles.$index.description",
        "description": "角色描述",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1112,
        "menu_id": 81,
        "name": "row.admin.roles.$index.parent_id",
        "description": "角色父级ID",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1113,
        "menu_id": 81,
        "name": "row.admin.roles.$index.level",
        "description": "角色",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1114,
        "menu_id": 81,
        "name": "row.admin.roles.$index.left_margin",
        "description": "角色",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1115,
        "menu_id": 81,
        "name": "row.admin.roles.$index.right_margin",
        "description": "角色",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1116,
        "menu_id": 81,
        "name": "row.admin.roles.$index.created_at",
        "description": "角色创建时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1117,
        "menu_id": 81,
        "name": "row.admin.roles.$index.updated_at",
        "description": "角色修改时间",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1118,
        "menu_id": 81,
        "name": "row.admin.roles.$index.pivot",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1119,
        "menu_id": 81,
        "name": "row.admin.roles.$index.pivot.admin_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1120,
        "menu_id": 81,
        "name": "row.admin.roles.$index.pivot.role_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1121,
        "menu_id": 81,
        "name": "configUrl.backUrl",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1122,
        "menu_id": 81,
        "name": "maps.status",
        "description": "状态",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1123,
        "menu_id": 81,
        "name": "maps.status.0",
        "description": "注销",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1124,
        "menu_id": 81,
        "name": "maps.status.1",
        "description": "有效",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1125,
        "menu_id": 81,
        "name": "maps.status.2",
        "description": "停用",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1126,
        "menu_id": 84,
        "name": "row",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1127,
        "menu_id": 84,
        "name": "row.command",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1128,
        "menu_id": 84,
        "name": "row.parameters",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1129,
        "menu_id": 84,
        "name": "row.parameters.$index",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1130,
        "menu_id": 84,
        "name": "row.parameters.$index.key",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1131,
        "menu_id": 84,
        "name": "row.parameters.$index.value",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1132,
        "menu_id": 84,
        "name": "row.parameters.$index.rules",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1133,
        "menu_id": 84,
        "name": "row.parameters.$index.title",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1134,
        "menu_id": 84,
        "name": "row.parameters.$index.name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1135,
        "menu_id": 84,
        "name": "row.parameters.$index.type",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1136,
        "menu_id": 84,
        "name": "row.parameters.$index.placeholderValue",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1137,
        "menu_id": 84,
        "name": "row.parameters.$index._value",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1138,
        "menu_id": 84,
        "name": "row.name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1139,
        "menu_id": 84,
        "name": "row._id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1140,
        "menu_id": 84,
        "name": "row._exec",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1141,
        "menu_id": 84,
        "name": "commands",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1142,
        "menu_id": 84,
        "name": "commands.$index",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1143,
        "menu_id": 84,
        "name": "commands.$index.command",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1144,
        "menu_id": 84,
        "name": "commands.$index.parameters",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1145,
        "menu_id": 84,
        "name": "commands.$index.parameters.$index",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1146,
        "menu_id": 84,
        "name": "commands.$index.parameters.$index.key",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1147,
        "menu_id": 84,
        "name": "commands.$index.parameters.$index.value",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1148,
        "menu_id": 84,
        "name": "commands.$index.parameters.$index.rules",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1149,
        "menu_id": 84,
        "name": "commands.$index.parameters.$index.title",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1150,
        "menu_id": 84,
        "name": "commands.$index.parameters.$index.name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1151,
        "menu_id": 84,
        "name": "commands.$index.parameters.$index.type",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1152,
        "menu_id": 84,
        "name": "commands.$index.parameters.$index.placeholderValue",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1153,
        "menu_id": 84,
        "name": "commands.$index.parameters.$index._value",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1154,
        "menu_id": 84,
        "name": "commands.$index.name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1155,
        "menu_id": 84,
        "name": "commands.$index._id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1156,
        "menu_id": 84,
        "name": "commands.$index._exec",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1157,
        "menu_id": 84,
        "name": "maps.database",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1158,
        "menu_id": 84,
        "name": "maps.database.mysql",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1159,
        "menu_id": 84,
        "name": "index",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1160,
        "menu_id": 84,
        "name": "history",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1161,
        "menu_id": 86,
        "name": "data.$index",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1162,
        "menu_id": 86,
        "name": "data.$index.TABLE_CATALOG",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1163,
        "menu_id": 86,
        "name": "data.$index.TABLE_SCHEMA",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1164,
        "menu_id": 86,
        "name": "data.$index.TABLE_NAME",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1165,
        "menu_id": 86,
        "name": "data.$index.TABLE_TYPE",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1166,
        "menu_id": 86,
        "name": "data.$index.ENGINE",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1167,
        "menu_id": 86,
        "name": "data.$index.VERSION",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1168,
        "menu_id": 86,
        "name": "data.$index.ROW_FORMAT",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1169,
        "menu_id": 86,
        "name": "data.$index.TABLE_ROWS",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1170,
        "menu_id": 86,
        "name": "data.$index.AVG_ROW_LENGTH",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1171,
        "menu_id": 86,
        "name": "data.$index.DATA_LENGTH",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1172,
        "menu_id": 86,
        "name": "data.$index.MAX_DATA_LENGTH",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1173,
        "menu_id": 86,
        "name": "data.$index.INDEX_LENGTH",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1174,
        "menu_id": 86,
        "name": "data.$index.DATA_FREE",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1175,
        "menu_id": 86,
        "name": "data.$index.AUTO_INCREMENT",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1176,
        "menu_id": 86,
        "name": "data.$index.CREATE_TIME",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1177,
        "menu_id": 86,
        "name": "data.$index.UPDATE_TIME",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1178,
        "menu_id": 86,
        "name": "data.$index.CHECK_TIME",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1179,
        "menu_id": 86,
        "name": "data.$index.TABLE_COLLATION",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1180,
        "menu_id": 86,
        "name": "data.$index.CHECKSUM",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1181,
        "menu_id": 86,
        "name": "data.$index.CREATE_OPTIONS",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1182,
        "menu_id": 86,
        "name": "data.$index.TABLE_COMMENT",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1183,
        "menu_id": 88,
        "name": "tree",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1184,
        "menu_id": 88,
        "name": "tree.$index",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1185,
        "menu_id": 88,
        "name": "tree.$index.id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1186,
        "menu_id": 88,
        "name": "tree.$index.name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1187,
        "menu_id": 88,
        "name": "tree.$index.icons",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1188,
        "menu_id": 88,
        "name": "tree.$index.parent_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1189,
        "menu_id": 88,
        "name": "tree.$index.level",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1190,
        "menu_id": 88,
        "name": "tree.$index.left_margin",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1191,
        "menu_id": 88,
        "name": "tree.$index.right_margin",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1192,
        "menu_id": 88,
        "name": "tree.$index.item_name",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1193,
        "menu_id": 88,
        "name": "tree.$index.resource_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1194,
        "menu_id": 88,
        "name": "tree.$index.parent",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1195,
        "menu_id": 88,
        "name": "tree.$index._parent_id",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1196,
        "menu_id": 88,
        "name": "tree.$index._level",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1197,
        "menu_id": 88,
        "name": "row",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1198,
        "menu_id": 88,
        "name": "row.update_position",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1199,
        "menu_id": 90,
        "name": "options.where.file",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1200,
        "menu_id": 90,
        "name": "options.order.updated_at",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1201,
        "menu_id": 90,
        "name": "configUrl.downloadUrl",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1202,
        "menu_id": 91,
        "name": "token",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    },
    {
        "id": 1203,
        "menu_id": 91,
        "name": "domain",
        "description": "",
        "created_at": "2021-08-11 11:22:50",
        "updated_at": "2021-08-11 11:22:50",
        "deleted_at": null
    }
]
JSON;
        $data = json_decode($json_data,true);
        $class::insertReplaceAll($data);
    }
}
