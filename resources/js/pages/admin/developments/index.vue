<template>
    <div class="row">
        <section class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs ui-sortable-handle">
                    <li class="active">
                        <a href="#console" data-toggle="tab">控制台命令</a>
                    </li>
                    <li>
                        <a href="#menus" data-toggle="tab">菜单路由</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="chart tab-pane active" id="console">
                        <edit :options="options" ref="edit">
                            <template slot="content" slot-scope="props">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <h5>
                                        <code>php artisan {{props.data.row.command}}</code>
                                    </h5>
                                    <div>
                                        <table class="table table-hover table-bordered table-striped text-center dataTable">
                                            <thead>
                                                <tr>
                                                    <th>命令</th>
                                                    <th>中文</th>
                                                    <th>English</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in props.data.commands">
                                                    <td>
                                                        <code>{{item.command}}</code>
                                                    </td>
                                                    <td>{{item.chinese}}</td>
                                                    <td>{{item.english}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </template>
                        </edit>
                    </div>
                    <div class="chart tab-pane" id="menus">
                        菜单内容
                    </div>
                </div>
            </div>

        </section>
    </div>
</template>

<script>
    export default {
        components: {
            'edit': () => import(/* webpackChunkName: "common_components/edit.vue" */ 'common_components/edit.vue'),
            "edit-item": () => import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue')
        },
        data() {
            return {
                options: {
                    id: 'edit', //多个组件同时使用时唯一标识
                    url: '/admin/developments/index', //数据表请求数据地址
                    params: {},
                    fixed: true,
                    callback: (response, row) => { //修改成功

                    }
                }
            }
        },
        mounted() {


        }
    }
</script>

<style scoped>

</style>
