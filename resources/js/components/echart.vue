<template>
    <div></div>
</template>
<script>
    import { mapState} from 'vuex';
    import theme from './echarts.theme';
    export default {
        data(){
            return {
                chart:null,
                initing:false,
                intervalTime:null,
                clientWidth:0,
                intervalTimeWidth:null,
                initinged:false
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
                    if(typeof echarts!="undefined" && this.$el.clientWidth){
                        if(!echarts.theme_registered){
                            echarts.theme_registered = 1;
                            echarts.registerTheme('main', theme);
                        }
                        clearInterval(this.intervalTime);
                        if(this.initing){
                            return ;
                        }
                        this.initing = true;
                        this.$el.style.display = 'block'; //显示节点
                        this.chart = echarts.init(this.$el,'main');
                        let options = this.options;
                        if(typeof this.options=="function"){
                            options = this.options();
                        }
                        this.chart.setOption(options);
                        this.$el.style.display = null; //删除节点样式
                        this.initing = false;
                        setTimeout(()=>{ //动画效果
                            this.initinged = true;
                        },500);
                    }
                },300);

            },
            resizefn(){
                //执行重画必须显示div
                if(this.chart){
                    this.clientWidth = this.$el.clientWidth;
                    this.$el.style.display = 'block'; //显示节点
                    this.chart.resize();
                    this.$el.style.display = null; //删除节点样式
                }
            }
        },
        computed:{
            ...mapState([
                'language'
            ]),
        },
        mounted() {
            let $this = this;
            this.clientWidth = this.$el.clientWidth;
            this.intervalTimeWidth = setInterval(()=>{
                if(this.$el.clientWidth!=this.clientWidth){
                    this.clientWidth = this.$el.clientWidth;
                    if(this.initinged){
                        this.resizefn();
                    }
                }
            },200);
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
            //setTimeout(this.init,0);
        },
        created() {
            //动态加载js文件
            if(!document.getElementById('echarts-js')){
                let editormdJs = document.createElement('script');
                editormdJs.id = 'echarts-js';
                editormdJs.type = 'text/javascript';
                editormdJs.src = '/bower_components/echarts/dist/echarts.min.js';
                document.body.appendChild(editormdJs);
            }
        },
        watch:{
            options(){
                setTimeout(this.init,0);
            },
            language(){
                if(this.chart){
                    this.chart.dispose();
                    this.init();
                }
            }
        },
        beforeDestroy() {
            if(this.intervalTimeWidth){
                clearInterval(this.intervalTimeWidth);
            }
            if(this.chart){
                this.chart.dispose();
            }
        }

    }
</script>
