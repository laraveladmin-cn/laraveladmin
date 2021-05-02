<template>
    <div></div>
</template>
<script>
    export default {
        data(){
            return {
                chart:null,
                initing:false,
                intervalTime:null
            };
        },
        props:{
            options:{
                type: [Object,Function]
            },
            resize:{
                type: [Boolean],
                default: function () {
                    return true;
                }
            },
            delay:{
                type: [Number],
                default: function () {
                    return 0;
                }
            }
        },
        methods:{
            init(){
                this.intervalTime = setInterval(()=>{
                    if(typeof echarts!="undefined"){
                        clearInterval(this.intervalTime);
                        if(this.initing){
                            return ;
                        }
                        this.initing = true;
                        this.$el.style.display = 'block'; //显示节点
                        this.chart = echarts.init(this.$el);
                        let options = this.options;
                        if(typeof this.options=="function"){
                            options = this.options();
                        }
                        this.chart.setOption(options);
                        this.$el.style.display = null; //删除节点样式
                        this.initing = false;
                    }
                },300);

            },
            resizefn(){
                //执行重画必须显示div
                if(this.chart){
                    this.$el.style.display = 'block'; //显示节点
                    this.chart.resize();
                    this.$el.style.display = null; //删除节点样式
                }
            }
        },
        computed:{

        },
        mounted() {
            let $this = this;
            setTimeout(this.init,this.delay); //异步执行画图
            //窗口变化重新画图
            window.addEventListener("resize",()=> {
                if($this.initing){
                    return false;
                }
                if($this.delay && $($this.$el).css('display')!='block'){
                    setTimeout($this.resizefn,$this.delay);
                }else {
                    $this.resizefn();
                }
            });
        },
        updated(){
            setTimeout(this.init,0);
        },
        created() {
            //动态加载js文件
            if(!document.getElementById('echarts-js')){
                let editormdJs = document.createElement('script');
                editormdJs.id = 'echarts-js';
                editormdJs.type = 'text/javascript';
                editormdJs.src = 'https://cdn.bootcss.com/echarts/4.4.0-rc.1/echarts.min.js';
                document.body.appendChild(editormdJs);
            }
            this.i
        },
        watch:{
        }
    }
</script>
