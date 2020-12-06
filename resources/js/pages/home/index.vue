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
                    let h = Math.max(bHeight, dHeight);
                    iframe.height = h;
                }catch (ex){}
            },
            clickIframe(){
                this.$refs['iframe'].onload = ()=>{
                    this.$refs['iframe'].contentDocument.onclick =  () =>{
                        this.$refs['home_index'].click();
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
