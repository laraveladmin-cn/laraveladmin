<template>
    <div class="admin_main_customer_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box" :class="'box-'+theme" :options="options" ref="table">
                    <template slot="sizer-more" slot-scope="props">
                        <div class="row" >
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 sizer-item">
                                <select2 v-model="props.where['is_active']"
                                         :default-options="props.maps['is_active']"
                                         :placeholder-show="'状态'"
                                         :placeholder-value="''"
                                         :is-ajax="false" >
                                </select2>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 sizer-item">
                                <select2 v-model="props.where['role_id']"
                                         :default-options="array_get(props,'maps.main_customerrole_id',[])"
                                         :url="use_url+'/admin/main-customerroles/list'"
                                         :keyword-key="'name|code'"
                                         :show="['name','code']"
                                         :placeholder-show="'用户角色'"
                                         :placeholder-value="''"
                                         :is-ajax="true" >
                                </select2>
                            </div>
                        </div>
                    </template>
                </data-table>
            </div>
        </div>
    </div>
</template>

<script>
import {mapState, mapActions, mapMutations, mapGetters} from 'vuex';

export default {
    components: {
        'data-table': () => import(/* webpackChunkName: "common_components/datatable.vue" */ 'common_components/datatable.vue'),
        select2:()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'), //选择框异步组件

    },
    props: {},
    data() {
        return {
            options: {
                lang_table: 'main_customer', //字段翻译
                id: 'data-table', //多个data-table同时使用时唯一标识
                url: '', //数据表请求数据地址
                operation: true, //操作列
                checkbox: true, //选择列
                btnSizerMore: false, //更多筛选条件按钮
                keywordKey: 'name|mobile', //关键字查询key
                keywordGroup: false, //是否为选项组
                keywordPlaceholder: () => {
                    return this.$t('Please enter keywords');
                },
                primaryKey: 'id', //数据唯一性主键
                defOptions: null, //默认筛选条件
                fields: {
                    id: {name: "id", order: true},
                    mobile: {name: "手机号(含区号)", order: true},
                    nickname: {name: "昵称", order: true},
                    avatar: {name: "头像", order: true, type: "upload"},
                    name: {name: "真实姓名", order: true},
                    email: {name: "电子邮箱", order: true},
                    "main_customerrole.name": {name: "用户角色", order: true, type: "select2"},
                    last_login: {name: "最后登录日期", order: true, type: "datetime"},
                    is_active: {name: "状态", order: true, type: "radio"},
                    created_at: {name: "Created At", order: true, type: "time"},
                    updated_at: {name: "Updated At", order: true, type: "time"}
                }
            }
        };
    },
    computed: {
        ...mapState([
            'use_url',
            'theme'
        ])
    },
    methods: {}
};
</script>
<style lang="scss" scoped>


</style>
