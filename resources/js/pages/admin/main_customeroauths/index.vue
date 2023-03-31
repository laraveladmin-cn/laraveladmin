<template>
    <div class="admin_main_customeroauth_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box" :class="'box-'+theme" :options="options" ref="table">
                    <template slot="col" slot-scope="props">
                        <span v-if="props.k =='main_customer.name'">
                           {{props.row | array_get(props.k)}}
                            <div>手机号码:{{props.row | array_get('main_customer.mobile')}}</div>
                        </span>
                        <span v-else-if="props.field.type =='label' || props.field.type =='radio' ">
                            <span class="label" :class="props.labelClass(props.row,props.k)">
                                {{ props.maps | array_get(props.k,[]) | array_get(array_get(props.row,props.k)) }}
                            </span>
                        </span>
                        <span v-else-if="props.field.type =='code'">
                            <code v-if="props.field.limit">
                                {{props.row | array_get(props.k) | str_limit(props.field.limit)}}
                            </code>
                            <code v-else>
                                  {{props.row | array_get(props.k)}}
                            </code>
                        </span>
                        <span v-else-if="props.field.type =='pre'">
                            <pre v-if="props.field.limit">{{props.row | array_get(props.k) | str_limit(props.field.limit)}}</pre>
                            <pre v-else>{{props.row | array_get(props.k)}}</pre>
                        </span>
                        <span v-else>
                            {{props.row | array_get(props.k)}}
                        </span>
                    </template>
                    <template slot="sizer-more" slot-scope="props">
                        <div class="row" >
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 sizer-item">
                                <select2 v-model="props.where['type']"
                                         :default-options="props.maps['type']"
                                         :placeholder-show="'类型'"
                                         :placeholder-value="''"
                                         :is-ajax="false" >
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
        "select2":()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),

    },
    props: {},
    data() {
        return {
            options: {
                lang_table: 'main_customeroauth', //字段翻译
                id: 'data-table', //多个data-table同时使用时唯一标识
                url: '', //数据表请求数据地址
                operation: true, //操作列
                checkbox: true, //选择列
                btnSizerMore: false, //更多筛选条件按钮
                keywordKey: 'data', //关键字查询key
                keywordGroup: false, //是否为选项组
                keywordPlaceholder: () => {
                    return this.$t('Please enter keywords');
                },
                primaryKey: 'id', //数据唯一性主键
                defOptions: null, //默认筛选条件
                fields: {
                    id: {name: "id", order: true},
                    type: {name: "类型", order: true, type: "radio"},
                    open_id: {name: "用户唯一标识", order: true},
                    union_id: {name: "extra第三方登陆ID", order: true},
                    data: {name: "用户信息", order: true,type:'code',limit:30},
                    'main_customer.name': {name: "用户", order: true, type: "select2"},
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
