<template>
    <div class="open_ai_chat_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box no-border" :class="'box-'+theme" :options="options" ref="table">
                    <template slot="sizer" slot-scope="props">
                        <div class="m-t-10">
                            <button type="button" class="btn btn-default btn-block" @click="addChat">
                                <i class="fa fa-plus"></i> 新建对话
                            </button>
                        </div>
                        <div class="m-t-10 hidden-xs hidden-sm">
                            <div class="input-group">
                                <input @keyup.enter="props.search"  v-model="props.data.options.where[options.keywordKey]" :placeholder="$t('Please enter keywords')" type="text" class="form-control">
                                <div class="input-group-btn">
                                    <button type="button" :title="$t('Search')" class="btn" :class="'btn-'+theme" @click="props.search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <button type="button" :title="$t('Reset')" class="btn" :class="'btn-'+theme" @click="props.reset">
                                        <i class="fa fa-repeat"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template slot="table" slot-scope="props">
                        <div class="box" style="border-top: 0px;">
                            <div class="slimScrollDiv">
                                <div class="box-body chat">
                                    <el-empty description="暂无数据" v-show="!(props.data.list?props.data.list.data:[]).length"></el-empty>
                                    <div class="item" v-for="(row,i) in (props.data.list?props.data.list.data:[])"
                                         @click="activeChat(row)"
                                         :class="chat_active==row.id?'active':''">
                                        <div class="input-group" v-if="edit_chat_id==row.id">
                                              <span class="input-group-addon">
                                                <i class="fa fa-comment-o"></i>
                                            </span>
                                            <input type="text" v-model="row.name" class="form-control" placeholder="请输入对话名称">
                                            <span class="input-group-addon" @click="postEditChat(row)">
                                                <i class="fa fa-check"></i>
                                            </span>
                                            <span class="input-group-addon" @click="cancelEditChat">
                                                <i class="fa fa-close"></i>
                                            </span>
                                        </div>
                                        <div v-else>
                                            <i class="fa fa-comment-o"></i>
                                            {{row.name}}
                                            <span class="pull-right" v-show="chat_active==row.id">
                                            <i class="fa fa-edit" @click="edit_chat_id=row.id"></i>
                                            <i class="fa fa-trash-o" @click="props.remove([row.id])"></i>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="text-center" v-show="props.data.list['current_page']!=props.data.list['last_page']">
                                        <a v-if="$refs['table'] && $refs['table'].loading">
                                            加载中...
                                        </a>
                                        <a @click="$refs['table'].toPage(props.data.list['current_page']+1)" v-else>
                                            <i class="fa fa-angle-double-down"></i>
                                            查看更多
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </data-table>
                <div v-show="false">
                    <ai-chat-edit
                        ref="ai_chat_edit"
                        :url="'/open/ai-chats/0'"
                        :no-back="true"
                        :callback="callbackChat"
                    >
                    </ai-chat-edit>
                </div>
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
            "ai-chat-edit": ()=>import(/* webpackChunkName: "pages/open/ai_chats/edit.vue" */ 'pages/open/ai_chats/edit.vue'),
            'div-input':()=>import(/* webpackChunkName: "common_components/divInput.vue" */ 'common_components/divInput.vue'),
        },
        props: {
        },
        data(){
            return {
                chat_active:0,
                edit_chat_id:0,
                options:{
                    lang_table:'ai_chats', //字段翻译
                    id:'data-table', //多个data-table同时使用时唯一标识
                    url:'/open/ai-chats', //数据表请求数据地址
                    operation:true, //操作列
                    checkbox:true, //选择列
                    btnSizerMore:false, //更多筛选条件按钮
                    keywordKey:'name', //关键字查询key
                    keywordGroup:false, //是否为选项组
                    hideTopPagerTool:true,
                    hideBottomPagerTool:true,
                    dataPush:true, //数据追加
                    routerPushDisabled:true,
                    keywordPlaceholder:()=>{
                        return this.$t('Please enter keywords');
                    },
                    primaryKey:'id', //数据唯一性主键
                    defoptions: null, //默认筛选条件
                    fields: {
                        id: {name: "id", order: true},
                        client_id: {name: "连接id", order: true},
                        ouser_id: {name: "三方登录用户id", order: true, type: "select2"},
                        user_id: {name: "用户id", order: true, type: "select2"},
                        name: {name: "对话名称", order: true, type: "required"},
                        created_at: {name: "created at", order: true, type: "time"},
                        updated_at: {name: "updated at", order: true, type: "time"}
                    }
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
            ...mapActions({
                refreshToken: 'refreshToken',
                pushMessage: 'pushMessage',
            }),
            activeChat(row){
                this.chat_active = row.id;
            },
            //新增聊天对话
            addChat(){
                let $btn = this.$refs.ai_chat_edit.$refs.edit.$refs.submit;
                $btn.click();
            },
            callbackChat(res,row){
                if(res.data.id){
                    this.$refs.table.search();
                    this.chat_active = res.data.id;
                }
            },
            cancelEditChat(){
                this.edit_chat_id = 0;
            },
            postEditChat(row){
                axios.put(this.use_url+'/open/ai-chats/{id}'.replace('{id}',row.id), row).then( (response)=>{
                    this.refreshToken();
                    this.cancelEditChat();
                }).catch((error) =>{
                    this.refreshToken();
                    if(error.response && error.response.status==422){
                        this.pushMessage({
                            'showClose':true,
                            'title':this.$t('{action} failed!',{action:this.$t('Submission')}),
                            'message':'',
                            'type':'danger',
                            'position':'top',
                            'iconClass':'fa-warning',
                            'customClass':'',
                            'duration':3000,
                            'show':true
                        });
                    }
                });
            }
        },
        watch:{
            //切换对话列表
            chat_active(val){
                this.$emit('chatActive',val);
            }
        },

    };
</script>
<style lang="scss" scoped>
.m-t-10{
    margin-top: 10px;
}

</style>
