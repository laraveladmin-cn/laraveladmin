<template>
    <div class="admin_message_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box" :class="'box-'+theme" :options="options" ref="table">
                    <template slot="sizer-more" slot-scope="props">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sizer-item">
                                <select2 v-model="props.where['ai_chat_id']"
                                         :default-options="array_get(props,'maps.ai_chat_id',[])"
                                         :url="use_url+'/admin/ai-chats/list'"
                                         :keyword-key="'name'"
                                         :placeholder-show="'对话'"
                                         :placeholder-value="''"
                                         :primary-key="'id'"
                                         :show="['name','user.name']"
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
        select2:()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),

    },
    props: {},
    data() {
        return {
            options: {
                lang_table: 'messages', //字段翻译
                id: 'data-table', //多个data-table同时使用时唯一标识
                url: '', //数据表请求数据地址
                operation: true, //操作列
                checkbox: true, //选择列
                btnSizerMore: false, //更多筛选条件按钮
                keywordKey: 'name', //关键字查询key
                keywordGroup: false, //是否为选项组
                keywordPlaceholder: () => {
                    return this.$t('Please enter keywords');
                },
                primaryKey: 'id', //数据唯一性主键
                defOptions: null, //默认筛选条件
                fields: {
                    id: {name: "ID", order: true},
                    //ai_chat_id: {name: "聊天室ID", order: true, type: "select2"},
                    "ai_chat.name": {name: "聊天室ID", order: true, type: "select2"},
                    role: {name: "角色", order: true, type: "radio"},
                    content: {name: "内容", order: true,type:'code',limit:30},
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
