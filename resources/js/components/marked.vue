<template>
    <div>
        <div v-if="!highFrequency">
            <div v-html="value_html" v-if="value_html">
            </div>
            <div v-else>
                {{value}}
            </div>
        </div>
        <div v-else>
            <div ref="html"></div>
        </div>
    </div>
</template>


<script>
export default {
    name: "marked",
    props:{
        //绑定值
        value: {
            type:[String, Number],
            default: function () {
                return '';
            }
        },
        //绑定值
        highFrequency: {
            type:[String, Number,Boolean],
            default: function () {
                return false;
            }
        },
    },
    data(){
        return {
            intervalTime:null,
            loading:true,
            delay_time:0
        };
    },
    mounted() {
        if(typeof marked=="undefined"){
            this.intervalTime = setInterval(()=>{
                if(typeof marked!="undefined" && typeof mermaid!="undefined"){
                    clearInterval(this.intervalTime);
                    this.loading = false;
                    mermaid.initialize({ startOnLoad: false });
                    let renderer = new marked.Renderer();
                    renderer.code =  function (code, infostring, escaped) {
                        const escapeTest = /[&<>"']/;
                        const escapeReplace = new RegExp(escapeTest.source, 'g');
                        const escapeTestNoEncode = /[<>"']|&(?!(#\d{1,7}|#[Xx][a-fA-F0-9]{1,6}|\w+);)/;
                        const escapeReplaceNoEncode = new RegExp(escapeTestNoEncode.source, 'g');
                        const escapeReplacements = {
                            '&': '&amp;',
                            '<': '&lt;',
                            '>': '&gt;',
                            '"': '&quot;',
                            "'": '&#39;'
                        };
                        const getEscapeReplacement = (ch) => escapeReplacements[ch];
                        function escape(html, encode) {
                            if (encode) {
                                if (escapeTest.test(html)) {
                                    return html.replace(escapeReplace, getEscapeReplacement);
                                }
                            }
                            else {
                                if (escapeTestNoEncode.test(html)) {
                                    return html.replace(escapeReplaceNoEncode, getEscapeReplacement);
                                }
                            }
                            return html;
                        }


                        const lang = (infostring || '').match(/^\S*/)?.[0];
                        if (this.options.highlight) {
                            const out = this.options.highlight(code, lang);
                            if (out != null && out !== code) {
                                escaped = true;
                                code = out;
                            }
                        }
                        code = code.replace(/\n$/, '') + '\n';
                        let use_mermaid = code.match(/^sequenceDiagram/) || code.match(/^graph/);
                        if(!use_mermaid){
                            if (!lang) {
                                return '<pre><code>'
                                    + (escaped ? code : escape(code, true))
                                    + '</code></pre>\n';
                            }
                            return '<pre><code class="'
                                + this.options.langPrefix
                                + escape(lang)
                                + '">'
                                + (escaped ? code : escape(code, true))
                                + '</code></pre>\n';
                        }else {
                            if (!lang) {
                                return '<pre><code class="mermaid">'
                                    + (escaped ? code : escape(code, true))
                                    + '</code></pre>\n';
                            }
                            return '<pre><code class="mermaid '
                                + this.options.langPrefix
                                + escape(lang)
                                + '">'
                                + (escaped ? code : escape(code, true))
                                + '</code></pre>\n';
                        }

                    };
                    marked.setOptions({
                        renderer: renderer
                    });

                }
            },100);
        }else {
            this.loading = false;
        }
    },
    methods:{

        getValueHtml(){
            let str = '';
            if(!this.loading){
                str = marked.parse(this.value,{
                    sanitize:true
                });
            }
            return str;
        },
        highlight(){
            if(typeof window.Prism=="object" && !window.prism_highlight_all_ing){
                window.prism_highlight_all_ing = true; //锁定
                setTimeout(()=>{
                    Prism.highlightAll(false,()=>{
                        window.prism_highlight_all_ing = false; //解锁
                    });
                    if(typeof mermaid!="undefined"){
                        mermaid.run({
                            querySelector: '.mermaid'
                        });
                    }
                    setTimeout(()=>{
                        window.prism_highlight_all_ing = false; //解锁
                    },100)
                },300);
            }
        },
        //延迟高亮
        delayHighlight(){
            this.delay_time = new Date().getTime();
            setTimeout(()=>{
                if((new Date().getTime())-this.delay_time>500){
                    this.highlight();
                }
            },300);
        }

    },
    created() {
        //动态加载js文件
        if(!document.getElementById('marked-js')){
            let $script = document.createElement('script');
            $script.id = 'marked-js';
            $script.type = 'text/javascript';
            $script.src = '/bower_components/marked/marked.min.js';
            $script.async='true';
            document.body.appendChild($script);
            $script = document.createElement('script');
            $script.id = 'prism-js';
            $script.type = 'text/javascript';
            $script.src = '/bower_components/prismjs/prism.js';
            document.body.appendChild($script);
            $script = document.createElement('script');
            $script.id = 'prism-autoloader';
            $script.type = 'text/javascript';
            $script.src = '/bower_components/prismjs/plugins/autoloader/prism-autoloader.min.js';
            document.body.appendChild($script);
            setTimeout(()=>{
                $script = document.createElement('script');
                $script.id = 'prism-autoloader';
                $script.type = 'text/javascript';
                $script.src = '/bower_components/prismjs/components/prism-markup-templating.js';
                document.body.appendChild($script);
            },50);
        }
        if(!document.getElementById('mermaid-js')){
            let $script = document.createElement('script');
            $script.id = 'mermaid-js';
            $script.type = 'text/javascript';
            $script.src = '/bower_components/mermaid/mermaid.min.js';
            $script.async='true';
            document.body.appendChild($script);
        }
    },
    computed:{
        value_html(){
            return this.getValueHtml();
        }

    },
    watch:{
        value(val,old){
            if(this.highFrequency){
                this.$refs['html'].innerHTML = this.value_html;
                this.delayHighlight();
            }
        },
    },
    updated(){
        this.highlight();
    }
}
</script>

<style scoped>
@import url('/bower_components/prismjs/themes/prism.css');

</style>
