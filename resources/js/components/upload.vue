<template>
    <div :class="{'disabled':disabled}">
        <div v-if="isArray">
            <el-upload :name="fileKey"
                       class="avatar-uploader"
                       :action="url"
                       :list-type="listType"
                       :file-list="val"
                       :data="{_token:_token}"
                       :headers="headers"
                       :disabled="disabled"
                       @click="$emit('blur')"
                       :before-upload="beforeAvatarUpload"
                       :on-error="handleAvatarError"
                       :on-remove="handleRemove"
                       :accept="accept_str"
                       :on-success="handleSuccess">
                <slot>
                    <button type="button" class="btn" :class="'btn-'+theme" :disabled="disabled">{{$t('Click Upload')}}</button>
                </slot>
            </el-upload>
        </div>
        <div v-else class="single">
            <el-upload class="avatar-uploader"
                       :name="fileKey"
                       :action="url"
                       :show-file-list="false"
                       :on-success="handleAvatarSuccess"
                       :on-error="handleAvatarError"
                       @click="$emit('blur')"
                       :data="{_token:_token}"
                       :headers="headers"
                       :accept="accept_str"
                       :disabled="disabled"
                       :before-upload="beforeAvatarUpload">
                <slot>
                    <img v-if="value || placeholderValue" :src="show_url" class="avatar" :width="width+'px'" :height="height+'px'">
                    <i v-else class="el-icon-plus avatar-uploader-icon avatar" :style="'line-height: '+height+'px;height:'+height+'px;width:'+width+'px'"></i>
                </slot>
            </el-upload>
        </div>
    </div>
</template>
<style lang="scss">
   .single .avatar-uploader .el-upload {
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
    import { mapState, mapActions, mapMutations, mapGetters } from 'vuex';
    export default {
        components: {
            'el-upload': ()=>import(/* webpackChunkName: "element-ui/lib/upload" */ 'element-ui/lib/upload'),
        },
        data(){
            return {
                parm:'',
                val:this.value
            };
        },

        props:{
            listType:{
                type:[String],
                default: function () {
                    return 'picture';
                }
            },
            accept:{
                type:[String,Array],
                default: function () {
                    return '';
                }
            },
            value: {
                type:[String,Array],
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
            fileKey:{
                type:[String],
                default: function () {
                    return 'file';
                }
            }
        },
        methods:{
            ...mapActions({
                refreshToken: 'refreshToken',
                pushMessage: 'pushMessage',
            }),
            ...mapMutations({
                set:'set'
            }),
            handleRemove(file, fileList) {
                this.val = collect(this.val).filter( (item) =>{
                    return item['url'] != file[this.valueKey];
                }).values().all();
            },
            getUrl(res){
                let url = array_get(res,this.valueKey,'') || res.title || '';
                if(this.noparm){
                    let urls = url.split("?");
                    this.parm = urls[1];
                    url = urls[0];
                }
                return url;
            },
            handleSuccess(file, fileList) {
                file.url = this.getUrl(file);
                this.val.push(file);
            },
            handleAvatarSuccess(res, file){
                this.refreshToken();
                let url = this.getUrl(res);
                if(url){
                    //弹窗
                    if (typeof res != 'undefined' && typeof res.alert != 'undefined' && res.alert) {
                        this.pushMessage(res.alert);
                    }
                    this.$emit('input',url); //修改值
                    this.$emit('change',url); //修改值
                }else {
                    //弹窗
                    if (typeof res != 'undefined' && typeof res.alert != 'undefined' && res.alert) {
                        this.pushMessage(res.alert);
                    }else {
                        this.pushMessage({
                            'showClose':true,
                            'title':this.$t('{action} failed!',{action:this.$t('Upload')}),
                            'message':this.$t('{action} failed!',{action:this.$t('Upload')}),
                            'type':'danger',
                            'position':'top',
                            'iconClass':'fa-warning',
                            'customClass':'',
                            'duration':3000,
                            'show':true
                        });
                    }
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
            accept_str(){
              if(typeof this.accept== "string"){
                  return this.accept;
              }
              return collect(this.accept).implode(',');
            },
            show_url(){
                if(!this.value){
                    return this.placeholderValue;
                }
                if(this.value.indexOf('?')!=-1){
                    return this.value+'&'+this.parm;
                }
                return this.parm?this.value+'?'+this.parm:this.value;
            },
            ...mapState([
                '_token',
                'use_url',
                'theme'
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
            },
            isArray(){
                return typeof this.val=="object" && this.val!==null;
            },
            url(){
                if(this.action.indexOf('https://')==0 || this.action.indexOf('http://')==0 || this.action.indexOf('//')==0){
                    return this.action;
                }
                return this.use_url+this.action;
            }
        },
        watch:{
            value(val){
                if(this.val!=val || (typeof this.val)!=(typeof val)){
                    this.val = val;
                }
            },
            val(val){
                if(this.value!=val){
                    this.$emit('input', val); //修改值
                    this.$emit('change',val); //修改值
                }
            }
        },
        mounted() {

        },
        updated(){

        }
    }
</script>
