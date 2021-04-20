<template>
    <div>
        <el-upload class="avatar-uploader"
                   :action="use_url+action"
                   :show-file-list="false"
                   :on-success="handleAvatarSuccess"
                   :on-error="handleAvatarError"
                   @click="$emit('blur')"
                   :data="{_token:_token}"
                   :headers="headers"
                   name="file"
                   :before-upload="beforeAvatarUpload">
            <img v-if="value || placeholderValue" :src="showurl" class="avatar" :width="width+'px'" :height="height+'px'">
            <i v-else class="el-icon-plus avatar-uploader-icon avatar" :style="'line-height: '+height+'px;height:'+height+'px;width:'+width+'px'"></i>
        </el-upload>
    </div>
</template>
<style lang="scss">
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader input{
        display: none;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #20a0ff;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        text-align: center;
    }
    .avatar {
        display: block;
    }
</style>
<script>
    import ElUpload from 'element-ui/lib/upload';
    import { mapState, mapActions, mapMutations, mapGetters } from 'vuex';
    export default {
        components: {
            'el-upload':ElUpload
        },
        data(){
            return {
                parm:''
            };
        },

        props:{
            value: {
                type:[String],
                default: function () {
                    return '';
                }
            },
            disabled:{
                default: function () {
                    return false;
                }
            },
            action:{
                default: function () {
                    return '/home/upload/index?type=image';
                }
            },
            width:{
                type:[Number,String],
                default:178
            },
            height:{
                type:[Number,String],
                default:178
            },
            noparm:{
                type:[Boolean],
                default:false
            },
            valueKey:{
                type:[String],
                default: function () {
                    return 'url';
                }
            },
            placeholderValue:{
                type:[String],
                default: function () {
                    return '';
                }
            },
        },
        methods:{
            ...mapActions({
                refreshToken: 'refreshToken',
                pushMessage: 'pushMessage',
            }),
            ...mapMutations({
                set:'set'
            }),
            handleAvatarSuccess(res, file){
                this.refreshToken();
                let $this = this;
                //弹窗
                if (typeof res != 'undefined' && typeof res.alert != 'undefined' && res.alert) {
                    this.pushMessage(res.alert);
                }
                if(res.state=='SUCCESS'){
                    let url = res.url;
                    if(this.noparm){
                        let urls = url.split("?");
                        this.parm = urls[1];
                        url = urls[0];
                    }
                    url = this.valueKey=='url'?url:res.title;
                    this.$emit('input',url); //修改值
                    this.$emit('change',url); //修改值
                }
            },
            beforeAvatarUpload(){

            },
            handleAvatarError(res){
                let errors = JSON.parse(res.message);
                this.pushMessage({
                    'showClose':true,
                    'title':this.$t('{action} failed!',{action:this.$t('Upload')}),
                    'message':array_get(errors,'errors.file.0') || '',
                    'type':'danger',
                    'position':'top',
                    'iconClass':'fa-warning',
                    'customClass':'',
                    'duration':3000,
                    'show':true
                });
            }
        },
        computed:{
            showurl(){
                if(!this.value){
                    return this.placeholderValue;
                }
                if(this.value.indexOf('?')!=-1){
                    return this.value+'&'+this.parm;
                }
                return this.value+'?'+this.parm;
            },
            ...mapState([
                '_token',
                'use_url',
            ]),
            headers(){
                let headers = {
                    Accept:'application/json, text/plain, */*'
                };
                let token = getCookie('Authorization');
                if(token){
                    headers.Authorization= decodeURIComponent(token);
                }
                return headers;
            }
        },
        watch:{

        },
        mounted() {

        },
        updated(){

        }
    }
</script>
