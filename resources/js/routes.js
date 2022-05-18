let page403 = () => import(/* webpackChunkName: "errors/403.vue" */ './pages/errors/403.vue');
let page404 = () => import(/* webpackChunkName: "errors/404.vue" */ './pages/errors/404.vue');
let page503 = () => import(/* webpackChunkName: "errors/503.vue" */ './pages/errors/503.vue');
let page500 = () => import(/* webpackChunkName: "errors/500.vue" */ './pages/errors/500.vue');
import routesConfig from '../../routes/route';
let routes = [
    { path: '/', redirect: '/open/index' }, //根目录跳转
    {path: '/503', component: page503},
    {path: '/500', component: page500},
    {path: '/403', component: page403},
    {path: '*', component: page404},
];

collect(routesConfig.group).map((group,key)=>{
    group.prefix = group.prefix || '';
    if(group.prefix && group.prefix.split('/').length>2){
        group.prefix = '/'+group.prefix.split('/')[1];
    }
    group.name = key;
    return group;
}).values()
    .groupBy('prefix')
    .map((groups,name)=>{
    let group_names = collect(groups).pluck('name');
    let filter = (item)=>{
        if ((item.env && window.AppConfig && window.AppConfig.env && item.env!=window.AppConfig.env) || item._is_deleted){
            return false;
        }
        return (!item.disabled || item.disabled==0 || item.disabled=='Enable' || item.disabled=='启用') && (item.is_page==1 || item.is_page=='Yes' || item.is_page=='是') && group_names.contains(item.group) && item.url;
    };
    //子页面
    let children = collect(routesConfig.menus).filter(filter).map((item)=>{
        let path_arr = item.url.split('/');
        path_arr.shift();
        path_arr.shift();
        let path = path_arr.join('/');
        let path1 = ((name?name+'/':'')+path).replace(/-/g,'_');
        let pathName = 'pages'+path1+'.vue';
        let route = {
            path: path,
            component: () => import(/* webpackChunkName: "[request]" */ `./${pathName}`)
        };
        if(path=='index'){
            route.alias = '/';
        }
        return route;
    });
    collect(routesConfig.resource).filter(filter).map((item)=>{
        let path_arr = item.url.split('/');
        path_arr.shift();
        path_arr.shift();
        let path = path_arr.join('/');
        let path1 = ((name?name+'/':'')+path).replace(/-/g,'_');
        path1 = path=='index'?path1:path1+'/index';
        let pathName = 'pages'+path1+'.vue';
        let route = {
            path: path,
            component: () => import(/* webpackChunkName: "[request]" */ `./${pathName}`)
        };
        if(path=='index'){
            route.alias = '/';
        }
        children.push(route);
        if(path!='index'){
            let path2 = (path1+'.vue').replace('index.vue','edit').replace(/-/g,'_');
            let pathName2 = 'pages'+path2+'.vue';
            let edit = {
                path: path+'/:id',
                component: () => import(/* webpackChunkName: "[request]" */ `./${pathName2}`)
            };
            children.push(edit);
        }

    });
    children = children.merge([{
            path: '503',
            component: page503
        },{
            path: '500',
            component: page500
        },{
            path: '403',
            component: page403
        },{
            path: '*',
            component: page404
        }]).all();
    if(name){
        let path1 = (name?name+'/':'')+'layout';
        let pathName = 'pages'+path1+'.vue';
        let module =  {
            path: name,
            component: () => import(/* webpackChunkName: "[request]" */ `./${pathName}`),
            children:children
        };
        routes.push(module);
    }
});
export default routes;
