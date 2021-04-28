//菜单数据存储
//把返回的数据集转换成Tree
import {retrieveColumnLayout} from "echarts/src/layout/barGrid";
import i18n from '../i18n';
let list_to_tree = function(data, pk='id', pid = 'parent_id', child = 'childs'){
    // 删除 所有 children,以防止多次调用
    data.forEach(function (item) {
        delete item[child];
    });
    // 将数据存储为 以 id 为 KEY 的 map 索引数据列
    var map = {};
    data.forEach(function (item) {
        map[item[pk]] = item;
    });
    var val = [];
    data.forEach(function (item) {
        // 以当前遍历项，的pid,去map对象中找到索引的id
        var parent = map[item[pid]];
        // 好绕啊，如果找到索引，那么说明此项不在顶级当中,那么需要把此项添加到，他对应的父级中
        if (parent) {
            (parent[child] || ( parent[child] = [] )).push(item);
        } else {
            //如果没有在map中找到对应的索引ID,那么直接把 当前的item添加到 val结果集中，作为顶级
            val.push(item);
        }
    });
    return val;
};
let $tp = function (key,index,params) {
    let prefix = '';
    if(typeof index=="object" && index['{lang_path}']){
        prefix = index['{lang_path}']+'.';
    }else if(typeof params=="object" && params['{lang_path}']){
        prefix = params['{lang_path}']+'.';
    }
    let root = 'pages.';
    if(typeof index=="object" && typeof index['{lang_root}']=="string"){
        root = index['{lang_root}'];
    }else if(typeof params=="object" && typeof params['{lang_root}']=="string"){
        root = params['{lang_root}'];
    }
    let k = root+prefix+key;
    let res;
    if(typeof params=="undefined"){
        res = i18n.t(k,index);
    }else {
        res = i18n.t(k,index,params);
    }
    if(res.indexOf(root+prefix)==0){
        return key;
    }
    return res;
};
let translation = function (item,key,shared){
    let $this = i18n.vm;
    let value = array_get(item,key,'');
    let resource_id = item['resource_id'];
    let res = $tp(value , shared);
    if(resource_id && res==value && ($this._i18n.locale!='en' || value.indexOf('{')!=-1)){ //没有翻译成功
        let parent_name = array_get(item,'parent.item_name','') || array_get(item,'parent.name','') || '';
        let key = value.replace(parent_name,'{name}');
        if(key.indexOf('{name}')==0){
            shared.name=$tp(parent_name,shared);
        }else {
            key = value.replace(parent_name.toLowerCase(),'{name}');
            shared.l_name=$tp(parent_name,shared);
            key = key.replace('{name}','{l_name}');
        }
        res = $tp(key , shared);
    }
    return res;
};
export default {
    namespaced: true,
    state:{
        menus:[],
        path:'',
        keywords:'',
        loading:true, //加载中
        last_menu_show:{ //最后一个菜单显示
            name:'',
            description:''
        },
        shared: {
            "{lang_path}": '_shared.menus',
            '{lang_root}': ''
        },
    },
    mutations:{
        //更新state状态
        set (state,payload) {
            state[payload.key] = payload[payload.key];
        }
    },
    actions:{
        //获取菜单数据
        getMenus({ state, commit, rootState }){
            commit({
                type: 'set',
                key:'loading',
                loading: true
            });
            axios.get(rootState['use_url']+'/open/menu').then(function (response) {
                if (typeof response.data != 'undefined' && typeof response.data.menus != 'undefined') {
                    commit({
                        type: 'set',
                        key:'menus',
                        menus: response.data.menus || []
                    });
                }
                commit({
                    type: 'set',
                    key:'loading',
                    loading: false
                });
            }).catch(function (error) {
                commit({
                    type: 'set',
                    key:'loading',
                    loading: false
                });
            });
        }
    },
    getters:{
        //当前菜单
        current_menu(state){
            return collect(state.menus).sortBy('right_margin').first(function (menu) {
                return state.path && (state.path==menu['url'] || state.path+'/index'==menu['url']) && (menu['method'].indexOf(1)!=-1);
            }) || {};
        },
        module_route(state,getters){
            let root = state.path.split('/')[1];
            root = (root?'/'+root:'')+'/';
            return root;
        },
        //是否有权限 false:加载中,0:有权限,1-没有页面,2-没有权限
        no_permission(state,getters){
            if(state.loading){
                return false;
            }
            let root = getters.module_route;
            if(!getters.current_menu.id && [root+'403',root+'404',root+'500',root+'*'].indexOf(state.path)==-1){
                if(state.path==root+'*'){
                    return 1;
                }
               return 2;
            }
            return 0;
        },
        //菜单导航
        navbars(state,getters){
            let currentMenu = getters.current_menu;
            let has = typeof currentMenu.left_margin !="undefined";
            if(!has){
                let path = '/'+state.path.split('/')[1]+'/index';
                currentMenu = collect(state.menus).sortBy('right_margin').first(function (menu) {
                    return path && (path==menu['url'] || state.path+'/index'==menu['url']) && (menu['method'].indexOf(1)!=-1);
                }) || {};
            }
            let navbars = collect(state.menus).sortBy('left_margin').filter(function (menu) {
                return menu['left_margin']<=currentMenu['left_margin'] && menu['right_margin']>=currentMenu['right_margin']
            }).map(function (menu) {
                menu = window.copyObj(menu);
                menu.active = menu['id']==currentMenu['id'];
                return menu;
            }).all();
            if(!has){
                navbars = copyObj(navbars);
                let last = collect(navbars).last() || {};
                last.icons = 'fa-warning';
                if(state.path.indexOf('500')!=-1){
                    last.name = '500 page';//'500页面';
                }else if(state.path.indexOf('403')!=-1){
                    last.name = '403 page';//'403页面';
                }else {
                    last.name = '404 page';//'404页面';
                }
            }
            return navbars;
        },
        //选中的一级菜单
        root(state,getters){
            return collect(getters.navbars).first() || {};
        },
        //一级菜单模块
        modules(state,getters){
            return state.menus.filter(function (item) {
                return item['parent_id']==1 && item['status']==1;
            }).map(function (menu) {
                menu.active = menu['id']==getters.root['id'];
                return menu;
            });
        },
        //树状结构菜单
        tree_menus(state,getters){
            let menus = collect(state.menus).filter(function (menu) {
                    return menu['left_margin']>getters.root['left_margin'] && menu['right_margin']<getters.root['right_margin'] && menu['status']==1;
                }).map(function (menu) {
                if(menu['url']==state.path || menu['url'].replace('/index','')==state.path){
                    menu.active = true;
                }else{
                    let currentMenu = getters.current_menu;
                    if(currentMenu && currentMenu['left_margin']>=menu['left_margin'] && currentMenu['right_margin']<=menu['right_margin']){
                        menu.active = true;
                    }else {
                        menu.active = false;
                    }
                }
                return menu;
            });
            if(state.keywords){
                let filter_menus = menus.filter(function (menu) {
                    return menu['name'].indexOf(state.keywords)!=-1 || translation(menu,'name',state.shared).indexOf(state.keywords)!=-1;
                });
                menus = menus.filter(function (menu) {
                    let flog = false;
                    filter_menus.map((filter_menu)=>{
                        if(menu['left_margin']<=filter_menu['left_margin'] && menu['right_margin']>=filter_menu['right_margin'] ){
                            if(menu['left_margin']!=filter_menu['left_margin']){
                                menu.active = true;
                            }
                            flog = true;
                        }
                    });
                    return flog;
                });
            }
            return copyObj(list_to_tree(menus.all(),'id','parent_id','childrens'));
        },
    }
};
