<template>
    <div @mouseout="mouseoutEvent">
        <div :id="options.id" ref="editormd" style="height: 100%">
            <textarea style="display:none;"></textarea>
        </div>
    </div>
</template>

<script>
    export default {
        name: "editorMd",
        props:{
          value:{
              type:[String],
              default:function () {
                  return '';
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
                      id      : this.id || "editormd",
                      markdown        :  '',
                      //htmlDecode      : true,       // 开启 HTML 标签解析，为了安全性，默认不开启
                      htmlDecode      : "style,script,iframe",  // you can filter tags decode
                      //toc             : false,
                      tocm            : true,    // Using [TOCM]
                      //tocContainer    : "#custom-toc-container", // 自定义 ToC 容器层
                      //gfm             : false,
                      //tocDropdown     : true,
                      // markdownSourceCode : true, // 是否保留 Markdown 源码，即是否删除保存源码的 Textarea 标签
                      emoji           : true,
                      taskList        : true,
                      tex             : true,  // 默认不解析
                      flowChart       : true,  // 默认不解析
                      sequenceDiagram : true,  // 默认不解析
                  }

              }
          }
        },
        data(){
          return {
              editorMd:null,
              intervalTime:null
          };
        },
        watch:{
            value(val){
                this.setValue(val);
            }
        },
        methods:{
            setValue(val){
                this.options.markdown = val || '';
                if(this.editorMd && this.editorMd.getMarkdown()!=val){
                    this.init()
                }
            },
          init(){
              this.intervalTime = setInterval(()=>{
                  if(typeof editormd=="function"){
                      editormd.katexURL = {
                          js  : "/bower_components/katex/katex.min",  // default: //cdnjs.cloudflare.com/ajax/libs/KaTeX/0.3.0/katex.min
                          css : "/bower_components/katex/katex.min"   // default: //cdnjs.cloudflare.com/ajax/libs/KaTeX/0.3.0/katex.min
                      };
                      clearInterval(this.intervalTime);
                      this.$refs['editormd'].innerHTML = '';
                      this.options.markdown = this.value || '';
                      this.editorMd = editormd.markdownToHTML( this.id || "editormd",this.options);
                  }
              },250);
          },
            mouseoutEvent(){
                this.$emit('blur'); //修改值
            }
        },
        created() {
            //动态加载js文件
            if(!document.getElementById('marked-js')){
                let editormdJs = document.createElement('script');
                editormdJs.id = 'marked-js';
                editormdJs.type = 'text/javascript';
                editormdJs.src = '/bower_components/editor.md/lib/marked.min.js';
                document.body.appendChild(editormdJs);
            }
            if(!document.getElementById('prettify-js')){
                let editormdJs = document.createElement('script');
                editormdJs.id = 'prettify-js';
                editormdJs.type = 'text/javascript';
                editormdJs.src = '/bower_components/editor.md/lib/prettify.min.js';
                document.body.appendChild(editormdJs);
            }
            if(!document.getElementById('raphael-js')){
                let editormdJs = document.createElement('script');
                editormdJs.id = 'raphael-js';
                editormdJs.type = 'text/javascript';
                editormdJs.src = '/bower_components/editor.md/lib/raphael.min.js';
                document.body.appendChild(editormdJs);
            }
            if(!document.getElementById('underscore-js')){
                let editormdJs = document.createElement('script');
                editormdJs.id = 'underscore-js';
                editormdJs.type = 'text/javascript';
                editormdJs.src = '/bower_components/editor.md/lib/underscore.min.js';
                document.body.appendChild(editormdJs);
            }
            if(!document.getElementById('underscore-js')){
                let editormdJs = document.createElement('script');
                editormdJs.id = 'underscore-js';
                editormdJs.type = 'text/javascript';
                editormdJs.src = '/bower_components/editor.md/lib/underscore.min.js';
                document.body.appendChild(editormdJs);
            }
            if(!document.getElementById('sequence-js')){
                let editormdJs = document.createElement('script');
                editormdJs.id = 'sequence-js';
                editormdJs.type = 'text/javascript';
                editormdJs.src = '/bower_components/editor.md/lib/sequence-diagram.min.js';
                document.body.appendChild(editormdJs);
            }
            if(!document.getElementById('flowchart-js')){
                let editormdJs = document.createElement('script');
                editormdJs.id = 'flowchart-js';
                editormdJs.type = 'text/javascript';
                editormdJs.src = '/bower_components/editor.md/lib/flowchart.min.js';
                document.body.appendChild(editormdJs);
            }
            if(!document.getElementById('jflowchart-js')){
                let editormdJs = document.createElement('script');
                editormdJs.id = 'jflowchart-js';
                editormdJs.type = 'text/javascript';
                editormdJs.src = '/bower_components/editor.md/lib/jquery.flowchart.min.js';
                document.body.appendChild(editormdJs);
            }

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
        beforeDestroy(){
            if(this.editorMd){
                this.editorMd.editor.remove();
                this.editorMd = null;
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
