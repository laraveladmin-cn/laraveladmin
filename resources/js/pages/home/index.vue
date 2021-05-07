<template>
    <div class="home_index" ref="home_index">
        <iframe ref="iframe" :src="doc_url"  frameborder= "0" :onload="ifrmLoad()" scrolling="no"></iframe>
    </div>
</template>

<script>
    import { mapState,mapGetters } from 'vuex';
    export default {
        components:{
        },
        props: {
        },
        data(){
            return {
                "{lang_path}":'home.index',
                intervalObj:null
            };
        },
        computed:{
            ...mapState('user',{
                user:state => state.user
            }),
            ...mapState(['app_url']),
            doc_url(){
                return this.app_url+'/doc.html';
            }
        },
        created() {
            this.getData();
        },
        methods:{
            initIframe(){
                let iframe = this.$refs['iframe'];
                try{
                    let bHeight = iframe.contentWindow.document.body.scrollHeight;
                    let dHeight = iframe.contentWindow.document.documentElement.scrollHeight;
                    let h1 = Math.max(bHeight, dHeight);
                    let h2 = Math.max($(iframe).contents().find(".sidebar-nav").height(),
                        $(iframe).contents().find(".markdown-section").height());
                    let h = Math.min(h1,h2+100);
                    let flag = false;
                    if($(iframe).contents().find("body").hasClass('medium-zoom--opened')){
                       /* h = window.document.body.scrollHeight
                            -$('.main-header').height()
                            -$('.content-header').height()
                            -50;*/
                        flag = true;
                    }
                    if(h && iframe.height!=h){
                        iframe.height = h;
                        if(flag){
                   /*         let $img =  $(iframe).contents().find('.medium-zoom-image--opened');
                            let $img_old = $(iframe).contents().find('.content img[src="'+$img.attr('src')+'"]');
                            $img.remove();
                            $(iframe).contents().find('.medium-zoom-overlay').remove();
                            setTimeout(()=>{
                                $img_old.trigger('click');
                            },50);*/

                            //$img_old.trigger('click');
                            //dd($img);
                        }

                    }

                }catch (ex){
                    dd(ex);
                }
            },
            clickIframe(){
                this.$refs['iframe'].onload = ()=>{
                    if(this.$refs['iframe'].contentDocument){
                        this.$refs['iframe'].contentDocument.onclick =  () =>{
                            this.$refs['home_index'].click();
                        }
                    }
                };
            },
            ifrmLoad(){
                if(!this.intervalObj){
                    this.intervalObj = window.setInterval(this.initIframe, 200);
                }
            }
        },
        mounted() {
            this.clickIframe();
        },
        destroyed() {
            clearInterval(this.intervalObj);
        }

    };
</script>
<style lang="scss" scoped>
    iframe{
        width: 100%;
        border: none;
        position: relative;
        z-index: 0;
    }
</style>
