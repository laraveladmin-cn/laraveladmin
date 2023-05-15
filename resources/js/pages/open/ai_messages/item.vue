<template>
    <div class="item" :class="row.role==1?'text-right':''">
        <img :src="getImg(row,datas)"
             alt="user image"
             class="user-imge"
             :class="row.role==1?'offline':'online'"
        >
        <p class="message"  :class="row.role==1?'right-message':''" >
            <a  class="name">
                <small class="text-muted" :class="row.role==1?'pull-left':'pull-right'">
                    <i class="fa fa-clock-o" v-show="row.is_think || row.created"></i>
                    {{row.is_think?useTime+'秒':row.created}}
                </small>
                {{getName(row,datas)}}
            </a>
<!--            <markdown-view class="no-padding" v-model="row.content" :id="'editormd_'+row.id"></markdown-view>-->
            <span style="white-space: pre-line;">{{row.content}}</span>
            <span @click="pay" v-if="row.role==2 && !row.is_think">
                <i class="fa" :class="submiting?'fa-spinner rotation':'fa-play-circle'"></i>
            </span>
        </p>
    </div>
</template>

<script>
import {mapState} from 'vuex';
export default {
    name: "item.vue",
    components:{
        "markdown-view": ()=>import(/* webpackChunkName: "common_components/markdownView.vue" */ 'common_components/markdownView.vue'),
    },
    props:{
        value:{
            default:function () {
                return '';
            }
        },
        maps:{
            default:function () {
                return {};
            }
        },
        datas:{
            default:function () {
                return {};
            }
        },
        useTime:{
            default:function () {
                return 0;
            }
        },
    },
    data(){
        return {
            row:this.value || {},
            submiting:false,
            audio:null
        };
    },
    watch:{
        value(val){
            if(this.val!=val){
                this.row = val;
            }
        },
        val(val){
            this.$emit('input', val); //修改值
            this.$emit('change',val); //修改值
        }
    },
    methods:{
        //播放语音
        pay(){
            if(this.row.read_url){
                this.read();
                return;
            }
            if(this.submiting){
                return;
            }
            this.submiting = true;
            axios.post(this.use_url+'/open/read-text', {
                "text":this.row.content,
                "id":this.row.id,
            }).then( (response)=>{
                if(response.status==200){
                    this.row.read_url = response.data.url;
                    this.read();
                }
                this.submiting = false;
            }).catch((error) =>{
                this.submiting = false;
            });
        },
        read(){
            if(!this.audio){
                this.audio = new Audio(this.row.read_url);
            }
            this.audio.play();
        },
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
    }
}
</script>

<style scoped>
.chat .item>.right-message{
    margin-right: 55px;
    margin-left: 0px;
}

.user-imge{
    border: none !important;
    border-radius: unset !important;
}
.rotation {
    /* 设置元素初始状态 */
    transform: rotate(0deg);

    /* 定义动画的名称、时间和速度曲线 */
    animation: rotate 2s linear infinite;
}

/* 定义名为 rotate 的动画 */
@keyframes rotate {
    /* 定义动画从 0% 到 100% 的关键帧变化 */
    from {
        /* 设置旋转角度为0度 */
        transform: rotate(0deg);
    }
    to {
        /* 设置旋转角度为360度 */
        transform: rotate(360deg);
    }
}
</style>
