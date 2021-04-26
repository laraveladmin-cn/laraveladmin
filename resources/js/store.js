//全局存储
import menu from './store/menu.js';
import user from './store/user.js';
import notification from './store/menu.js';
import excel from './store/excel.js';
import config from './config.js';
import i18n from './i18n' //语言插件
import { localeChanged } from 'vee-validate';

const loadedLanguages = ['en']; // 我们的预装默认语言
function setI18nLanguage(state,payload){
    document.body.classList.remove(i18n.locale);
    state['language'] = payload;
    localStorage.setItem('language',payload);
    setCookie('Language',payload,365*10);
    i18n.locale = payload;
    localeChanged();
    document.querySelector('html').setAttribute('lang', payload);
    //修改验证码语言
    config.verify.data.lang = payload;
    document.body.classList.add(payload);
    return payload;
}
export default {
    modules:{
        menu:menu,
        user:user,
        notification:notification,
        excel:excel,
    },
    state: config,
    mutations: {
        //更新token
        upToken (state,payload) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = payload.token;
            state._token = payload.token;
        },
        //更新请求唯一标识
        upClientId (state,payload) {
            window.axios.defaults.headers.common['Client-Id'] = payload.client_id;
            state.client_id = payload.client_id;
            setCookie('Client-Id',payload.client_id,365*10);
        },
        //关闭消息
        closeMessage(state,payload){
            state.alerts[payload.key].show = false;
            //消息关闭完后清空所有消息
            if(!collect(state.alerts).filter( (item) =>{
                return item['show'];
            }).count()){
                state.alerts = [];
            }
        },
        //更新state状态
        set (state,payload) {
            state[payload.key] = payload[payload.key];
        },
        setLanguage(state,lang) {
            // 如果语言相同
            if (i18n.locale === lang) {
                return Promise.resolve(setI18nLanguage(state,lang))
            }

            // 如果语言已经加载
            if (loadedLanguages.includes(lang)) {
                return Promise.resolve(setI18nLanguage(state,lang))
            }
            let lang_dir = lang.replace(/-/g,'_');

            // 如果尚未加载语言
            return import(/* webpackChunkName: "lang-[request]" */ `../lang/${lang_dir}/front.json`).then(
                messages => {
                    i18n.setLocaleMessage(lang, messages.default)
                    loadedLanguages.push(lang)
                    return setI18nLanguage(state,lang)
                }
            )
        }
    },
    actions:{
        //刷新token
        refreshToken({commit}){
            if(window.AppConfig.api_url_model!='web'){
                //return ;
            }
            axios.get((window.AppConfig['web_url'] || '')+'/open/token').then( (response) =>{
                if (typeof response.data != 'undefined' && typeof response.data._token != 'undefined') {
                    commit({
                        type: 'upToken',
                        token: response.data._token
                    });
                }
            }).catch( (error)=> {
            });
        },
        //新加消息
        pushMessage({commit,state},message){
            state.alerts.push(message);
            let index = state.alerts.length-1;
            if(message.duration){
                setTimeout( ()=> {
                    commit({
                        type: 'closeMessage',
                        key: index
                    });
                },message.duration);
            }
        },
        //获取连接ID
        refreshClientId({commit,state}){
            let client_id = getCookie('Client-Id');
            if(client_id){
                commit({
                    type: 'upClientId',
                    client_id: client_id
                });
            }else {
                axios.get((window.AppConfig['use_url'] || '')+'/open/client-id').then( (response) =>{
                    if (typeof response.data != 'undefined' && typeof response.data.client_id != 'undefined') {
                        commit({
                            type: 'upClientId',
                            client_id: response.data.client_id
                        });
                    }
                }).catch( (error)=> {
                });
            }
        },

    }
};
