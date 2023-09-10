<template>
<div>
    <button type="button" class="btn btn-block btn-primary" @click="stop" v-if="speaking">停止</button>
    <button type="button" class="btn btn-block btn-info" @click="start" v-else>开始</button>
    <div>{{data}}</div>
</div>
</template>

<script>
import {mapState, mapActions} from 'vuex';
let $this;

/**
 * 实时语音转文字
 */
export default {
    name: "speechToText",
    props:{
        //绑定值
        value: {
            type:[String, Number],
            default: function () {
                return '';
            }
        },
        //绑定值
        config: {
            type:[Object],
            default: function () {
                return {
                    // 用户参数
                    secretid:  window.AppConfig.tencent_cloud.secretid,
                    appid: window.AppConfig.tencent_cloud.appid,
                    // 实时识别接口参数
                    engine_model_type : '16k_zh', // 因为内置WebRecorder采样16k的数据，所以参数 engineModelType 需要选择16k的引擎，为 '16k_zh'
                    // 以下为非必填参数，可跟据业务自行修改
                    voice_format : 1,
                    hotword_id : '08003a00000000000000000000000000',
                    needvad: 1,
                    filter_dirty: 1,
                    filter_modal: 2,
                    filter_punc: 0,
                    convert_num_mode : 1,
                    word_info: 2
                };
            }
        },
    },
    data(){
        return {
            intervalTime:null,
            data:this.value,
            loading:true,
            webAudioSpeechRecognizer:null,
            speaking:false,
            chage_text:'',
            text:this.value
        };
    },
    created(){
        //动态加载js文件
        if(!document.getElementById('speechrecognizer-js')){
            let $script = document.createElement('script');
            $script.id = 'speechrecognizer-js';
            $script.type = 'text/javascript';
            $script.src = '/dist/js/speechrecognizer.js';
            $script.async = false;
            document.body.appendChild($script);
        }
    },
    mounted() {
        $this = this;
        this.intervalTime = setInterval(()=>{
            if(typeof window.WebAudioSpeechRecognizer=="function"){
                clearInterval(this.intervalTime);
                this.loading=false;
                //this.initWebAudioSpeechRecognizer();
            }
        },100);
    },
    methods:{
        ...mapActions({
            refreshToken: 'refreshToken',
            pushMessage: 'pushMessage',
        }),
        start(){
             if(!this.loading && !this.speaking){
                //dd('开始识别语音...');
                this.initWebAudioSpeechRecognizer();
                this.webAudioSpeechRecognizer.start();
            }
        },
        stop(){
            if(this.speaking && this.webAudioSpeechRecognizer){
                //dd('停止');
                this.speaking = false;
                this.webAudioSpeechRecognizer.stop();
            }
        },
        initWebAudioSpeechRecognizer(){
            let params = copyObj(this.config);
            params.signCallback = (str)=>{
                return this.signCallback(str);
            };
            //dd(params);
            let webAudioSpeechRecognizer
                = this.webAudioSpeechRecognizer
                = new WebAudioSpeechRecognizer(params);
            // 开始识别
            webAudioSpeechRecognizer.OnRecognitionStart = (res) => {
                this.speaking = true;
                dd('开始识别', res);
            };
            // 一句话开始
            webAudioSpeechRecognizer.OnSentenceBegin = (res) => {
                dd('一句话开始', res);
            };
            // 识别变化时
            webAudioSpeechRecognizer.OnRecognitionResultChange = (res) => {
                dd('识别变化时', res);
                this.chage_text = res.result.voice_text_str;
                this.data = this.text+this.chage_text;
                $this.$emit('input', this.data); //修改值
                $this.$emit('change',this.data); //修改值
            };
            // 一句话结束
            webAudioSpeechRecognizer.OnSentenceEnd = (res) => {
                dd('一句话结束', res);
                this.chage_text = '';
                this.text += res.result.voice_text_str;
                this.data = this.text;
                $this.$emit('input', this.data); //修改值
                $this.$emit('change',this.data); //修改值

            };
            // 识别结束
            webAudioSpeechRecognizer.OnRecognitionComplete = (res) => {
                dd('识别结束', res);
                this.speaking = false;
            };
            // 识别错误
            webAudioSpeechRecognizer.OnError = (res) => {
                dd('识别失败', res);
                this.speaking = false;
            };


        },
        async signCallback(signStr){
            let response;
            try {
                response = await axios.post(this.use_url+'/open/tencent-cloud/signature', {
                    sign_str:signStr
                });
            } catch (error) {
                console.error(error);
                this.refreshToken();
                return '';
            }
            this.refreshToken();
            //dd(response);
            if(response && response.data && response.data.signature){
                return response.data.signature;
            }
            return '';

            /** 获取签名 start */
/*
            function toUint8Array(wordArray) {
                // Shortcuts
                const words = wordArray.words;
                const sigBytes = wordArray.sigBytes;

                // Convert
                const u8 = new Uint8Array(sigBytes);
                for (let i = 0; i < sigBytes; i++) {
                    u8[i] = (words[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff;
                }
                return u8;
            }

            function Uint8ArrayToString(fileData){
                let dataString = '';
                for (let i = 0; i < fileData.length; i++) {
                    dataString += String.fromCharCode(fileData[i]);
                }
                return dataString;
            }
            const secretKey = '';
            const hash = window.CryptoJSTest.HmacSHA1(signStr, secretKey);
            const bytes = Uint8ArrayToString(toUint8Array(hash));
            str = window.btoa(bytes);
            dd(str);
            return str;*/
        }

    },
    watch: {
        value(val,old){
            if(this.data!==val){
                this.data = val;
            }
        },
        config(val,old){
            this.stop();
        }
    },
    computed:{
        ...mapState([
            '_token',
            'use_url',
        ]),
    },
}
</script>

<style scoped>

</style>
