<template>
    <div @mouseout="mouseoutEvent">
        <div :id="options.id" style="height: 100%">
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
                      placeholder:'请输入',
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
              intervalTime:null
          };
        },
        watch:{
            disabled(value){
                setTimeout(()=>{
                    this.setDisabled(value);
                },500);
            },
            value(val){
                setTimeout(()=>{
                    this.setValue(val);
                },500);
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
          init(){
              this.intervalTime = setInterval(()=>{
                  if(typeof editormd=="function"){
                      clearInterval(this.intervalTime);
                      let options = copyObj(this.options);
                      options.markdown = this.value || '';
                      options.readOnly = this.disabled;
                      options.imageUploadURL = this.use_url+ options.imageUploadURL;
                      options.onchange =  ()=> {
                      };
                      this.editorMd = editormd(options);
                  }
              },250);
          },
            mouseoutEvent(){
                if(this.editorMd){
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
        }
    }
</script>

<style scoped>
    @import url('/bower_components/editor.md/css/editormd.css');
    .editormd-fullscreen{
        z-index: 9999;
    }
</style>
