<template>
    <div>
        <input v-show="false" type="file" @change="changeFile" :accept="accept" />
        <button class="btn btn-block btn-primary btn-sm btn-select"
                onclick="return false;"
                :disabled="file.name && uping==1"
                @click="selectFile">
            {{button_show}}
        </button>
        <div class="progress-group" v-show="file.name">
            <a class="progress-text name" @click="up" v-if="file.name && uping!=1">{{operation_show}}</a>
            <a class="progress-text name" @click="cancelUp" v-else-if="file.name && uping==1">{{$t('Pause uploading')}}</a>
            <span class="progress-number">{{percents.total.toFixed(2)}}%</span>
            <span>{{file.name}}</span>
            <div class="progress sm">
                <div class="progress-bar progress-bar-warning" :style="{width: percents.total+'%'}"></div>
            </div>
        </div>
        <slot>
            <div class="value">
                <a target="_blank" :href="value">{{value}}</a>
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
            }
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
            getToken(){
                if(this.token){
                    this.uptoken = this.token;
                }else {
                    axios.get(this.use_url+this.tokenUrl).then( (response)=> {
                        this.uptoken = response.data.token;
                        this.updomain = response.data.domain;
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
                    this.observable = qiniu.upload(this.file, key, this.uptoken, this.putExtra, this.config);
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
                    let $this = this;
                    this.uping = 1; //正在上传
                    this.subscription = this.observable.subscribe({
                        next(response) { //获取进度
                            var chunks = response.chunks||[];
                            $this.percents.chunks = collect(chunks).pluck('percent').all();
                            $this.percents.total = response.total.percent; //总进度
                        },
                        error(err){
                            //console.log(err);
                            //alert('上传出错');
                            $this.$store.commit('alert', {
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
                        complete(res){
                            //console.log(res);
                            let value = res.key;
                            if (value.substr(0,1)!='/'){
                                value = '/'+value;
                            }
                            value = $this.updomain+value;
                            $this.$emit('input', value); //修改值
                            $this.$emit('change',value); //修改值
                            $this.res = value;
                            $this.uping = 3;
                        }
                    }) // 上传开始
                }
            },
            cancelUp(){ //暂停上传
                if(this.uping){
                    this.subscription.unsubscribe(); // 上传取消
                    this.uping = 2; //暂停上传
                }

            }

        },
        mounted() {
            this.getToken();
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
        }

    }
</script>
<style lang="scss" scoped>
    .btn-select{
        width: 90px;
    }
    .value{
        min-height: 20px;
    }
    .progress{
        margin-bottom: 0px;
    }
</style>
