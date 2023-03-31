<template>
    <div class="open_ai_message_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box no-border" :class="'box-'+theme" :options="options" ref="table">
                    <template slot="sizer" slot-scope="props">
                        <div></div>
                    </template>
                    <template slot="sizer-min" slot-scope="props">
                        <div></div>
                    </template>
                    <template slot="table" slot-scope="props">
                        <div class="slimScrollDiv">
                            <div class="chat">
                                <el-empty description="暂无数据" v-show="!(props.data.list?props.data.list.data:[]).length"></el-empty>
                                <div class="text-center" v-show="props.data.list['current_page']!=props.data.list['last_page']">
                                    <a v-if="$refs['table'] && $refs['table'].loading">
                                        加载中...
                                    </a>
                                    <a @click="$refs['table'].toPage(props.data.list['current_page']+1)" v-else>
                                        <i class="fa fa-angle-double-up"></i>
                                        查看更多
                                    </a>
                                </div>
                                <div class="item" :class="row.role==1?'text-right':''"  v-for="(row,i) in (props.data.list?props.data.list.data:[])">
                                    <img :src="row.role==0?props.data.system_head_url:(row.role==2?props.data.robot_head_url:'/dist/img/user_default_180.gif')"
                                         alt="user image"
                                         class="user-imge"
                                         :class="row.role==1?'offline':'online'"
                                    >
                                    <p class="message"  :class="row.role==1?'right-message':''" >
                                        <a  class="name">
                                            <small class="text-muted" :class="row.role==1?'pull-left':'pull-right'">
                                                <i class="fa fa-clock-o"></i>
                                                {{row.created}}
                                            </small>
                                           {{row.role==0?props.data.system_name:(row.role==2?props.data.robot_name:'游客')}}
                                        </a>
                                        <span style="white-space: pre-line;">
                                            {{row.conternt}}
                                        </span>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </template>
                    <template slot="pager" slot-scope="props">
                        <div>
                            <div v-show="!(props.data.list?props.data.list.data:[]).length" class="m-b-10">
                                <select2
                                    v-model="row['ai_prompt_template_id']"
                                    :default-options="[]"
                                    :url="use_url+'/open/ai-prompt-templates/list'"
                                    :keyword-key="'name'"
                                    :placeholder-value="0"
                                    :placeholder-show="'请选择提示词模板'"
                                    :show="['name']"
                                    :is-ajax="true" >
                                </select2>
                            </div>

                            <div class="input-group">
                                <input class="form-control" v-model="row.message_text" placeholder="发送一条消息">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-success">
                                        <i class="fa fa-send-o"></i>
                                    </button>
                                </div>
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
        components:{
            'data-table':()=>import(/* webpackChunkName: "common_components/datatable.vue" */ 'common_components/datatable.vue'),
            elEmpty:()=>import(/* webpackChunkName: "element-ui/lib/input-number" */ 'element-ui/lib/empty'), //数字框异步组件
            "select2":()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),


        },
        props: {
        },
        data(){
            return {
                options: {
                    lang_table: 'ai_messages', //字段翻译
                    id: 'data-table', //多个data-table同时使用时唯一标识
                    url: '/open/ai-messages', //数据表请求数据地址
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
                    hideTopPagerTool:true,
                    hideBottomPagerTool:false,
                    dataPush:true, //数据追加
                    routerPushDisabled:true,
                    fields: {
                        id: {name: "ID", order: true},
                        ai_chat_id: {name: "聊天室ID", order: true, type: "select2"},
                        role: {name: "角色", order: true, type: "radio"},
                        conternt: {name: "内容", order: true, type: "textarea"},
                        created_at: {name: "Created At", order: true, type: "time"},
                        updated_at: {name: "Updated At", order: true, type: "time"}
                    }
                },
                row:{
                    ai_prompt_template_id:0,
                    message_text:''
                }

            };
        },
        computed:{
            ...mapState([
                'use_url',
                'theme',
                'labelClass'
            ])
        },
        methods:{

        }
    };
</script>
<style lang="scss" scoped>
.chat .item>.right-message{
    margin-right: 55px;
    margin-left: 0px;
}
.m-b-10{
    margin-bottom: 10px;
}


</style>
