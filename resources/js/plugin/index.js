import helpers from './helpers';
import filters from './filters';
import Vue from 'vue';
import './validate.js';
import AppConfig from "../config";
export default Plugin = {
    install(Vue, options){
        //全局变量注册
        if(typeof window !== 'undefined'){
            for (let name in helpers) {
                window[name] = helpers[name];
                Vue.filter(name,helpers[name]);
            }
        }
        //全局过滤器注册
        for (let name in filters) {
            Vue.filter(name,filters[name]);
        }

        //设置数据
        Vue.prototype.setData = function (data) {
            for(let key in data){
                this[key] = data[key];
            }
        };

        Vue.prototype.getOptions = function(obj){
            return JSON.stringify(obj || {});
        };

        Vue.prototype.array_get = helpers.array_get;

        Vue.prototype.count = helpers.count;

        //获取数据
        Vue.prototype.getData = function(params,url,key){
            if(this.loading){
                return false;
            }
            this.loading = true;
            url = url || this.$router.currentRoute.path;
            let use_url = helpers.array_get(window,'AppConfig.use_url','');
            axios.get(use_url+url,{params:params}).then( (response)=> {
                for (let i in response.data ) {
                    if(key){
                        Vue.set(this[key],i,response.data[i]);
                    }else {
                        Vue.set(this,i,response.data[i]);
                    }

                }
                this.loading = false;
            }).catch((error) => {
                this.loading = false;
            });
        };
        Vue.prototype.toUrl = function(url,event){
            if(!url){
                return
            }
            let oEvent=window.event || event;
            //获取ctrl 键对应的事件属性
            let bCtrlKeyCode = oEvent.ctrlKey || oEvent.metaKey;
            let is_external = url.indexOf('http://')==0 || url.indexOf('https://')==0;
            //新窗口打开
            if(bCtrlKeyCode){
                if(!is_external){
                    url = AppConfig.app_url+url;
                }
                window.open(url,'_blank');
                return;
            }
            if(is_external){
                window.location.href=url;
            }else {
                this.$router.push({ path: url }).catch(error => {
                    dd(error.message);
                });
            }
        };
        //指定路径翻译
        Object.defineProperty(Vue.prototype, '$tp', {
            get: function get () {
                let $this = this;
                return function (key,index,params) {
                    let prefix = '';
                    if(typeof index=="object" && index['{lang_path}']){
                        prefix = index['{lang_path}']+'.';
                    }else if(typeof params=="object" && params['{lang_path}']){
                        prefix = params['{lang_path}']+'.';
                    }else if($this['{lang_path}']){
                        prefix = $this['{lang_path}']+'.';
                    }
                    let root = 'pages.';
                    if(typeof index=="object" && typeof index['{lang_root}']=="string"){
                        root = index['{lang_root}'];
                    }else if(typeof params=="object" && typeof params['{lang_root}']=="string"){
                        root = params['{lang_root}'];
                    }else if(typeof $this['{lang_root}']=="string"){
                        root = $this['{lang_root}'];
                    }
                    let k = root+prefix+key;
                    let res;
                    if(typeof params=="undefined"){
                        res = $this.$t(k,index);
                    }else {
                        res = $this.$t(k,index,params);
                    }
                    if(res.indexOf(root+prefix)==0){
                        return key;
                    }
                    return res;
                }
            }
        });

    }
};
Vue.use(Plugin);
