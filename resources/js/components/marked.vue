<template>
    <div>
        <div v-html="value_html" v-if="value_html">
        </div>
        <div v-else>
          {{value}}
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
    },
    data(){
        return {
            intervalTime:null,
            loading:true
        };
    },
    mounted() {
        if(typeof marked=="undefined"){
            this.intervalTime = setInterval(()=>{
                if(typeof marked!="undefined"){
                    clearInterval(this.intervalTime);
                    this.loading = false;
                }
            },100);
        }else {
            this.loading = false;
        }
    },
    methods:{
    },
    created() {
        //动态加载js文件
        if(!document.getElementById('marked-js')){
            let $script = document.createElement('script');
            $script.id = 'marked-js';
            $script.type = 'text/javascript';
            $script.src = '/bower_components/marked/marked.min.js';
            $script.async = false;
            document.body.appendChild($script);
            $script = document.createElement('script');
            $script.id = 'prism-js';
            $script.type = 'text/javascript';
            $script.src = '/bower_components/prismjs/prism.js';
            $script.async = false;
            document.body.appendChild($script);
            $script = document.createElement('script');
            $script.id = 'prism-autoloader';
            $script.type = 'text/javascript';
            $script.src = '/bower_components/prismjs/plugins/autoloader/prism-autoloader.min.js';
            $script.async = false;
            document.body.appendChild($script);
            $script = document.createElement('script');
            $script.id = 'prism-autoloader';
            $script.type = 'text/javascript';
            $script.src = '/bower_components/prismjs/components/prism-markup-templating.js';
            $script.async = false;
            document.body.appendChild($script);
        }
    },
    computed:{
        value_html(){
            if(this.loading){
                return this.value || '';
            }
            return marked.parse(this.value);
        }

    },
    value(val,old){

    },
    updated(){
        if(window.Prism){
            Prism.highlightAll();
        }
    }
}
</script>

<style scoped>
@import url('/bower_components/prismjs/themes/prism.css');

</style>
