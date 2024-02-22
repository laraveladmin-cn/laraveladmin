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
    amap_config:null,
    google_config:null,
    def_avatar:'/dist/img/user_default_180.gif',
    page_gray:0,//页面灰色
    wechat_appid:'',
    app_key:'85d29c9cfb2f1ec559d46ea2811bf2ef',
    //加密要提交数据
    encryptData(data_str,server_rsa_pub){
        const key = this.app_key;
        const iv = CryptoJS.MD5(Date.now()).toString().slice(0,16);
        //const iv = '025c8c1a9065b789';
        let data = CryptoJS.AES.encrypt(data_str, CryptoJS.enc.Utf8.parse(key), {
            iv: CryptoJS.enc.Utf8.parse(iv),
            mode: CryptoJS.mode.CBC,
            padding: CryptoJS.pad.Pkcs7
        }).toString(); //业务数据加密
        //console.log(data_str,key,data,iv);
        const encryptor = new JSEncrypt();
        encryptor.setPublicKey(server_rsa_pub);
        // 使用公钥加密解密向量数据
        let aes_key = encryptor.encrypt(iv);
        let res = {
            aes_key:aes_key,
            data:data
        };
        let sign = CryptoJS.MD5(JSON.stringify(res)+key).toString();
        res.sign = sign;
        return res;
    },
    //解密后端响应数据
    decryptData(raw_data,pri_key){
        if(!raw_data){
            //console.log('解密源数据必填');
            return false;
        }
        let sign = raw_data.sign;
        let data = raw_data.data;
        let aes_key = raw_data.aes_key;
        if(!sign || !data || !aes_key){
            //console.log('解析解密源数据项错误');
            return false;
        }
        const key = this.app_key;
        if(sign!==CryptoJS.MD5(collect(raw_data).except(['sign']).toJson()+key).toString()){
            //console.log('解析验签失败');
            return false;
        }
        const encryptor = new JSEncrypt();
        encryptor.setPrivateKey(pri_key);
        // 使用公钥加密解密向量数据
        let iv = encryptor.decrypt(aes_key);
        let result = CryptoJS.AES.decrypt(data, CryptoJS.enc.Utf8.parse(key), {
            iv: CryptoJS.enc.Utf8.parse(iv),
            mode: CryptoJS.mode.CBC,
            padding: CryptoJS.pad.Pkcs7
        });
        return JSON.parse(result.toString(CryptoJS.enc.Utf8));
    },
    ...(window.AppConfig || {})
};
AppConfig.language = (localStorage.getItem('language') || AppConfig.default_language).replace(/\_/g,'-');
//使用请求地址
AppConfig.use_url = AppConfig.api_url_model=='web'? AppConfig.web_url: AppConfig.api_url;
window.AppConfig = AppConfig;
export default AppConfig;
