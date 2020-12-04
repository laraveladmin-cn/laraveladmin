<template>
    <div class="open_login hold-transition login-page h100" v-if="loaded">
        <div class="login-box center-block" :style="{height:(otherLogin.length && !other)? '455px':'390px'}">
            <logo></logo>
            <div class="login-box-body">
                <p class="login-box-msg">{{other ? '用户绑定':'用户登录'}}</p>
                <validation-observer ref="login" v-slot="{invalid,validate}">
                    <form method="post">
                        <form-item v-model="username" :options="{key:'username',name:'账号',rules:'required|min:5|max:18',icon:'glyphicon-envelope',placeholder:'请输入账号/邮箱/手机号码'}"></form-item>
                        <form-item v-model="password" :options="{key:'password',name:'密码',rules:'required|min:6|max:18'}">
                            <password-edit v-model="password" :placeholder="'请输入密码'" @keydown-enter="postLogin(invalid,validate)">
                            </password-edit>
                        </form-item>
                        <form-item v-if="mustVerify" v-model="verifyCode" :options="{key:'verify',name:'验证码',rules:'required',messages:{required:'{_field_} 必须验证'}}">
                            <geetest v-if="verify['type']=='geetest' && mustVerify" :url="web_url+verify['dataUrl']" v-model="verifyCode" :data="verify['data']" class="geetest-code"></geetest>
                            <captcha v-if="verify['type']=='captcha' && mustVerify" :url="verify['dataUrl']" v-model="verifyCode" :data="verify['data']"></captcha>
                        </form-item>
                        <div class="social-auth-links row">
                            <div class="col-xs-8">
                                <div class="checkbox icheck">
                                    <icheck v-model="remember" option="1">
                                        记住登录
                                    </icheck>
                                </div>
                            </div>
                            <div class="col-xs-4" style="padding-right: 0px">
                                <button type="button"
                                        class="btn btn-primary btn-block btn-flat"
                                        :disabled="logining"
                                        @click="postLogin(invalid,validate)">
                                    {{logining?'登录中...':'登录'}}
                                </button>
                            </div>
                        </div>
                  </form>
                </validation-observer>
                <div class="social-auth-links text-center other-login" v-if="otherLogin.length && !other">
                    <p>---------------- 其它登录方式 ----------------</p>
                    <div class="row">
                        <div :class="'col-xs-'+other_col" v-for="item in otherLogin">
                            <a :href="web_url+item['url']">
                                <div class="img-circle icon login-icon" :class="item['class']">
                                    <i class="fa" :class="'fa-'+item['type']"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="social-auth-links row">
                    <router-link class="pull-left" to="/open/password">
                        忘记密码
                    </router-link>
                    <router-link class="pull-right" to="/open/register">注册账号</router-link>
                </div>
            </div>
           <!-- <icp></icp>-->
        </div>

    </div>
</template>

<script>
    import { mapState, mapActions,mapMutations } from 'vuex';
    import {ValidationObserver} from 'vee-validate';
    export default {
        components: {
            //滑块验证组件
            geetest:()=>import(/* webpackChunkName: "common_components/geetest.vue" */ 'common_components/geetest.vue'),
            //图片验证码组件
            captcha:()=>import(/* webpackChunkName: "common_components/captcha.vue" */ 'common_components/captcha.vue'),
            //页面底部组件
            icp:()=>import(/* webpackChunkName: "open_components/icp.vue" */ 'open_components/icp.vue'),
            //页面头部组件
            logo:()=>import(/* webpackChunkName: "open_components/logo.vue" */ 'open_components/logo.vue'),
            icheck:()=>import(/* webpackChunkName: "common_components/icheck.vue" */ 'common_components/icheck.vue'),
            formItem:()=>import(/* webpackChunkName: "open_components/formItem.vue" */ 'open_components/formItem.vue'),
            passwordEdit: ()=>import(/* webpackChunkName: "common_components/passwordEdit.vue" */ 'common_components/passwordEdit.vue'),
            ValidationObserver
        },
        props: {},
        data() {
            return {
                username:'',
                remember:false,
                mustVerify:false,
                password:'',
                verifyCode:'',
                //三方登录配置
                otherLogin: [],
                other:this.$route.params.other || '',
                errors:{},
                loading:false,
                logining:false
            }
        },
        methods:{
            //登录成功后处理
            loginSucces(res){
                this.refreshToken();
                this.verifyCode = '';
                if(res.status==200 && res.data.token){
                    setCookie('Authorization','Bearer '+res.data.token,res.data.lifetime/60/24);
                }else if(res.data.errors){
                    let errors = catchError({response:res});
                    this.errorFun(errors);
                }
                this.logining = false;
                this.loading = false;
            },
            errorFun(errors){
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
                if(errors['verify']){
                    this.mustVerify = true;
                }
                this.verifyCode = '';
            },
            //用户登录
            postLogin(invalid,validate){
                let callback = ()=>{
                    if(this.logining){
                        return ;
                    }
                    this.logining = true;
                    let post_data = {};
                    post_data['username'] = this.username || '';
                    post_data['password'] = this.password;
                    if(this._token){
                        post_data['_token'] = this._token;
                    }
                    if(this.verify.type=='captcha'){
                        post_data['verify'] = this.verifyCode;
                    }else {
                        post_data['verify'] = $(this.$el).find("input[name='geetest_challenge']").val();
                        post_data['geetest_validate'] = $(this.$el).find("input[name='geetest_validate']").val();
                        post_data['geetest_seccode'] = $(this.$el).find("input[name='geetest_seccode']").val();
                    }
                    post_data['remember'] = this.remember ? 1 : undefined;
                    post_data['other'] = this.other;
                    axios.post(this.web_url+this.$router.currentRoute.path,post_data)
                        .then(this.loginSucces)
                        .catch((error)=>{
                            let errors = catchError(error);
                            this.errorFun(errors);
                            this.logining = false;
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
            ...mapActions({
                refreshToken: 'refreshToken'
            }),
            //全局数据设置,设置弹窗提示
            ...mapMutations({
                set:'set'
            }),
            getData(){
                if(this.loading){
                    return;
                }
                this.loading = true;
                axios.get(window.AppConfig['use_url']+this.$router.currentRoute.path).then( (response) =>{
                    if(response.data){
                        this.setData(response.data);
                        let query = this.$router.currentRoute.query;
                        if(query.type && collect(this.otherLogin).pluck('type').contains(query.type)){
                            this.otherLoginCallback(query);
                        }
                    }
                    this.loading = false;
                }).catch( (error)=> {
                    this.loading = false;
                });
            },
            //三方登录
            otherLoginCallback(query){
                this.loading = true;
                axios.get(this.web_url+'/open/other-login-callback/'+query.type,{params:query}).then((res)=>{
                    if(res.data.other){
                        this.other = res.data.other;
                        this.set({
                            key:'modal',
                            modal:{
                                title:'提示',
                                content: '您还没有账号,跳转到注册页面进行注册并绑定?',
                                cancelText:'登录',
                                affirmText:'注册',
                                callback:()=>{
                                    this.$router.push({ path: '/open/register?other='+this.other });
                                },
                                cancel:()=>{ //取消

                                }
                            }
                        });
                    }
                    this.loginSucces(res);
                }).catch( (error) =>{
                    this.loading = false;
                });
            }
        },
        computed:{
            validation(){
                return this.$refs['login'];
            },
            other_col(){
                let count = this.otherLogin.length;
                let other_col = Math.ceil(12/count);
                return other_col<2?2:other_col;
            },
            ...mapState(['_token','verify','use_url','web_url']),
            loaded(){
                return !this.loading;
            }
        },
        mounted() {

        },
        created() {
            this.getData();
        },


    };
</script>
<style lang="scss" scoped>
    .open_login {
        position: relative;
        background: url('/dist/img/login-bg.jpg') no-repeat;
        background-size: cover;
        -webkit-background-size: cover;
        -o-background-size: cover;
        background-position: center 0;
    }

    .login-box {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 40px;
        right: 0;
        margin: auto;
    }
    .login-box-body{
        opacity: 0.9;
    }
    .geetest-code{
        margin-top: 5px;
    }
</style>


