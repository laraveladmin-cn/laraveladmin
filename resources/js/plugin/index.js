import helpers from './helpers';
import filters from './filters';
import Vue from 'vue';
import './validate.js';
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
        }

    }
};
Vue.use(Plugin);
