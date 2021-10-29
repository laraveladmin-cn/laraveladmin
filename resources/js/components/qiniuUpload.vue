<template>
    <div>
        <input v-show="false" type="file" ref="file" @change="changeFile" :accept="accept" />
        <button class="btn btn-primary btn-sm inline-block"
                onclick="return false;"
                :disabled="file.name && uping==1"
                @click="selectFile">
            {{button_show}}
        </button>
        <div class="progress-group" v-show="file.name">
            <a class="progress-text name" @click="up" v-if="file.name && uping!=1">{{operation_show}}</a>
            <a class="progress-text name" @click="cancelUp" v-else-if="file.name && uping==1">{{$t('Pause uploading')}}</a>
            <span class="progress-number">{{percents.total.toFixed(2)-0}}%</span>
            <span>{{file.name}}</span>
            <div class="progress sm">
                <div class="progress-bar progress-bar-warning" :style="{width: percents.total+'%'}"></div>
            </div>
        </div>
        <slot>
            <div class="value" v-show="value">
                <div class="show-value">
                    <a target="_blank" :href="value" :title="value">{{value}}</a>
                </div>
                <i class="fa fa-times pull-right remove" @click="remove"></i>
            </div>
        </slot>
    </div>
</template>

<script>
    import {mapActions,mapState} from 'vuex';
    let qiniu = require('qiniu-js');
    let md5 = require('md5');
    export default {
        components: {
        },
        props:{
            //允许选择上传类型
            accept:{
                type:[String],
                default: function () {
                    return '*/*';
                }
            },
            tokenUrl:{ //获取上传token
                type:[String],
                default: function () {
                    return '/open/qiniu/token';
                }
            },
            token:{ //上传token直接传入
                type:[String],
                default: function () {
                    return '';
                }
            },
            domain:{
                type:[String],
                default: function () {
                    return '';
                }
            },
            value: {
                type:[String], //上传成功后的url地址
                default: function () {
                    return '';
                }
            },
            rootPath:{
                type:[String],
                default: function () {
                    return 'uploads/videos/';
                }
            },
            autoStart:{
                type:[Boolean],
                default: function () {
                    return false;
                }
            },

        },
        data(){
            return {
                updomain:'',
                uptoken:'', //上传token
                file:{},
                observable:{},
                putExtra:{
                    fname: "", //文件原文件名
                    params: {}, //上传参数
                    mimeType: null //上传文件类型限制["image/png", "image/jpeg", "image/gif"]
                },
                config:{
                    useCdnDomain: true,
                    disableStatisticsReport: false
                },
                percents:{ //上传进度
                    total:0, //总进度
                    chunks:[] //分块进度
                },
                subscription:{},
                uping:0, //上传状态 0-开始上传,1-正在上传,2-暂停上传,3-完成
                res:'' //上传成功后结果地址
            };
        },
        methods:{
            ...mapActions({
                pushMessage: 'pushMessage',
            }),
            //获取token
            getToken(callback,key){
                if(this.token){
                    this.uptoken = this.token;
                    callback();
                }else {
                    axios.get(this.use_url+this.tokenUrl,{
                        params:{key:key}
                    }).then( (response)=> {
                        this.uptoken = response.data.token;
                        this.updomain = response.data.domain;
                        callback();
                    }).catch( (error) =>{
                        this.$store.commit('alert', {
                            'showClose': true,
                            'title': this.$t('The upload component failed to get toke, the file will not be uploaded!'), //'上传组件获取toke失败,将无法上传文件!',
                            'position': 'top',
                            'message': '',
                            'type': 'danger',
                            'iconClass': '',
                            'customClass': '',
                            'duration': 3000,
                            'show': true
                        });
                    });
                }
            },
            selectFile(){
                $(this.$el).find('input').trigger('click');
                this.$emit('blur');
                return false;
            },
            changeFile(file){
                let file_new = file.target.files[0];
                let key_new = ''+file_new.lastModified+file_new.name+file_new.size;
                let key_old = ''+this.file.lastModified+this.file.name+this.file.size;
                //选择不同文件时,取消上传
                if(key_new != key_old){
                    this.uping = 0;
                    this.percents = {
                        total:0, //总进度
                        chunks:[] //分块进度
                    };
                    this.subscription = {};
                    this.file = file_new; //获取上传文件
                    this.putExtra.params["x:name"] = this.file.name.split(".")[0];
                    let date = new Date();
                    let Y = date.getFullYear() + '/';
                    let M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '/';
                    let D = date.getDate() + '/';
                    let index1=this.file.name.lastIndexOf(".");
                    let index2=this.file.name.length;
                    let type=this.file.name.substring(index1,index2);
                    let key = this.rootPath+Y+M+D+md5(key_new)+type;
                    this.getToken(()=>{
                        this.observable = qiniu.upload(this.file, key, this.uptoken, this.putExtra, this.config);
                        if(this.autoStart){
                            this.up();
                        }
                    },key);
                }

            },
            //开始上传
            up(){
                if(!this.uptoken){
                    this.$store.commit('alert', {
                        'showClose': true,
                        'title': this.$t('The upload component failed to get toke, the file will not be uploaded!'),//'上传组件获取toke失败,将无法上传文件!',
                        'position': 'top',
                        'message': '',
                        'type': 'danger',
                        'iconClass': '',
                        'customClass': '',
                        'duration': 3000,
                        'show': true
                    });
                    return;
                }
                if(typeof this.file.name =="undefined"){
                    this.$store.commit('alert', {
                        'showClose': true,
                        'title': this.$t('Please select the file'),
                        'position': 'top',
                        'message': '',
                        'type': 'danger',
                        'iconClass': '',
                        'customClass': '',
                        'duration': 3000,
                        'show': true
                    });
                    return ;
                }
                if(this.uping!=1 && this.uping!=3){ //没有上传时
                    this.uping = 1; //正在上传
                    this.subscription = this.observable.subscribe({
                        next:(response)=> { //获取进度
                            var chunks = response.chunks||[];
                            this.percents.chunks = collect(chunks).pluck('percent').all();
                            this.percents.total = response.total.percent; //总进度
                        },
                        error:(err)=>{
                            this.cancelUp();
                            console.log(err);
                            this.$store.commit('alert', {
                                'showClose': true,
                                'title': this.$t('{action} failed!',{action:this.$t('Upload')}),
                                'position': 'top',
                                'message': '',
                                'type': 'danger',
                                'iconClass': '',
                                'customClass': '',
                                'duration': 3000,
                                'show': true
                            });
                        },
                        complete:(res)=>{
                            //console.log(res);
                            let value = res.key;
                            if (value.substr(0,1)!='/'){
                                value = '/'+value;
                            }
                            value = this.updomain+value;
                            this.$emit('input', value); //修改值
                            this.$emit('change',value); //修改值
                            this.res = value;
                            this.uping = 3;
                        }
                    }) // 上传开始
                }
            },
            cancelUp(){ //暂停上传
                if(this.uping){
                    this.subscription.unsubscribe(); // 上传取消
                    this.uping = 2; //暂停上传
                }

            },
            remove(){
                if(this.value){
                    this.$emit('input', ''); //修改值
                    this.$emit('change',''); //修改值
                    this.cancelUp();
                    this.uping=0;
                    this.file = {};
                    this.$refs['file'].value='';
                }
            }

        },
        mounted() {
            //this.getToken();
        },
        computed:{
            ...mapState([
                '_token',
                'use_url',
            ]),
            button_show(){
                return this.uping==0?this.$t('Select the file'):this.$t('Reselect');//'选择文件':'重新选择';
            },
            operation_show(){
                return this.uping==0?this.$t('Start uploading'):(this.uping==3?this.$t('Upload completed'):this.$t('Keep uploading'));//'开始上传':(this.uping==3?'上传完成':'继续上传')
            }
        },
        watch:{
            value(val,old){

            }
        }

    }
</script>
<style lang="scss" scoped>
    .value{
        min-height: 20px;
    }
    .progress{
        margin-bottom: 0px;
    }
    .show-value{
        display: inline-block;
        width: calc(100% - 20px);
        overflow:hidden; //超出的文本隐藏
        text-overflow:ellipsis; //溢出用省略号显示
        white-space:nowrap; //溢出不换行
    }
    .remove{
        margin-top: 3px;
    }
</style>
