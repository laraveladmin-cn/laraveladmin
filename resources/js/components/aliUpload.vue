<template>
    <div>
        <input v-show="false" type="file" ref="file" @change="changeFile" :accept="accept" />
        <button class="btn inline-block " :class="'btn-'+theme+' '+btnClass"
                onclick="return false;"
                :disabled="disabled_value"
                @click="selectFile">
            {{button_show}}
        </button>
        <div class="progress-group" v-show="file.name">
            <a class="progress-text name" @click="up" v-if="file.name && uping!=1">{{operation_show}}</a>
            <a class="progress-text name" @click="cancelUp" v-else-if="file.name && uping==1">{{$t('Pause uploading')}}</a>
            <span class="progress-number">{{percents.total}}%</span>
            <span>{{file.name}}</span>
            <div class="progress sm">
                <div class="progress-bar progress-bar-warning" :style="{width: percents.total+'%'}"></div>
            </div>
        </div>
        <slot>
            <div class="value" v-show="value">
                <div class="show-value" v-if="value_url">
                    <a target="_blank" :href="value_url" :title="value_url">{{value_url}}</a>
                </div>
                <i class="fa fa-times pull-right remove" @click="remove"></i>
            </div>
        </slot>
    </div>
</template>
<script>
import {mapActions, mapState} from 'vuex';
let md5 = require('md5');
export default {
    props: {
        //允许选择上传类型
        accept:{
            type:[String],
            default: function () {
                return '*/*';
            }
        },
        btnClass: {
            type: [String],
            default: function () {
                return '';
            }
        },
        tokenUrl: { //获取上传token
            type: [String],
            default: function () {
                return '/home/upload/alibaba-cloud-create-upload-video';
            }
        },
        refreshTokenUrl: { //获取上传token
            type: [String],
            default: function () {
                return '/home/upload/alibaba-cloud-refresh-upload-video';
            }
        },
        getPlayInfoUrl: { //获取上传token
            type: [String],
            default: function () {
                return '/admin/alibaba-cloud/get-play-info';
            }
        },
        value: {
            type:[String,Object], //上传成功后的url地址
            default: function () {
                return '';
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
        autoStart:{
            type:[Boolean],
            default: function () {
                return false;
            }
        },
        disabled:{
            default: function () {
                return false;
            }
        },
    },
    data() {
        return {
            updomain:'',
            uptoken:'', //上传token
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
            res:'', //上传成功后结果地址



            timeout: '',
            partSize: '',
            parallel: '',
            retryCount: '',
            retryDuration: '',
            region: 'cn-shanghai',
            userId: window.AppConfig.ali_cloud_user_id || '',
            file: {},
            authProgress: 0,
            uploadDisabled: true,
            resumeDisabled: true,
            pauseDisabled: true,
            uploader: null,
            statusText: '',
            file_name: '',
            key:'',
            file_path:'',
            initialized:false,
        }
    },
    computed: {
        ...mapState([
            '_token',
            'use_url',
            'theme'
        ]),
        button_show(){
            return this.uping==0?this.$t('Select the file'):this.$t('Reselect');//'选择文件':'重新选择';
        },
        operation_show(){
            return this.uping==0?this.$t('Start uploading'):(this.uping==3?this.$t('Upload completed'):this.$t('Keep uploading'));//'开始上传':(this.uping==3?'上传完成':'继续上传')
        },
        disabled_value(){
            return this.disabled || (this.file.name && this.uping==1);
        },
        value_url(){
            if(typeof this.value == 'string' && this.value){
                return this.value;
            }else if(typeof this.value=='object'){
                return this.value.play_url || '';
            }else {
                return '';
            }
        }
    },
    methods: {
        ...mapActions({
            pushMessage: 'pushMessage',
        }),
        destroy(){
            if(this.intervalTime){
                clearInterval(this.intervalTime);
                this.cancelUp();
            }
        },
        selectFile(){
            $(this.$el).find('input').trigger('click');
            this.$emit('blur');
            return false;
        },

        cancelUp(){ //暂停上传
            if(this.uping && this.uploader !== null){
                this.uploader.stopUpload()
                this.uping = 2; //暂停上传
                this.resumeDisabled = false
                this.pauseDisabled = true
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
        },
        changeFile(file){
            let file_new = file.target.files[0];
            if(!file_new){
                return;
            }
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
                let index1=this.file.name.lastIndexOf(".");
                let index2=this.file.name.length;
                let type=this.file.name.substring(index1,index2);
                this.key = md5(key_new)+type;

                this.$emit('changeFile',file_new);
                let userData = '{"Vod":{}}'
                if (this.uploader) {
                    this.uploader.stopUpload();
                    this.authProgress = 0;
                    this.statusText = "";
                }
                this.uploader = this.createUploader()
                this.uploader.addFile(this.file, null, null, null, userData)
                this.uploadDisabled = false
                this.pauseDisabled = true
                this.resumeDisabled = true
                this.file_name = file_new.name;
                if(this.autoStart){
                    this.up();
                }
            }
        },
        //开始上传
        up(){
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
            if(this.uping!=1 && this.uping!=3 && this.uploader !== null){ //没有上传时
                this.uping = 1; //正在上传
                this.uploader.startUpload()
                this.uploadDisabled = true
                this.pauseDisabled = false
            }
        },

        // 恢复上传
        resumeUpload() {
            if (this.uploader !== null) {
                this.uploader.startUpload()
                this.resumeDisabled = true
                this.pauseDisabled = false
            }
        },
        createUploader(type) {
            let self = this;
            let uploader = new AliyunUpload.Vod({
                timeout: self.timeout || 60000,
                partSize: Math.round(self.partSize || 1048576),
                parallel: self.parallel || 5,
                retryCount: self.retryCount || 3,
                retryDuration: self.retryDuration || 2,
                region: self.region,
                userId: self.userId,
                localCheckpoint: true, //此参数是禁用服务端缓存，不影响断点续传
                // 添加文件成功
                addFileSuccess: function (uploadInfo) {
                    self.uploadDisabled = false
                    self.resumeDisabled = false
                    self.file_name = uploadInfo.file.name;
                    self.statusText = '添加文件成功, 等待上传...'
                    //console.log("addFileSuccess: " + uploadInfo.file.name)
                },
                // 开始上传
                onUploadstarted: function (uploadInfo) {
                    // 如果是 UploadAuth 上传方式, 需要调用 uploader.setUploadAuthAndAddress 方法
                    // 如果是 UploadAuth 上传方式, 需要根据 uploadInfo.videoId是否有值，调用点播的不同接口获取uploadauth和uploadAddress
                    // 如果 uploadInfo.videoId 有值，调用刷新视频上传凭证接口，否则调用创建视频上传凭证接口
                    // 注意: 这里是测试 demo 所以直接调用了获取 UploadAuth 的测试接口, 用户在使用时需要判断 uploadInfo.videoId 存在与否从而调用 openApi
                    // 如果 uploadInfo.videoId 存在, 调用 刷新视频上传凭证接口(https://help.aliyun.com/document_detail/55408.html)
                    // 如果 uploadInfo.videoId 不存在,调用 获取视频上传地址和凭证接口(https://help.aliyun.com/document_detail/55407.html)
                    if (!uploadInfo.videoId) {
                        //let createUrl = 'https://demo-vod.cn-shanghai.aliyuncs.com/voddemo/CreateUploadVideo?Title=testvod1&FileName=aa.mp4&BusinessType=vodai&TerminalType=pc&DeviceModel=iPhone9,2&UUID=59ECA-4193-4695-94DD-7E1247288&AppVersion=1.0.0&VideoId=5bfcc7864fc14b96972842172207c9e6'
                        let createUrl = self.use_url + self.tokenUrl;
                        axios.get(createUrl, {
                            params: {
                                file_name: self.file_name,
                                key:self.key
                            }
                        }).then(({data}) => {
                            let uploadAuth = data.UploadAuth
                            let uploadAddress = data.UploadAddress
                            let videoId = data.VideoId
                            self.file_path = data.file_path;
                            uploader.setUploadAuthAndAddress(uploadInfo, uploadAuth, uploadAddress, videoId)
                        })
                        //self.statusText = '文件开始上传...'
                        //console.log("onUploadStarted:" + uploadInfo.file.name + ", endpoint:" + uploadInfo.endpoint + ", bucket:" + uploadInfo.bucket + ", object:" + uploadInfo.object)
                    } else {
                        // 如果videoId有值，根据videoId刷新上传凭证
                        // https://help.aliyun.com/document_detail/55408.html?spm=a2c4g.11186623.6.630.BoYYcY
                        //let refreshUrl = 'https://demo-vod.cn-shanghai.aliyuncs.com/voddemo/RefreshUploadVideo?BusinessType=vodai&TerminalType=pc&DeviceModel=iPhone9,2&UUID=59ECA-4193-4695-94DD-7E1247288&AppVersion=1.0.0&Title=haha1&FileName=xxx.mp4&VideoId=' + uploadInfo.videoId
                        let refreshUrl = self.use_url + self.refreshTokenUrl;
                        axios.get(refreshUrl, {
                            params: {
                                video_id: uploadInfo.videoId
                            }
                        }).then(({data}) => {
                            let uploadAuth = data.UploadAuth
                            let uploadAddress = data.UploadAddress
                            let videoId = data.VideoId
                            uploader.setUploadAuthAndAddress(uploadInfo, uploadAuth, uploadAddress, videoId)
                        })
                    }
                },

                // 文件上传失败
                onUploadFailed: function (uploadInfo, code, message) {
                    dd(uploadInfo, code, message);
                    //console.log("onUploadFailed: file:" + uploadInfo.file.name + ",code:" + code + ", message:" + message)
                    self.statusText = '文件上传失败!'
                },
                // 取消文件上传
                onUploadCanceled: function (uploadInfo, code, message) {
                    //console.log("Canceled file: " + uploadInfo.file.name + ", code: " + code + ", message:" + message)
                    self.statusText = '文件已暂停上传'
                },
                // 文件上传进度，单位：字节, 可以在这个函数中拿到上传进度并显示在页面上
                onUploadProgress: function (uploadInfo, totalSize, progress) {
                    //console.log("onUploadProgress:file:" + uploadInfo.file.name + ", fileSize:" + totalSize + ", percent:" + Math.ceil(progress * 100) + "%")
                    let progressPercent = Math.ceil(progress * 100).toFixed(2);
                    if(progressPercent!=self.authProgress){
                        self.authProgress = progressPercent
                        self.percents.total = progressPercent-0;
                        self.statusText = '文件上传中...'
                    }
                },
                // 上传凭证超时
                onUploadTokenExpired: function (uploadInfo) {
                    // 上传大文件超时, 如果是上传方式一即根据 UploadAuth 上传时
                    // 需要根据 uploadInfo.videoId 调用刷新视频上传凭证接口(https://help.aliyun.com/document_detail/55408.html)重新获取 UploadAuth
                    // 然后调用 resumeUploadWithAuth 方法, 这里是测试接口, 所以我直接获取了 UploadAuth
                    //let refreshUrl = 'https://demo-vod.cn-shanghai.aliyuncs.com/voddemo/RefreshUploadVideo?BusinessType=vodai&TerminalType=pc&DeviceModel=iPhone9,2&UUID=59ECA-4193-4695-94DD-7E1247288&AppVersion=1.0.0&Title=haha1&FileName=xxx.mp4&VideoId=' + uploadInfo.videoId
                    let refreshUrl = self.use_url + self.refreshTokenUrl;

                    axios.get(refreshUrl, {
                        params: {
                            video_id: uploadInfo.videoId
                        }
                    }).then(({data}) => {
                        let uploadAuth = data.UploadAuth
                        uploader.resumeUploadWithAuth(uploadAuth)
                        //console.log('upload expired and resume upload with uploadauth ' + uploadAuth)
                    })
                    self.statusText = '文件超时...'
                },
                // 文件上传成功
                onUploadSucceed: function (uploadInfo) {
                    dd(uploadInfo)
                    self.statusText = '文件上传成功!'
                    let value = self.file_path;
                    if (value.substr(0,1)!='/'){
                        value = '/'+value;
                    }
                    uploadInfo.file_path = value;
                    let obj = collect(uploadInfo).only([
                        'videoId',
                        'fileHash',
                        'fileMd5',
                        'bucket',
                        'endpoint',
                        'file_path',
                        'object',
                        'state',
                        'userData'
                    ]).all();
                    dd(obj);
                    self.$emit('input', obj); //修改值
                    self.$emit('change',obj); //修改值
                    self.res = obj;
                    self.uping = 3;
                    //更新视频地址信息
                    /*  axios.get(self.use_url+self.getPlayInfoUrl, {
                          params: {
                              video_id: uploadInfo.videoId
                          }
                      }).then(({data}) => {
                          for(data in index){
                              uploadInfo[index] = data[index];
                          }
                          self.$emit('input', uploadInfo); //修改值
                          self.$emit('change',uploadInfo); //修改值
                      })*/
                },
                // 全部文件上传结束
                onUploadEnd: function (uploadInfo) {

                    //console.log("onUploadEnd: uploaded all the files")
                    self.statusText = '文件上传完毕'
                }
            })
            return uploader
        }
    },
    watch:{
        value(val,old){

        }
    },
    created() {
        //动态加载js文件
        if(!document.getElementById('aliyun-upload-sdk')){
            let $script = document.createElement('script');
            $script.id = 'aliyun-upload-sdk';
            $script.type = 'text/javascript';
            $script.src = '/bower_components/aliyun-upload-sdk/aliyun-upload-sdk-1.5.5.min.js';
            $script.async = false;
            document.body.appendChild($script);
            $script = document.createElement('script');
            $script.id = 'es6-promise';
            $script.type = 'text/javascript';
            $script.async = false;
            $script.src = '/bower_components/aliyun-upload-sdk/lib/es6-promise.min.js';
            document.body.appendChild($script);
            $script = document.createElement('script');
            $script.id = 'aliyun-oss-sdk';
            $script.type = 'text/javascript';
            $script.async = false;
            $script.src = '/bower_components/aliyun-upload-sdk/lib/aliyun-oss-sdk-6.17.1.min.js';
            document.body.appendChild($script);
        }
    },
    mounted() {
        this.intervalTime = setInterval(()=>{
            if(typeof AliyunUpload=="object"){
                clearInterval(this.intervalTime);
                this.initialized = true;
            }
        },100);
    },
    updated(){

    },
    beforeDestroy() {
        this.destroy();
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
