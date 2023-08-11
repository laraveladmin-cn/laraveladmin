const { createApp } = Vue;
let $el = document.getElementById('icon-logo');
if($el && AppConfig && AppConfig.logo){
    $el.href=AppConfig.logo;
}
createApp({
    data() {
        let ua = navigator.userAgent.toLowerCase();
        let is_wx = ua.match(/micromessenger/i) == "micromessenger";
        let latest_ver = typeof AppVersion=="object" ?AppVersion.version_info.latest_ver : {};
        return {
            app_config:AppConfig,
            is_wx:is_wx,
            pop_up:is_wx,
            forbidden:false,
            app_icon_url:latest_ver.logo_url || '',
            android_apk_url:latest_ver.apk_url || '',
        }
    },
    methods:{
        down(){
            if(this.forbidden){
                return
            }
            this.forbidden = true;
            if(this.is_wx){
                this.pop_up = true;
            }else {
                this.$refs['down'].click();
            }
            setTimeout(()=>{
                this.forbidden = false;
            },700);
        }
    }
}).mount('#app');


/*
$("#and").click(function () {
    if(!browser){
        $("#back").css("display", "block");
    }else{
        // 下载
        $("#back").css("display", "block");
    }
});
*/
