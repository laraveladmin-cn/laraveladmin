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
                                    <img :src="getImg(row,props)"
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
                                           {{getName(row,props)}}
                                        </a>
                                        <span style="white-space: pre-line;">{{row.content}}</span>
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
                                <input class="form-control"
                                       v-model="row.content"
                                       placeholder="发送一条消息"
                                       @keyup.enter="postSend"
                                       :disabled="!row.ai_chat_id"
                                >
                                <div class="input-group-btn">
                                    <button type="button"
                                            class="btn btn-success"
                                            @click="postSend"
                                            :disabled="!row.ai_chat_id"
                                    >
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
                    dataPrepend:true, //数据向前
                    routerPushDisabled:true,
                    fields: {
                        id: {name: "ID", order: true},
                        ai_chat_id: {name: "聊天室ID", order: true, type: "select2"},
                        role: {name: "角色", order: true, type: "radio"},
                        content: {name: "内容", order: true, type: "textarea"},
                        created_at: {name: "Created At", order: true, type: "time"},
                        updated_at: {name: "Updated At", order: true, type: "time"}
                    }
                },
                row:{
                    ai_prompt_template_id:0,
                    content:'',
                    ai_chat_id:0,
                    ai_prompt_template:null
                },
                path:  (window.location.protocol=='https:'?'wss':'ws')+'://'+window.location.host, // 和上面开启的链接是一样的，只是换了ws协议
                socket:  null,
                sending:false, //消息发送中
                in_response:false //消息响应中

            };
        },
        watch:{
            'row.ai_prompt_template_id'(val){ //选择提示词模板
                if(val){
                    axios.get(this.use_url+'/open/ai-prompt-templates/'+val).then(res=>{
                        this.row.ai_prompt_template = res.data.row;
                    });
                }else {
                    this.row.ai_prompt_template = null;
                }
            },
        },
        computed:{
            ...mapState([
                'use_url',
                'theme',
                'labelClass'
            ]),
            ...mapState('user',{
                user:state => state.user,
                loadingUser:state => state.loading
            }),
        },
        methods:{
            getName(row,props){
                let name = '游客';
                if(row.role==0 && props.data.system_name){
                    name = props.data.system_name;
                }else if(row.role==2 && props.data.robot_name){
                    name = props.data.robot_name;
                }else if(row.role==1 && this.user['name']){
                    name = this.user['name'];
                }
                return name;
            },
            getImg(row,props){
                let url = '/dist/img/user_default_180.gif';
                //系统
                if(row.role==0 && props.data.system_head_url){
                    url = props.data.system_head_url;
                //AI回答
                }else if(row.role==2 && props.data.robot_head_url){
                    url = props.data.robot_head_url;
                }else if(row.role==1 && this.user['avatar']){
                    url = this.user['avatar'];
                }
                return url;

            },
            open: () =>{
                console.log("socket连接成功");
                this.send('["example",[1]]');  // 发个消息 格式默认规定是这样的
            },
            error: () =>{
                console.log("连接错误");
            },
            getMessage: (msg)=> {
                console.log("收到服务器信息" + msg.data);
            },
            send: (params) =>{
                this.socket.send(params);
            },
            postSend(){
                if(this.sending || !this.row.content){
                    return;
                }
                this.sending=true;
                axios.post(this.use_url+'/open/ai-messages', this.row).then( (response)=>{
                    this.sending=false;
                    this.row.content='';
                    if(response.data && response.data.init_message){
                        this.$refs.table.data.list.data.push(response.data.init_message);
                    }
                    if(response.data && response.data.question){
                        this.$refs.table.data.list.data.push(response.data.question);
                    }
                    if(response.data && response.data.answer){
                        this.$refs.table.data.list.data.push(response.data.answer);
                    }
                }).catch((error) =>{
                    this.sending=false;
                });
            }
        },
        created(){
            if (typeof WebSocket === "undefined") {
                alert("您的浏览器不支持socket");
            } else {
                // 实例化socket
                this.socket = new WebSocket(this.path);
                // 监听socket连接
                this.socket.onopen = this.open;
                // 监听socket错误信息
                this.socket.onerror = this.error;
                // 监听socket消息
                this.socket.onmessage = this.getMessage;
            }
        },
        destroyed(){
            if(this.socket){
                this.socket.close();
            }
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
.user-imge{
    border: none !important;
    border-radius: unset !important;
}


</style>
