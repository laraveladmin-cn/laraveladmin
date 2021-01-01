<template>
    <div class="admin_user_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box box-primary" :options="options">
                        <template slot="sizer-more" slot-scope="props">
                            <div class="row" >
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 sizer-item">
                                    <select2 v-model="props.where['status']"
                                             :default-options="props.maps['status']"
                                             :placeholder-show="'状态'"
                                             :placeholder-value="''"
                                             :is-ajax="false" >
                                    </select2>
                                </div>
                            </div>
                        </template>
                    <template slot="col-operation" slot-scope="props">
                        <button v-show="props.data.configUrl['deleteUrl']"
                                title="删除选中"
                                type="button"
                                class="btn btn-danger btn-xs"
                                :disabled="props.row[options.primaryKey]==1"
                                @click="props.remove([props.row[options.primaryKey]])">
                            <i class="fa fa-trash-o"></i>
                        </button>
                        <router-link class="btn btn-info btn-xs"
                                     title="编辑"
                                     :to="props.data.configUrl['showUrl'].replace('{id}',props.row[options.primaryKey])"
                                     v-if="props.data.configUrl['showUrl']">
                            <i class="fa fa-edit"></i>
                        </router-link>
                    </template>
                    <template slot="col-checkbox" slot-scope="props">
                        <icheck v-model="props.check_ids"
                                class="ids"
                                :disabled-label="true"
                                :disabled="props.row[options.primaryKey]==1"
                                :option="props.row[options.primaryKey]"></icheck>
                    </template>
                </data-table>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations, mapGetters} from 'vuex';

    export default {
        components:{
            'data-table':()=>import(/* webpackChunkName: "common_components/datatable.vue" */ 'common_components/datatable.vue'),
            "select2":()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),
            "icheck":()=>import(/* webpackChunkName: "common_components/icheck.vue" */ 'common_components/icheck.vue'),
        },
        props: {
        },
        data(){
            let def_options = JSON.parse(this.$router.currentRoute.query.options || '{}');
            return {
                options:{
                    id:'data-table', //多个data-table同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    operation:true, //操作列
                    checkbox:true, //选择列
                    btnSizerMore:true, //更多筛选条件按钮
                    keywordKey:'name|uname|mobile_phone|email', //关键字查询key
                    keywordGroup:false, //是否为选项组
                    keywordPlaceholder:'请输入用户昵称',
                    primaryKey:'id', //数据唯一性主键
                    defOptions:def_options, //默认筛选条件
                    fields: {
                        "uname": {"name": "用户名","order": true},
                        "name": {"name": "昵称", "order": true},
                        "mobile_phone": {"name": "手机号码", "order": true},
                        "email": {"name": "电子邮箱", "order": true},
                        "status": {"name": "状态", "order": true,type:'label'},
                    },
                }
            };
        },
        computed:{

        },

    };
</script>
<style lang="scss">


</style>
