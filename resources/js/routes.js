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
collect(['open','home','admin']).map((name)=>{
    //子页面
    let children = collect(routesConfig.menus).filter((item)=>{
        return item.disabled==0 && item.is_page==1 && item.group==name && item.url;
    }).map((item)=>{
        let path_arr = item.url.split('/');
        path_arr.shift();
        path_arr.shift();
        let path = path_arr.join('/');
        let path1 = (name+'/'+path).replace('-','_');
        let pathName = 'pages/'+path1+'.vue';
        let route = {
            path: path,
            component: () => import(/* webpackChunkName: "[request]" */ `./${pathName}`)
        };
        if(path=='index'){
            route.alias = '/';
        }
        return route;
    });
    collect(routesConfig.ressorce).filter((item)=>{
        return item.disabled==0 && item.is_page==1 && item.group==name && item.url;
    }).map((item)=>{
        let path_arr = item.url.split('/');
        path_arr.shift();
        path_arr.shift();
        let path = path_arr.join('/');
        let path1 = (name+'/'+path).replace('-','_');
        path1 = path=='index'?path1:path1+'/index';
        let pathName = 'pages/'+path1+'.vue';
        let route = {
            path: path,
            component: () => import(/* webpackChunkName: "[request]" */ `./${pathName}`)
        };
        if(path=='index'){
            route.alias = '/';
        }
        children.push(route);
        if(path!='index'){
            let path2 = (path1+'.vue').replace('index.vue','edit').replace('-','_');
            let pathName2 = 'pages/'+path2+'.vue';
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
    let path1 = name+'/layout';
    let pathName = 'pages/'+path1+'.vue';
    let module =  {
        path: '/'+name,
        component: () => import(/* webpackChunkName: "[request]" */ `./${pathName}`),
        children:children
    };
    routes.push(module);
});
export default routes;
