<template>
    <div @mouseout="mouseoutEvent" @touchend="stopTouchend">
        <input type="hidden" :value="_token" ref="token" name="_token">
        <div :id="options.id" style="height: 100%" >
            <textarea style="display:none;"></textarea>
        </div>
    </div>
</template>

<script>
    //editor.md  markdown编辑器
    //window.editormd = require('editor.md/editormd.min');
    import { mapState, mapActions, mapMutations, mapGetters } from 'vuex';
    export default {
        name: "editorMd",
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
                    return '';
                }
            },
          options:{
              type:[Object],
              default:function () {
                  return  {
                      id: this.id || "editormd",
                      delay: 500,
                      placeholder:'Please enter',
                      autoFocus : false,
                      //autoHeight : true,
                      width   : "100%",
                      height: 740,
                      path : '/bower_components/editor.md/lib/',
                      //theme : "dark",
                      //previewTheme : "dark",
                      //editorTheme : "pastel-on-dark",
                      codeFold : true,
                      //syncScrolling : false,
                      saveHTMLToTextarea : true,    // 保存 HTML 到 Textarea
                      searchReplace : true,
                      //watch : false,                // 关闭实时预览
                      htmlDecode : "style,script,iframe|on*",            // 开启 HTML 标签解析，为了安全性，默认不开启
                      //toolbar  : false,             //关闭工具栏
                      //previewCodeHighlight : false, // 关闭预览 HTML 的代码块高亮，默认开启
                      emoji : true,
                      taskList : true,
                      tocm            : true,         // Using [TOCM]
                      tex : true,                   // 开启科学公式TeX语言支持，默认关闭
                      flowChart : true,             // 开启流程图支持，默认关闭
                      sequenceDiagram : true,       // 开启时序/序列图支持，默认关闭,
                      //dialogLockScreen : false,   // 设置弹出层对话框不锁屏，全局通用，默认为true
                      //lockScreen:false,
                      //dialogShowMask : false,     // 设置弹出层对话框显示透明遮罩层，全局通用，默认为true
                      //dialogDraggable : false,    // 设置弹出层对话框不可拖动，全局通用，默认为true
                      //dialogMaskOpacity : 0.4,    // 设置透明遮罩层的透明度，全局通用，默认值为0.1
                      //dialogMaskBgColor : "#000", // 设置透明遮罩层的背景颜色，全局通用，默认为#fff
                      imageUpload : true,
                      imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                      imageUploadURL : "/home/upload/index?type=image",
                      onload : function() {
                      //console.log('onload', this);
                      //this.fullscreen();
                      //this.unwatch();
                      //this.watch().fullscreen();

                      //this.setMarkdown("#PHP");
                      //this.width("100%");
                      //this.height(480);
                      //this.resize("100%", 640);
                  }
                  }

              }
          },

        },
        data(){
          return {
              editorMd:null,
              intervalTime:null,
              onClick:false,
              onSubmit:false,
              loaded:false
          };
        },
        watch:{
            disabled(value){
                this.awaitFun((value)=>{
                    this.setDisabled(value);
                },value);
            },
            value(val){
                this.awaitFun((val)=>{
                    this.setValue(val);
                },val);
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
            awaitFun(callback,val){
                if(this.loaded){
                    callback(val);
                }else {
                    setTimeout(this.awaitFun,500,callback,val);
                }
            },
            setValue(val){
                if(this.editorMd && this.editorMd.getMarkdown()!=val){
                    this.editorMd.setMarkdown(val || '');
                }
            },
            setDisabled(val){
                if(this.editorMd){
                    this.editorMd.config('readOnly',val);
                }
            },
            stopTouchend(e){
                e.stopPropagation();
            },
            init(){
                this.intervalTime = setInterval(()=>{
                  if(typeof editormd=="function"){
                      editormd.katexURL = {
                          js  : "/bower_components/katex/katex.min",  // default: //cdnjs.cloudflare.com/ajax/libs/KaTeX/0.3.0/katex.min
                          css : "/bower_components/katex/katex.min"   // default: //cdnjs.cloudflare.com/ajax/libs/KaTeX/0.3.0/katex.min
                      };
                      clearInterval(this.intervalTime);
                      let options = copyObj(this.options);
                      options.placeholder = this.$t(options.placeholder);
                      options.markdown = this.value || '';
                      options.readOnly = this.disabled;
                      options.imageUploadURL = this.use_url+ options.imageUploadURL;
                      options.onchange =  ()=> {
                      };
                      options.onload = async ()=>{
                          this.loaded=true;
                          //查找图片上传按钮并绑定事件
                          while(true) {
                              let $picture = $(this.$el).find('.editormd-toolbar-container .fa-picture-o');
                              if($picture.length){
                                  if(!this.onClick){
                                      this.onClick=true;
                                      $picture.on('touchend click',async()=>{
                                          while (true){
                                              let $input = $(this.$el).find('.editormd-file-input input[type="file"]');
                                              if($input.length){
                                                  $(this.$el).find('.editormd-image-dialog .editormd-dialog-close,.editormd-image-dialog .editormd-enter-btn,.editormd-image-dialog .editormd-cancel-btn').on('click',()=>{
                                                      this.onSubmit = false;
                                                  });
                                                  if(!this.onSubmit){
                                                      this.onSubmit = true;
                                                      $input.attr('name','file');
                                                      $(this.$el).find('.editormd-file-input').append($(this.$refs['token']));
                                                      let form = $(this.$el).find('.editormd-dialog-container form')[0];
                                                      let iframe = $(this.$el).find('#editormd-image-iframe')[0];
                                                      form.onsubmit = (e)=>{
                                                          e.preventDefault(e);
                                                          //上传文件信息
                                                          let formData = new FormData(form);
                                                          let body = (iframe.contentWindow ? iframe.contentWindow : iframe.contentDocument).document.body;
                                                          axios.post(options.imageUploadURL, formData,this.headers).then( (response)=>{
                                                              this.refreshToken();
                                                              let res_str = JSON.stringify(response.data);
                                                              body.innerHTML = res_str;
                                                              iframe.onload();
                                                          }).catch((error) =>{
                                                              this.refreshToken();
                                                              let res_str = JSON.stringify({
                                                                  success : 0,
                                                                  message : this.$t('Error uploading file!'),
                                                                  url     : ""
                                                              });
                                                              body.innerHTML = res_str;
                                                              iframe.onload();
                                                          });
                                                          return false;
                                                      };
                                                  }
                                                  break;
                                              }
                                              await this.sleep(500);
                                          }
                                      });
                                  }
                                  break;
                              }
                              await this.sleep(1000);
                          }

                      };
                      this.editorMd = editormd(options);
                  }
              },250);
                $(document).on('touchend',()=>{
                    this.mouseoutEvent();
                });
          },
            sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms))
            },
            mouseoutEvent(){
                if(this.editorMd && (typeof this.editorMd.getValue!="undefined")){
                    let val = this.editorMd.getValue();
                    if((typeof this.value!="undefined") && val!=this.value){
                        this.$emit('input', val); //修改值
                        this.$emit('change',val); //修改值
                    }
                }
                this.$emit('blur'); //修改值
            }
        },
        created() {
            //动态加载js文件
            if(!document.getElementById('editormd-js')){
                let editormdJs = document.createElement('script');
                editormdJs.id = 'editormd-js';
                editormdJs.type = 'text/javascript';
                editormdJs.src = '/bower_components/editor.md/editormd.min.js';
                document.body.appendChild(editormdJs);
            }
        },
        mounted() {
            this.init();
            $('html,body').addClass('editormd-html');
        },
        computed:{
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
        beforeDestroy(){
            if(this.editorMd){
                this.editorMd.editor.remove();
                this.editorMd = null;
            }
            if(!$('.editormd').length){
                $('html,body').removeClass('editormd-html');
            }
        }
    }
</script>

<style>
    @import url('/bower_components/editor.md/css/editormd.css');
    .editormd-fullscreen{
        z-index: 9999;
    }
    @media screen and (max-width: 750px) {
        .editormd-image-dialog,.editormd-dialog{
            width: 94% !important;
            max-width: 465px !important;
            left: 3% !important;
          /*  top:0 !important;
            bottom: 0 !important;
            margin: auto !important;
            */
        }
        .editormd-dialog{
            height: 510px !important;
        }
        .editormd-preformatted-text-dialog{
            height: 535px !important;
        }
        .editormd-code-block-dialog{
            height: 555px !important;
        }
        .editormd-image-dialog{
            height: 368px !important;
        }
        .editormd-emoji-dialog{
            height: 465px !important;
        }
        .editormd-goto-line-dialog{
            height: 180px !important;
        }
        .editormd-dialog-info{
            height: 200px !important;
        }
        .editormd-emoji-dialog .editormd-dialog-container{
            overflow-x: scroll;
        }
        .editormd-image-dialog .editormd-form label{
            float: unset;
        }
    }
    @media screen and (max-width: 360px) {
        .editormd-form > input:nth-child(3) {
            width: 175px;
        }
    }
    html.editormd-html,body.editormd-html{
        height: unset !important;
    }

</style>
