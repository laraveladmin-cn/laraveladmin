<template>
    <div class="open_register hold-transition register-page h100" v-if="!loading">
        <div class="register-box">
            <logo></logo>
            <div class="register-box-body">
                <p class="login-box-msg">{{$tp('Registered user')}}</p>
                <validation-observer ref="register" v-slot="{invalid,validate}">
                    <form method="post">
                        <form-item v-model="username" :options="{key:'username',name:$tp('Account'),rules:'required|min:5|max:18',icon:'fa-user',placeholder:placeholderUsername}"></form-item>
                        <form-item v-model="email" :options="{key:'email',name:$t('Email'),type:'email',rules:mobile_phone?'':'required|email',icon:'glyphicon-envelope',placeholder:$tp('Please enter email address')}"></form-item>
                        <form-item v-model="mobile_phone" :options="{key:'mobile_phone',name:$t('Mobile phone number'),rules:email?'':'required|mobile',icon:'glyphicon-phone',placeholder:$tp('Please enter your mobile phone number')}"></form-item>
                        <form-item v-if="count_down<=0" v-model="verifyCode" :options="{key:'verify',name:$t('captcha'),rules:'',label:false}">
                            <geetest style="width: 150px"  v-if="verify['type']=='geetest'" :url="web_url+verify['dataUrl']" v-model="verifyCode" :data="verify['data']"></geetest>
                            <captcha v-if="verify['type']=='captcha'" :url="verify['dataUrl']" v-model="verifyCode" :data="verify['data']"></captcha>
                        </form-item>
                        <form-item v-model="message_code" :options="{key:'message_code',name:$tp('Message authentication code'),rules:'required|length:6|integer',icon:'glyphicon-envelope',placeholder:$tp('Enter the received message verification code')}">
                            <label class="control-label pull-right" v-show="count_down>0">
                                <span><span class="count-down">{{count_down}}</span>{{$tp('seconds')}}</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary btn-block btn-flat" :disabled="sendActive" @click="send">
                                        {{sending?$tp('Getting'):$tp('Get the verification code')}}
                                    </button>
                                </div>
                                <input type="text" v-model="message_code" class="form-control" :placeholder="$tp('Enter the CAPTCHA you received')">
                            </div>
                        </form-item>
                        <form-item v-model="password" :options="{key:'password',type:'password',name:$t('Password'),rules:'required|min:6|max:18',icon:'glyphicon-lock',placeholder:$tp('Please enter your password')}"></form-item>
                        <form-item v-model="confirm_password" :options="{key:'confirm_password',type:'password',name:$tp('Confirm password'),rules:'required|confirmed:password',icon:'glyphicon-log-in',placeholder:$tp('Please reconfirm your password')}"></form-item>
                        <form-item v-model="agree" :options="{key:'agree',name:$tp('protocol'),rules:'required',label:false,messages:false}">
                            <div class="social-auth-links row" :class="{'has-error':errors.length}">
                                <div class="col-xs-12 col-lg-12 row-col">
                                    <icheck v-model="agree" :option="true">
                                    <span class="checkbox-label">
                                         {{$tp('I have read and agree')}}《<a href="#">{{$tp('Protocol')}}</a>》
                                    </span>
                                    </icheck>
                                </div>
                                <div class="col-xs-12 col-lg-12 row-col btn-register">
                                    <button type="button" class="btn btn-primary btn-block btn-flat" :disabled="loading" @click="postRegister(invalid,validate)">
                                        {{loading?$tp('Registration is underway'):$t('Register')}}
                                    </button>
                                </div>
                            </div>
                        </form-item>
                    </form>
                </validation-observer>
                <div class="social-auth-links row">
                    <router-link class="pull-left" to="/open/password">
                        {{$tp('Forget your password')}}
                    </router-link>
                    <router-link class="pull-right" to="/open/login">{{$tp('To log in')}}</router-link>
                </div>
            </div>
            <icp></icp>
        </div>

    </div>
</template>

<script>
    import { mapState, mapActions, mapGetters } from 'vuex';
    import {ValidationObserver} from "vee-validate";
    export default {
        components:{
            //滑块验证组件
            geetest:()=>import(/* webpackChunkName: "common_components/geetest.vue" */ 'common_components/geetest.vue'),
            //图片验证码组件
            captcha:()=>import(/* webpackChunkName: "common_components/captcha.vue" */ 'common_components/captcha.vue'),
            icp:()=>import(/* webpackChunkName: "open_components/icp.vue" */ 'open_components/icp.vue'),
            logo:()=>import(/* webpackChunkName: "open_components/logo.vue" */ 'open_components/logo.vue'),
            formItem:()=>import(/* webpackChunkName: "open_components/formItem.vue" */ 'open_components/formItem.vue'),
            icheck:()=>import(/* webpackChunkName: "common_components/icheck.vue" */ 'common_components/icheck.vue'),
            ValidationObserver
        },
        props: {
        },
        data(){
            return {
                "{lang_path}":'open',
                errors:{},
                verifyCode:'',
                username:'',
                email:'',
                mobile_phone:'',
                password:'',
                confirm_password:'', //确认密码
                message_code:'',
                agree:false,
                count_down:0,
                sending:false,
                sendUrl:'/open/register/send',
                submitUrl:'/open/register',
                other:this.$router.currentRoute.query.other || ''
            }
        },
        methods:{
            placeholderUsername(){
                return this.$tp('Please enter your account/email/mobile phone number');
            },
            placeholderPassword(){
                return this.$t('enter',{name:this.$t('password')});
            },
            //提交注册
            postRegister(invalid,validate){
                let callback = ()=>{
                    if (this.loading) {
                        return false;
                    }
                    let errors;
                    if (!this.message_code) {
                        errors = {'message_code':[
                            this.$tp('Captcha validation failed')
                            //'验证码验证失败'
                            ]};
                        this.validation.setErrors(errors);
                        return false;
                    }
                    this.loading = true;
                    let post_data = {};
                    post_data['username'] = this.username || ''; //用户名
                    post_data['agree'] = this.agree || ''; //同意协议
                    post_data['password_confirmation']=this.confirm_password; //确认密码
                    post_data['password']=this.password;
                    post_data['email']=this.email;
                    post_data['mobile_phone']=this.mobile_phone;
                    post_data['message_code'] = this.message_code;
                    post_data['other'] = this.other;
                    axios.post(this.web_url+this.submitUrl,post_data)
                        .then((res)=>{
                            this.loading = false;
                        })
                        .catch((error)=>{
                            this.loading = false;
                            let errors = catchError(error);
                            this.validation.setErrors(errors);
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
                    errors = {'message_code':[
                            this.$tp('The verification code is being sent"')
                        //'验证码正在发送...'
                        ]};
                    this.validation.setErrors(errors);
                    return false;
                }
                if (!this.verifyCode) {
                    errors = {'verify':[
                            this.$tp('Captcha validation failed')
                        //'验证码验证失败'
                        ]};
                    this.validation.setErrors(errors);
                    return false;
                }
                //短信发送中
                this.sending = true;
                let post_data = {};
                post_data['username'] = this.username || '';
                post_data['email'] = this.email || '';
                post_data['mobile_phone'] = this.mobile_phone || '';
                if(this.verify['type']=='captcha'){
                    post_data['verify'] = this.verifyCode;
                }else {
                    post_data['verify'] = $(this.$el).find("input[name='geetest_challenge']").val();
                    post_data['geetest_validate'] = $(this.$el).find("input[name='geetest_validate']").val();
                    post_data['geetest_seccode'] = $(this.$el).find("input[name='geetest_seccode']").val();
                }
                axios.post(this.web_url+this.sendUrl,post_data)
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
                        this.validation.setErrors(errors);
                        this.verifyCode = '';
                        this.sending = false;
                    });
            }
        },
        computed:{
            ...mapState(['_token','verify','use_url','web_url']),
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
            validation(){
                return this.$refs['register'];
            },
            sendActive(){
                return (!this.username || this.count_down>0) && !this.mobile_phone && !this.email && !this.sending;
            },
        },
        created() {
        }
    };
</script>
<style lang="scss">
    .open_register{
        position: relative;
        background: url('/dist/img/login-bg.jpg') no-repeat;
        background-size: cover;
        -webkit-background-size: cover;
        -o-background-size: cover;
        background-position: center 0;

    }
    .open_register .form-group{
        margin-bottom: 5px;
    }
    .register-box{
        position: absolute;
        height: 635px;
        left: 0;
        top: 0;
        bottom: 40px;
        right: 0;
        margin: auto;
    }
    .register-box{
        opacity: 0.9;
    }
    .has-feedback label~.form-control-feedback{
        top: 20px;
    }
    .control-label{
        margin-bottom:0px;
    }
    .btn-register{
        padding-right: 0px;
    }
    .has-error .checkbox-label{
        color: #dd4b39;
    }
    .row-col{
        padding: 0px;
    }
    .count-down{
        color: red;
    }
</style>
