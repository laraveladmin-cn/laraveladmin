/**
 * 使用插件
 */
import 'es6-promise/auto';
import Vue from 'vue';
window.Vue = Vue;
import mixin from './plugin/mixin';
import VueRouter from 'vue-router'; //路由插件
Vue.use(VueRouter);
import Vuex from 'vuex'; //数据存储插件
Vue.use(Vuex);
import VueClipboard from 'vue-clipboard2';//复制到粘贴板组件
Vue.use(VueClipboard);
import './plugin/index.js'; //自定义插件
//路由注册
import routes from './routes.js';
const router = new VueRouter({
    mode:
        'history',
        //'hash',
    routes
});

//全局存储对象
import storeData from './store.js';
const store = new Vuex.Store(storeData);

/**
 * 实例化应用
 */
const app = new Vue({
    mixins: [mixin],
    router,
    store
}).$mount('#app');
