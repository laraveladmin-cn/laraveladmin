<template>
    <div v-show="show" @mouseout="mouseoutEvent">
        <textarea :id="id" :placeholder="$t(options.placeholder)">
            {{value}}
        </textarea>
    </div>
</template>

<script>
    import { mapState, mapActions, mapMutations, mapGetters } from 'vuex';
    export default {
        name: "tinymce",
        props:{
            disabled:{
                default:function () {
                    return false;
                }
            },
            value:{
                type:[String],
                default:function () {
                    return undefined;
                }
            },
            id:{
                type:[String],
                default:function () {
                    return 'tinymce';
                }
            },
            action:{
                default: function () {
                    return '/home/upload/index';
                }
            },
            options:{
                type:[Object],
                default:function () {
                    return {
                       // selector: '#tinymce',
                        //skin:'oxide-dark',
                        placeholder:'Please enter',
                        readonly:false,
                        language:'zh_CN',
                        plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template code codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists wordcount imagetools textpattern help emoticons autosave',//bdmap indent2em autoresize formatpainter axupimgs
                        toolbar: 'code undo redo restoredraft | cut copy paste pastetext | forecolor backcolor bold italic underline strikethrough link anchor | alignleft aligncenter alignright alignjustify outdent indent | \
    styleselect formatselect fontselect fontsizeselect | bullist numlist | blockquote subscript superscript removeformat | \
    table image media charmap emoticons hr pagebreak insertdatetime print preview | fullscreen | bdmap indent2em lineheight formatpainter axupimgs',
                        height: 650, //编辑器高度
                        min_height: 400,
                        /*content_css: [ //可设置编辑区内容展示的css，谨慎使用
                            '/static/reset.css',
                            '/static/ax.css',
                            '/static/css.css',
                        ],*/
                        images_upload_credentials: true,
                        fontsize_formats: '12px 14px 16px 18px 24px 36px 48px 56px 72px',
                        font_formats: '微软雅黑=Microsoft YaHei,Helvetica Neue,PingFang SC,sans-serif;苹果苹方=PingFang SC,Microsoft YaHei,sans-serif;宋体=simsun,serif;仿宋体=FangSong,serif;黑体=SimHei,sans-serif;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;',
                       /* link_list: [
                            { title: '预置链接1', value: 'http://www.tinymce.com' },
                            { title: '预置链接2', value: 'http://tinymce.ax-z.cn' }
                        ],
                        image_list: [
                            { title: '预置图片1', value: 'https://www.tiny.cloud/images/glyph-tinymce@2x.png' },
                            { title: '预置图片2', value: 'https://www.baidu.com/img/bd_logo1.png' }
                        ],
                        image_class_list: [
                            { title: 'None', value: '' },
                            { title: 'Some class', value: 'class-name' }
                        ],*/
                        importcss_append: true,
                        toolbar_sticky: true,
                        autosave_ask_before_unload: false
                    }

                }
            },

        },
        data(){
            return {
                editorMd:null,
                intervalTime:null,
                show:false,
                progress:0
            };
        },
        watch:{
            disabled(value){
                this.setDisabled(value);
            },
            value(val){
                this.setValue(val);
            },
            '_i18n.locale'(){
                this.destroy();
                this.init();
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
            setValue(val){
                if(this.editorMd && this.editorMd.getContent()!=val){
                    this.editorMd.setContent(val || '');
                }
            },
            setDisabled(val){
                if(this.editorMd){
                    this.editorMd.mode.set(val?'readonly':'design')
                }
            },
            init(){
                this.intervalTime = setInterval(()=>{
                    if(typeof tinymce=="object" && typeof tinymce.init=="function"){
                        clearInterval(this.intervalTime);
                        let options = copyObj(this.options);
                     /*   options.file_picker_callback =  (callback, value, meta) =>{
                            let param = new FormData();
                            param.append("type", meta.filetype);
                            param.append("file", file);

                            if (meta.filetype === 'file') {
                                callback('https://www.baidu.com/img/bd_logo1.png', { text: 'My text' });
                            }
                            if (meta.filetype === 'image') {
                                callback('https://www.baidu.com/img/bd_logo1.png', { alt: 'My alt text' });
                            }
                            if (meta.filetype === 'media') {
                                callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.baidu.com/img/bd_logo1.png' });
                            }
                        };*/
                        options.images_upload_handler= (blobInfo, success, failure)=>{
                            let param = new FormData();
                            param.append("type", 'image');
                            param.append("file", blobInfo.blob());
                            param.append('_token', this._token);
                            let config = {
                                //添加请求头
                                headers: { "Content-Type": "multipart/form-data" },
                                //添加上传进度监听事件
                                onUploadProgress: e => {
                                    this.progress = ((e.loaded / e.total * 100) | 0);
                                }
                            };
                            axios.post(this.use_url+this.action, param, config)
                                .then((response)=> {
                                    let res = response.data;
                                    this.refreshToken();
                                    //弹窗
                                    if (typeof res != 'undefined' && typeof res.alert != 'undefined' && res.alert) {
                                        this.pushMessage(res.alert);
                                    }
                                    if(res.state=='SUCCESS'){
                                        success(res.url);
                                    }
                                })
                                .catch( (error) =>{
                                    this.refreshToken();
                                    console.log(error);
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
                                });
                        };
                        options.init_instance_callback = ()=>{
                            this.editorMd = tinymce.editors[this.id];
                            this.show=true;
                            this.setDisabled(this.disabled);
                        };
                        options.selector = '#'+this.id;
                        options.language = this.$i18n.locale.replace(/-/g,'_');
                        options.readonly = this.disabled;
                        options.placeholder = this.$t(options.placeholder);
                        tinymce.init(options);
                    }
                },250);
            },
            sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms))
            },
            mouseoutEvent(){
                if(this.editorMd && this.editorMd.getContent){
                    let val = this.editorMd.getContent();
                    if((typeof this.value!="undefined") && val!=this.value){
                        this.$emit('input', val); //修改值
                        this.$emit('change',val); //修改值
                    }
                }
                this.$emit('blur'); //修改值
            },
            destroy(){
                if(this.editorMd){
                    this.editorMd.destroy();
                }
            }
        },
        created() {
            //动态加载js文件
            if(!document.getElementById('tinymce-js') && this.tinymce_key){
                let tinymceJs = document.createElement('script');
                tinymceJs.id = 'tinymce-js';
                tinymceJs.type = 'text/javascript';
                tinymceJs.src = 'https://cdn.tiny.cloud/1/'+this.tinymce_key+'/tinymce/5/tinymce.min.js';
                tinymceJs.referrerpolicy = 'origin';
                document.body.appendChild(tinymceJs);
            }
        },
        beforeDestroy() {
            this.destroy();
        },
        mounted() {
            this.init();
        },
        computed:{
            ...mapState([
                '_token',
                'use_url',
                'tinymce_key'
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
        }
    }
</script>

<style scoped>

</style>
