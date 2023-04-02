<template>
    <div class="admin_ousers_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box" :class="'box-'+theme" :options="options" ref="table">
                    <template slot="sizer-more" slot-scope="props">
                        <div class="row" >
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 sizer-item">
                                <select2 v-model="props.where['type']"
                                         :default-options="props.maps['type']"
                                         :placeholder-show="props.transField('Type')"
                                         :placeholder-value="''"
                                         :is-ajax="false" >
                                </select2>
                            </div>
                        </div>
                    </template>
                    <template slot="col" slot-scope="props">
                        <span v-if="props.field.type =='label'">
                            <span class="label" :class="props.labelClass(props.row,props.k)">
                                {{ props.maps | array_get(props.k,[]) | array_get(array_get(props.row,props.k)) }}
                            </span>
                        </span>
                        <span v-else-if="props.field.type =='code'">
                            <code>
                              {{props.showCode(props.row,props.k,props.field)}}
                            </code>
                        </span>
                        <span v-else-if="props.k =='user.uname'">
                             <router-link :to="'/admin/users/'+props.row['user_id']" v-show="props.row['user_id']">
                                {{props.row | array_get(props.k)}}
                              </router-link>
                        </span>
                        <span v-else>
                            {{props.row | array_get(props.k)}}
                        </span>
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
        select2:()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),

    },
    props: {},
    data() {
        return {
            options: {
                lang_table: 'ousers', //字段翻译
                id: 'data-table', //多个data-table同时使用时唯一标识
                url: '', //数据表请求数据地址
                operation: true, //操作列
                checkbox: true, //选择列
                btnSizerMore: false, //更多筛选条件按钮
                keywordKey: 'data|user.uname|user.name|user.mobile_phone', //关键字查询key
                keywordGroup: false, //是否为选项组
                keywordPlaceholder: () => {
                    return this.$t('Please enter keywords');
                },
                primaryKey: 'id', //数据唯一性主键
                defOptions: null, //默认筛选条件
                fields: {
                    id: {name: "ID", order: true},
                    //user_id: {name: "User ID", order: true},
                    "user.uname": {name: "用户", order: true},
                    type: {name: "Type", order: true,type:'label'},
                    open_id: {name: "User unique ID", order: true},
                    data: {name: "User information", order: true,type:"code",limit:50},
                    //created_at: {name: "Created At", order: true, type: "time"},
                    updated_at: {name: "Updated At", order: true, type: "time"}
                },
            }
        };
    },
    computed: {
        ...mapState([
            'use_url',
            'theme'
        ])
    },
    methods: {},
};
</script>
<style lang="scss" scoped>


</style>
