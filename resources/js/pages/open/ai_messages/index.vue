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
                                <el-empty description="暂无数据" v-show="!(props.data.list?props.data.list.data:[]).length && !sending"></el-empty>
                                <div class="text-center" v-show="props.data.list['current_page']!=props.data.list['last_page']">
                                    <a v-if="$refs['table'] && $refs['table'].loading">
                                        加载中...
                                    </a>
                                    <a @click="$refs['table'].toPage(props.data.list['current_page']+1)" v-else>
                                        <i class="fa fa-angle-double-up"></i>
                                        查看更多
                                    </a>
                                </div>
                                <div v-for="(row,i) in (props.data.list?props.data.list.data:[])">
                                    <item :value="row" :datas="props"></item>
                                </div>
                                <div v-for="(row,i) in send_data" v-if="sending">
                                    <item :value="row" :datas="props" :use-time="use_time"></item>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template slot="pager" slot-scope="props">
                        <div>
                            <div v-if="!(props.data.list?props.data.list.data:[]).length" class="m-b-10">
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
                                <div class="input-group-btn">
                                    <button type="button"
                                            class="btn btn-info"
                                            @mousedown="recording"
                                            @mouseup="stopRecording"
                                            :disabled="!row.ai_chat_id || audio.submiting"
                                    >
                                        <i class="fa" :class="audio.submiting?'fa-microphone-slash':'fa-microphone'"></i>
                                    </button>
                                </div>
                                <input class="form-control"
                                       v-model="row.content"
                                       :placeholder="audio.recording?'正在录音...':(audio.submiting?'语音识别中...':'发送一条消息')"
                                       @keyup.enter="postSend"
                                       :disabled="!row.ai_chat_id || audio.submiting"
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
    import Recorder from 'js-audio-recorder';
    export default {
        components:{
            'data-table':()=>import(/* webpackChunkName: "common_components/datatable.vue" */ 'common_components/datatable.vue'),
            elEmpty:()=>import(/* webpackChunkName: "element-ui/lib/input-number" */ 'element-ui/lib/empty'), //数字框异步组件
            "select2":()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),
            item: () => import(/* webpackChunkName: "pages/open/ai_messages/item.vue" */ 'pages/open/ai_messages/item.vue'),

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
                    ai_prompt_template:null,
                    role:1,
                },
                path:  (window.location.protocol=='https:'?'wss':'ws')+'://'+window.location.host, // 和上面开启的链接是一样的，只是换了ws协议
                socket:  null,
                sending:false, //消息发送中
                in_response:false, //消息响应中
                use_time:0,//使用时间
                interval:null,//计算器
                send_data:[
                    {
                        id:0,
                        role:1,
                        content:''
                    },
                    {
                        id:-1,
                        role:2,
                        content:'思考中...',
                        is_think:true
                    }
                ],
                audio:{ //音频
                    recording:false,
                    mediaRecorder:null,
                    chunks:[],
                    recorder:null,
                    submiting:false
                }
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
            initRecording(){
                this.audio.recorder = new Recorder({
                        sampleBits: 16,         // 采样位数，范围8或16
                        sampleRate: 16000,      // 采样率，范围11025、16000、22050、24000、44100、48000
                        numChannels: 1,         // 声道，范围1或2                    }
                    });
            /*    const constraints = { audio: true };
                // 获取音频流
                navigator.mediaDevices.getUserMedia(constraints)
                    .then((stream) =>{
                        // 创建一个 MediaRecorder 对象来录制音频
                        this.audio.mediaRecorder = new MediaRecorder(stream);

                        // 监听录音的数据块并保存它们
                        this.audio.mediaRecorder.addEventListener('dataavailable', (e)=> {
                            this.audio.chunks.push(e.data);
                        });

                        // 录音结束时，将数据块合并成单个Blob对象并发送给服务器
                        this.audio.mediaRecorder.addEventListener('stop', () =>{
                            const blob = new Blob(this.audio.chunks, { 'type' : 'audio/ogg; codecs=opus' });
                            //提交上传音频文件
                            this.postRecording(blob);
                        });
                    })
                    .catch(error => console.error(error));*/
            },
            //开始录音
            recording(){
                this.audio.recording = true;
                //this.audio.chunks = [];
                //this.audio.mediaRecorder.start();
                this.audio.recorder.start();
            },
            //停止录音
            stopRecording(){
                this.audio.recording = false;
                this.audio.recorder.stop();
                if(this.audio.recorder.duration>0.5){
                    this.postRecording();
                }
                //this.audio.mediaRecorder.stop();
            },
            postRecording(){
                if(this.audio.submiting){
                    return ;
                }
                this.audio.submiting = true;
                let blob = this.audio.recorder.getPCMBlob();
                // 创建 FormData 对象
                const formData = new FormData();
                // 将录音数据作为二进制文件添加到 FormData 中
                formData.append('audio', blob);
                // 发送 POST 请求
                axios.post(this.use_url+'/open/audio-to-text', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                   if(response.data.result){
                       this.row.content = response.data.result;
                   }
                    this.audio.submiting = false;
                }).catch(error => {
                    console.error(error);
                    this.audio.submiting = false;
                });
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
                let send_data = copyObj(this.send_data);
                let row = copyObj(this.row);
                send_data[0]= row;
                this.send_data=send_data;
                this.row.content='';
                axios.post(this.use_url+'/open/ai-messages', row).then( (response)=>{
                    this.sending=false;
                    if(response.data && response.data.init_message){
                        this.$refs.table.data.list.data.push(response.data.init_message);
                    }
                    if(response.data && response.data.question){
                        this.$refs.table.data.list.data.push(response.data.question);
                    }
                    if(response.data && response.data.answer){
                        this.$refs.table.data.list.data.push(response.data.answer);
                    }
                    this.use_time=0;
                }).catch((error) =>{
                    this.sending=false;
                    this.use_time=0;
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

            this.interval = window.setInterval(()=>{
                if(this.sending){
                    this.use_time++;
                }
            },1000);
            this.initRecording();


        },
        destroyed(){
            if(this.socket){
                this.socket.close();
            }
            if(this.interval){
                window.clearInterval(this.interval);
            }
            if(this.audio.recorder){
                this.audio.recorder.destroy();
            }
        }
    };
</script>
<style lang="scss" scoped>
.m-b-10{
    margin-bottom: 10px;
}

</style>
