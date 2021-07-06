<template>
    <div class="admin_donation_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box box-primary" :options="options" ref="table">
                    <template slot="sizer-more" slot-scope="props">
                        <div class="row" >
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 sizer-item">
                                <select2 v-model="props.where['from']"
                                         :default-options="props.maps['from']"
                                         :placeholder-show="props.transField('from')"
                                         :placeholder-value="''"
                                         :is-ajax="false" >
                                </select2>
                            </div>
                        </div>
                    </template>
                    <template slot="col" slot-scope="props">
                        <span v-if="props.field.type =='label'">
                            <span class="label" :class="'label-'+statusClass[props.row[props.k]%statusClass.length]">
                                {{ props.maps[props.k] | array_get(props.row[props.k]) }}
                            </span>
                        </span>
                        <span v-else-if="props.k =='bills_count'">
                             <router-link :to="'/admin/bills?options='+getOptions({where:{'donation_id':props.row['id']}})">
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
            "select2":()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),

        },
        props: {},
        data() {
            return {
                options: {
                    lang_table: 'donations', //字段翻译
                    id: 'data-table', //多个data-table同时使用时唯一标识
                    url: '', //数据表请求数据地址
                    operation: true, //操作列
                    checkbox: true, //选择列
                    btnSizerMore: true, //更多筛选条件按钮
                    keywordKey: 'member.user.name', //关键字查询key
                    keywordGroup: false, //是否为选项组
                    keywordPlaceholder: () => {
                        return this.$t('Please enter keywords');
                    },
                    primaryKey: 'id', //数据唯一性主键
                    defOptions: null, //默认筛选条件
                    fields: {
                        id: {name: "ID", order: true},
                        "member.user.name": {name: "捐赠会员", order: false, type: "select2"},
                        "sponsor.name": {name: "赞助商", order: false, type: "select2"},
                        from: {name: "来源", order: true, type: "radio"},
                        amount: {name: "捐赠金额", order: true, type: "num"},
                        "bills_count": {name: "受益记录", order: false, type: "num"},
                        created_at: {name: "Created At", order: true, type: "time"},
                        updated_at: {name: "Updated At", order: true, type: "time"}
                    },
                }
            };
        },
        computed: {
            ...mapState([
                'use_url'
            ])
        },
        methods: {},
    };
</script>
<style lang="scss" scoped>


</style>
