<template>
    <div class="admin_menu_index">
        <modal v-model="modal" class-name="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
            <edit :url="edit_url" :no-back="true" :callback="callback"></edit>
        </modal>
        <el-tabs v-model="active">
            <el-tab-pane :label="$tp(tabs[0])" :name="0+''" :key="0">
                <div class="row" >
                    <div class="col-xs-12">
                        <data-table :options="options" ref="table" class="box">
                            <template slot="sizer-more" slot-scope="props">
                                <div v-show="false">
                                    {{updateUrl()}}
                                </div>
                                <div class="row" >
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sizer-item">
                                        <select2 v-model="props.where['method']"
                                                 :default-options="props.maps['method']"
                                                 :placeholder-show="'请求方式'"
                                                 :placeholder-value="''"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sizer-item">
                                        <select2 v-model="props.where['status']"
                                                 :default-options="props.maps['status']"
                                                 :placeholder-show="'状态'"
                                                 :placeholder-value="''"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sizer-item">
                                        <select2 v-model="props.where['is_page']"
                                                 :default-options="props.maps['is_page']"
                                                 :placeholder-show="'是否为页面'"
                                                 :placeholder-value="''"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </div>
                            </template>
                            <template slot="add" slot-scope="props">
                                <button class="btn btn-info" @click="openModal(props.url)" v-if="props.url">
                                    <i class="fa fa-plus"></i> {{$t('New')}}
                                </button>
                            </template>
                            <template slot="col-operation" slot-scope="props">
                                <button v-show="props.data.configUrl['deleteUrl']"
                                        :title="$t('Delete selected')"
                                        type="button"
                                        class="btn btn-danger btn-xs"
                                        :disabled="props.row[options.primaryKey]==1"
                                        @click="props.remove([props.row[options.primaryKey]])">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                                <button class="btn btn-info btn-xs"
                                        :title="$t('Edit')"
                                        @click="openModal(props.data.configUrl['showUrl'].replace('{id}',props.row[options.primaryKey]))"
                                        v-if="props.data.configUrl['showUrl']">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </template>
                        </data-table>
                    </div>
                </div>
            </el-tab-pane>
            <el-tab-pane :label="$tp(tabs[1])" :name="1+''" :key="1" v-if="update_url">
                <div class="row" >
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body">
                                <menu-tree :callback="callback" ref="menuTree" ></menu-tree>
                            </div>
                        </div>
                    </div>
                </div>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations, mapGetters} from 'vuex';

    export default {
        components: {
            'data-table': () => import(/* webpackChunkName: "common_components/datatable.vue" */ 'common_components/datatable.vue'),
            "labelEdit": () => import(/* webpackChunkName: "common_components/labelEdit.vue" */ 'common_components/labelEdit.vue'),
            "edit":()=>import(/* webpackChunkName: "pages/admin/menus/edit.vue" */ './edit.vue'),
            "modal":()=>import(/* webpackChunkName: "common_components/modal.vue" */ 'common_components/modal.vue'),
            "select2":()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),
            "el-tab-pane": ()=>import(/* webpackChunkName: "element-ui/lib/tab-pane" */ 'element-ui/lib/tab-pane'),
            "el-tabs": ()=>import(/* webpackChunkName: "element-ui/lib/tabs" */ 'element-ui/lib/tabs'),
            "menu-tree": ()=>import(/* webpackChunkName: "pages/admin/menus/menuTree.vue" */ './menuTree.vue'),
        },
        props: {
            url: {
                type: [String],
                default: function () {
                    return '';
                }
            }
        },
        data() {
            let def_options = JSON.parse(this.$router.currentRoute.query.options || '{}');
            return {
                "{lang_path}":'admin.menus',
                active: 0,
                tabs:[
                    'Data list',
                    'Drag shift'
                ],
                edit_url:'',
                modal:false,
                update_url:false,
                options: {
                    id: 'data-table', //多个data-table同时使用时唯一标识
                    url: this.url || '', //数据表请求数据地址
                    operation: true, //操作列
                    checkbox: true, //选择列
                    btnSizerMore: true, //更多筛选条件按钮
                    keywordKey: 'name|url', //关键字查询key
                    keywordGroup: false, //是否为选项组
                    keywordPlaceholder:()=>{
                        return this.$t('enter',{name:this.$t('name')});
                    },//'请输入名称',
                    primaryKey: 'id', //数据唯一性主键
                    defOptions: def_options, //默认筛选条件
                    fields: {
                        "id": {"name": "ID", "order": true},
                        "icons": {"name": '图标', "order": true, type: 'icon'},
                        "name": {"name": "名称", "order": true, type: 'level', levelName: 'level', class: 'text-left'},
                        "url": {"name": "URL路径", "order": true, class: 'text-left'},
                        "method": {"name": "请求方式", "order": true, type: 'labels'},
                        "is_page": {"name": "是否为页面", "order": true, type: 'label'},
                        "status": {"name": "状态", "order": true, type: 'label'},
                        //"created_at": {"name": "创建时间", "order": true},
                        "updated_at": {"name": "修改时间", "order": true},
                    },
                    removeCallback:()=>{
                        this.getMenus();
                    }
                },
            };
        },
        computed: {
            ...mapState([
                'statusClass'
            ]),

        },
        watch: {
            url(val) {
                this.options.url = val;
            }
        },
        methods:{
            ...mapActions({
                getMenus:'menu/getMenus', //更新菜单
            }),
            openModal(val){
                this.modal = true;
                this.edit_url = val;
            },
            callback(){
                this.modal = false;
                //刷新页面
                this.$refs['table'].refresh();
                //刷新布局
                this.$refs['menuTree'].refresh();
            },
            updateUrl(){
                if(!this.$refs['table'] || !this.$refs['table'].data){
                    this.update_url = '';
                }else {
                    this.update_url = this.$refs['table'].data.configUrl.updateUrl;
                }
            }
        },
        mounted() {
        }
    };
</script>
<style lang="scss" scoped>
.box{
    border-top: 0px;
}
</style>
