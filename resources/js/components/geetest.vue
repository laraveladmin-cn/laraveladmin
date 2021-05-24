<template>
    <div @mouseout="$emit('blur')" class="geetest-div">
        <div class="geetest-captcha"></div>
        <p v-show="show">{{$t('Loading CAPTCHA')}}...</p>
    </div>
</template>
<script>
    require('./gt.js');
    import { mapState} from 'vuex';
    export default {
        components: {
        },
        props:{
            //请求数据地址
            url:{
                type:[String],
                default: function () {
                    return '';
                }
            },
            //绑定值
            value: {
                type:[String,Boolean],
                default: function () {
                    return '';
                }
            }, //默认选项
            data:{
                type: [Object],
                default: function () {
                    return {
                        client_fail_alert:this.$t('Please complete the verification code correctly'),//请正确完成验证码操作。
                        lang:'zh-cn',
                        product:'float',
                        http:'http://'
                    };
                }
            }
        },
        data(){
            return {
                show:true,
                captchaObj:null
            }
        },
        watch:{
            //重置数据还原
            value(value,oldValue){
                if(value==false){
                    if(typeof this.captchaObj.refresh!='undefined'){
                        this.captchaObj.refresh();
                    }else {
                        this.captchaObj.reset();
                    }
                }
            },
            '_i18n.locale'(){
                this.destroy();
                this.init();
            }
        },
        methods:{
            destroy(){
                $('.geetest-captcha').html('');
            },
            init(){
                let $this = this;
                $.ajax({
                    url: this.url + "?t=" + (new Date()).getTime(),
                    headers:this.headers,
                    data:{_token:this._token},
                    type: "get",
                    dataType: "json",
                    success: function(data) {
                        initGeetest({
                            gt: data.gt,
                            challenge: data.challenge,
                            product: $this.data.product,
                            offline: !data.success,
                            new_captcha: data.new_captcha,
                            lang: $this.data.lang,
                            http: $this.data.http,
                            width: '100%'
                        }, function(captchaObj) {
                            captchaObj.appendTo($($this.$el).find('.geetest-captcha'));
                            captchaObj.onReady(function() {
                                $this.show = false;
                            });
                            captchaObj.onSuccess(function () {
                                $this.$emit('input', true); //修改值
                                $this.$emit('change',true); //修改值
                            });
                            $this.captchaObj = captchaObj;
                        });
                    }
                });
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
<style lang="scss">
    .geetest-div{
        padding: 5px 0px;
    }
</style>
