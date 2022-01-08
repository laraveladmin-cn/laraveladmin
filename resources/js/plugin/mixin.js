import {mapState, mapActions, mapMutations} from 'vuex';
import config from '../config.js';

export default {
    computed: {
        ...mapState([
            'statusClass',
            'use_url',
            'url',
            'lifetime',
            'theme'
        ])
    },
    methods: {
        ...mapActions({
            refreshToken: 'refreshToken',
            pushMessage: 'pushMessage',
            refreshClientId: 'refreshClientId',
            logout: 'user/logout', //退出登录
        }),
        ...mapMutations({
            setLanguage: 'setLanguage',
        }),
        upCookie() {
            let authorization = getCookie('Authorization');
            if (authorization) {
                setCookie('Authorization', authorization, this.lifetime / 1440);
            }
        }
    },
    created() {
        //默认语言包
        this.setLanguage(config.language);
        $('body').addClass(this.theme);
        //添加弹窗拦截器
        window.axios.interceptors.response.use((response) => {
                //跳转
                if (typeof response.data != 'undefined' &&
                    typeof response.data.force_logout != 'undefined' &&
                    response.data.force_logout
                ) {
                    this.logout({
                        force_logout:true,
                        data:{
                            key:'modal',
                            modal:{
                                title:this.$t('Prompt'),
                                content: this.$t('Your account has been logged in elsewhere'),
                                hideCancel:true
                            }
                        }
                    });
                } else if (typeof response.data != 'undefined' &&
                    typeof response.data.redirect != 'undefined' &&
                    response.data.redirect
                ) {
                    if (response.data.redirect.indexOf('http://') == 0 ||
                        response.data.redirect.indexOf('https://') == 0
                    ) { //跳转外部页面
                        window.location.href = response.data.redirect;
                    } else {
                        if (response.status == 200) {
                            this.$router.push({path: response.data.redirect}).catch(error => {
                                dd(error.message);
                            });
                        } else {
                            this.$router.replace({path: response.data.redirect}).catch(error => {
                                dd(error.message);
                            });
                        }
                    }
                }
                //消息提醒
                if (typeof response.data != 'undefined' &&
                    typeof response.data.alert != 'undefined' &&
                    response.data.alert
                ) {
                    this.pushMessage(response.data.alert);
                }
                //登录信息更新
                if (!response.data._token) {
                    this.upCookie();
                }
                return response;
            },
            (error) => {
                //跳转
                if (typeof error.response != 'undefined' &&
                    typeof error.response.data != 'undefined' &&
                    typeof error.response.data.force_logout != 'undefined' &&
                    error.response.data.force_logout
                ) {
                    this.logout({
                        force_logout:true,
                        data:{
                            key:'modal',
                            modal:{
                                title:this.$t('Prompt'),
                                content: this.$t('Your account has been logged in elsewhere'),
                                hideCancel:true
                            }
                        }
                    });
                } else if (typeof error.response != 'undefined' &&
                    typeof error.response.data != 'undefined' &&
                    typeof error.response.data.redirect != 'undefined' &&
                    error.response.data.redirect
                ) {
                    this.$router.replace({path: error.response.data.redirect}).catch(error => {
                        dd(error.message);
                    });
                } else if (error.response.status == 503) {
                    this.$router.push({path: '/503'}).catch(error => {
                    });
                } else if (!error.response || (error.response && error.response.status != 422 && error.response.status != 200)) {
                    let message = {
                        'showClose': true, //显示关闭按钮
                        'title': this.$t('An error occurred while requesting the server, please contact the developer in time'),//'请求服务器时发生错误,请及时联系开发人员!', //消息内容
                        'message': '', //消息内容
                        'type': 'danger', //消息类型
                        'position': 'top',
                        'iconClass': 'fa-close', //图标
                        'customClass': '', //自定义样式
                        'duration': 3000, //显示时间毫秒
                        'show': true //是否自动弹出
                    };

                    //token过期
                    if (error.response.status == 419 && error.response.data.message.indexOf('token') != -1) {
                        this.refreshToken();
                        message.title = this.$t('Token has expired, please try again');
                    }

                    if (error.response.data.alert) {
                        this.pushMessage(error.response.data.alert);
                    } else {
                        this.pushMessage(message);
                    }
                }
                return Promise.reject(error);
            });

        /**
         * ajax提交请求
         * 参数格式化
         */
        window.axios.interceptors.request.use(function (config) {
            let token = getCookie('Authorization');
            if (token) {
                config.headers.Authorization = decodeURIComponent(token);
            }
            let language = localStorage.getItem('language');
            if (language) {
                config.headers.Language = decodeURIComponent(language);
            }
            config.headers.RefererPage = window.location.href;
            config.paramsSerializer = function (params) {
                params = JSON.parse(JSON.stringify(params));
                params['json'] = 1;
                return jQuery.param(params);
            };
            return config;
        }, function (error) {
            return Promise.reject(error);
        });
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        window.axios.defaults.withCredentials = true;
        //获取连接ID唯一标识
        this.refreshClientId();
        //CSRF _token更新
        setTimeout(() => {
            this.refreshToken();
        }, 1500);
        setInterval(() => {
            this.refreshToken();
        }, 7200000);

    },


};
