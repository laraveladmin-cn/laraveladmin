<template>
    <div class="open_password hold-transition register-page h100" v-if="!loading">
        <div class="register-box">
            <logo></logo>
            <div class="register-box-body">
                <p class="login-box-msg">忘记密码</p>
                <validation-observer ref="password" v-slot="{invalid,validate}">
                    <form method="post">
                        <form-item v-model="username" :options="{key:'username',name:'账号',rules:'required|min:5|max:18',icon:'fa-user',placeholder:'请输入邮箱/手机号码/用户名'}"></form-item>
                        <form-item  v-if="count_down<=0" v-model="verifyCode" :options="{key:'verify',name:'验证码',rules:'',label:false}">
                            <geetest style="width: 150px"  v-if="verify['type']=='geetest'" :url="use_url+verify['dataUrl']" v-model="verifyCode" :data="verify['data']"></geetest>
                            <captcha v-if="verify['type']=='captcha'" :url="verify['dataUrl']" v-model="verifyCode" :data="verify['data']"></captcha>
                        </form-item>
                        <form-item v-model="message_code" :options="{key:'message_code',name:'消息验证码',rules:'required|length:6|integer',icon:'glyphicon-envelope',placeholder:'输入收到的消息验证码'}">
                            <label class="control-label pull-right" v-show="count_down>0">
                                <span><span class="count-down">{{count_down}}</span>秒</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary btn-block btn-flat" :disabled="sendActive" @click="send">
                                        {{sending?'获取中...':'获取验证码'}}
                                    </button>
                                </div>
                                <input type="text" v-model="message_code" class="form-control" placeholder="输入收到的消息验证码">
                            </div>
                        </form-item>
                        <form-item v-model="password" :options="{key:'password',type:'password',name:'新密码',rules:'required|min:6|max:18',icon:'glyphicon-lock',placeholder:'请输入新密码'}"></form-item>
                        <form-item v-model="confirm_password" :options="{key:'confirm_password',type:'password',name:'确认新密码',rules:'required|confirmed:password',icon:'glyphicon-log-in',placeholder:'请确认新密码'}"></form-item>
                        <div class="social-auth-links form-group">
                            <button type="button" class="btn btn-primary btn-block btn-flat" :disabled="submiting" @click="postPassword(invalid,validate)">
                                {{submiting?'重置中...':'重置密码'}}
                            </button>
                        </div>
                    </form>
                </validation-observer>
                <div class="social-auth-links row">
                    <router-link class="pull-left" to="/open/register">
                        用户注册
                    </router-link>
                    <router-link class="pull-right" to="/open/login">直接登录</router-link>
                </div>
            </div>
            <icp></icp>
        </div>
    </div>
</template>

<script>
    import { mapState, mapActions, mapGetters } from 'vuex';
    import {ValidationObserver,ValidationProvider} from 'vee-validate';
    export default {
        components:{
            //滑块验证组件
            geetest:()=>import(/* webpackChunkName: "common_components/geetest.vue" */ 'common_components/geetest.vue'),
            //图片验证码组件
            captcha:()=>import(/* webpackChunkName: "common_components/captcha.vue" */ 'common_components/captcha.vue'),
            icp:()=>import(/* webpackChunkName: "open_components/icp.vue" */ 'open_components/icp.vue'),
            logo:()=>import(/* webpackChunkName: "open_components/logo.vue" */ 'open_components/logo.vue'),
            formItem:()=>import(/* webpackChunkName: "open_components/formItem.vue" */ 'open_components/formItem.vue'),
            ValidationObserver
        },
        props: {
        },
        data(){
            return {
                username:'', //用户名
                password:'', //密码
                confirm_password:'', //确认密码
                message_code:'', //发送后的验证码
                verifyCode:'',
                count_down:0,
                sending:false,
                submiting:false,
                sendUrl:'/open/forgot-password/send',
                submitUrl:'/open/forgot-password/reset-password',
                errors:{},
                step:0
            }
        },
        computed:{
            ...mapState(['_token','verify','use_url']),
            ...mapState('user',{
                loadingUser:state => state.loading
            }),
            ...mapGetters('user',[
                'isLogined',
                'isAdmin'
            ]),
            //数据加载状态
            loading(){
                //已经登录
                if(!this.loadingUser && this.isLogined){
                    if(this.isAdmin){
                        this.$router.replace({path: `/admin/index`});
                    }else {
                        this.$router.replace({path: `/home/index`});
                    }
                }
                return this.loadingUser;
            },
            sendActive(){
                return (!this.username || this.count_down>0) && !this.sending;
            },
            validation(){
                return this.$refs['password'];
            },
        },
        methods:{
            //消息提醒
            ...mapActions({
                pushMessage: 'pushMessage'
            }),
            //提交重置密码
            postPassword(invalid,validate){
                let callback =  () =>{
                    if(this.submiting){
                        return false;
                    }
                    if (!this.message_code) {
                        let errors = {};
                        errors['message_code'] = ['请填写验证码'];
                        this.validation.setErrors(errors);
                        return false;
                    }
                    this.submiting= true;
                    let post_data = {};
                    post_data['username'] = this.username || '';
                    post_data['password']=this.password;
                    post_data['password_confirmation']=this.confirm_password; //确认密码
                    post_data['message_code']=this.message_code;
                    axios.post(this.use_url+this.submitUrl,post_data)
                        .then((res)=>{
                            this.submiting= false;
                            this.pushMessage({
                                'showClose':true,
                                'title':e.text+' '+this.$t('{action} successfully!',{action:this.$t('Operation')}),
                                'message':'',
                                'type':'success',
                                'position':'top',
                                'iconClass':'fa-check',
                                'customClass':'',
                                'duration':3000,
                                'show':true
                            });
                        })
                        .catch((error)=>{
                            let errors = catchError(error);
                            let username = collect(errors.username || []);
                            collect(['uname','email','mobile_phone','qq']).map((key)=>{
                                if(errors[key]){
                                    username = username.merge(errors[key]);
                                    delete errors[key];
                                }
                            });
                            if(username.count()>0){
                                errors.username = username.all();
                            }
                            this.validation.setErrors(errors);
                            this.submiting= false;
                        });
                };
                if(invalid){
                    validate().then(success => {
                        success && callback();
                    });
                }else {
                    callback();
                }

            },
            //发送短信验证码
            send(){
                let errors;
                if (this.sending || this.count_down>0) {
                    errors = {'message_code':['验证码正在发送...']};
                    this.validation.setErrors(errors);
                    return false;
                }
                if (!this.verifyCode) {
                    errors = {'verify':['验证码验证失败']};
                    this.validation.setErrors(errors);
                    return false;
                }
                //短信发送中
                this.sending = true;
                let post_data = {};
                post_data['username'] = this.username || '';
                if(this.verify['type']=='captcha'){
                    post_data['verify'] = this.verifyCode;
                }else {
                    post_data['verify'] = $(this.$el).find("input[name='geetest_challenge']").val();
                    post_data['geetest_validate'] = $(this.$el).find("input[name='geetest_validate']").val();
                    post_data['geetest_seccode'] = $(this.$el).find("input[name='geetest_seccode']").val();
                }
                axios.post(this.use_url+this.sendUrl,post_data)
                    .then((res)=>{
                        //倒计时允许第二次发送验证码
                        let data = res.data;
                        this.count_down = data.countdown || 0;
                        this.t = setInterval(()=>{
                            this.count_down--;
                            if(this.count_down<=0){
                                clearInterval(this.t);
                            }
                        },1000);
                        this.verifyCode = '';
                        this.sending = false;
                    })
                    .catch((error)=>{
                        //短信发送中
                        let errors = catchError(error);
                        let username = collect(errors.username || []);
                        collect(['uname','email','mobile_phone','qq']).map((key)=>{
                            if(errors[key]){
                                username = username.merge(errors[key]);
                                delete errors[key];
                            }
                        });
                        if(username.count()>0){
                            errors.username = username.all();
                        }
                        this.validation.setErrors(errors);
                        this.verifyCode = '';
                        this.sending=false;
                    });
            }
        }
    };
</script>
<style lang="scss">
    .open_password{
        position: relative;
        background: url('/dist/img/login-bg.jpg') no-repeat;
        background-size: cover;
        -webkit-background-size: cover;
        -o-background-size: cover;
        background-position: center 0;
    }
    .open_password .form-group{
        margin-bottom: 5px;
    }
    .register-box{
        position: absolute;
        height: 530px;
        left: 0;
        top: 0;
        bottom: 40px;
        right: 0;
        margin: auto;
    }
    .register-box{
        opacity: 0.9;
    }
    .form-group .pull-right{
        margin-bottom: 0px;
    }
    .count-down{
        color: red;
    }
    .has-feedback label~.form-control-feedback{
        top: 20px;
    }
    .control-label{
        margin-bottom:0px;
    }
</style>
