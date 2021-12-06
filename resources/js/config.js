let AppConfig = {
    //标签样式
    statusClass:[
        'default',
        'primary',
        'success',
        'info',
        'danger',
        'warning',
        'primary',
        'success',
        'info',
        'danger',
        'warning',
    ],
    alerts:[],
    modal:null,
    _token:'',
    api_url:'/api',
    app_url:'',
    web_url:'/web-api',
    domain:'',
    lifetime:120,
    verify:{
        type:'geetest',
        dataUrl:'/open/geetest',
        data:{
            client_fail_alert:"请正确完成验证码操作",
            lang:"zh-cn",
            product:"float",
            http:"http://"
        }
    },
    debug:true,
    client_id:'',
    api_url_model:'web',
    use_url:'',
    env:'',
    language:'',
    default_language:'',
    locales:[
        'zh-CN','en'
    ],
    tinymce_key:'',
    theme: localStorage.getItem('theme') || 'primary',//主题
    ...(window.AppConfig || {})
};
AppConfig.language = (localStorage.getItem('language') || AppConfig.default_language).replace(/\_/g,'-');
//使用请求地址
AppConfig.use_url = AppConfig.api_url_model=='web'? AppConfig.web_url: AppConfig.api_url;
window.AppConfig = AppConfig;
export default AppConfig;
