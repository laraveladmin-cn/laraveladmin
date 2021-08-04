if(!AppConfig){
    window.AppConfig = {};
}
const dd = function () {
    for (let i in arguments){
        console.log(arguments[i]);
    }
};
const getCookie = function (cname)
{
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for(let i=0; i<ca.length; i++)
    {
        let c = ca[i].trim();
        if (c.indexOf(name)==0){
            return c.substring(name.length,c.length);
        }
    }
    return "";
};
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
const copyObj = function(obj){
    return JSON.parse(JSON.stringify(obj || {}));
};
const App = {
    components:{},
    data() {
        let token = getCookie('Authorization');
        if(token){
            token= decodeURIComponent(token);
        }
        return {
            api: null, //请求接口对象
            back_api:null, //备份接口对象
            result:{}, //响应结果内容
            loading:false, //请求中
            menus:[

            ], //菜单树
            common_headers:[
                {name:'Client-Id',example:AppConfig.client_id||'',title:'认证参数'},
                {name:'Authorization',example:token || '',title:'登录用户认证参数'},
                {name:'Accept-Language',example:AppConfig.default_language||'',title:'国家语言'}
                ], //公共请求头
            common_responses:[
                {
                    "name": "title",
                    "description": "提示"
                }, {
                    "name": "content",
                    "description": "提示内容"
                }, {
                    "name": "redirect",
                    "description": "跳转至页面"
                }
            ],
            menus_url:'/open/menu?type=document',//获取接口请求地址
            api_model:AppConfig.api_url_model||'web',//接口模式
            domain:AppConfig.app_url||'',
            maps:{
                api_model:{
                    'web':'网页模式',
                    'api':'API模式'
                },
                method:{1:'get',2:'post',4:'put',8:'delete'},
                params:{
                    type:{1:'字符串',2:'数字'}
                }
            },
            select:0,
            keywords:'',//菜单关键字搜索
            keywords_back:''
        }
    },
    computed:{
        //可选择的api请求模式
        map_use_api_model(){

        },
        //可选择的请求方式
        map_use_method(){
          return collect(this.maps.method).filter((method,key)=>{
              return this.api.method.indexOf(key-0)!=-1;
              //return this.api.method.indexOf(Math.pow(2,key))!=-1;
          }).all();
        },
        headers(){
            let func = (header)=>{
                return header.example;
            };
            //合并公共headers
            return collect(this.common_headers)
                .filter(func)
                .merge(
                    collect(this.api.headers||[])
                        .filter(func)
                        .all()
                ).pluck('example','name').all();
        },
        use_url(){
            if(this.api_model=='web'){
                return this.domain+'/web-api'
            }
            return this.domain+'/api'
        },
        result_array(){
            if(!collect(this.result.data).keys().count()){
                return [];
            };
            return this.treeToArr(this.result.data,'');
        },
        result_info(){
            let responses = this.api?(this.api.responses || []):[];
            return collect(responses).merge(this.common_responses).map((item)=>{
                item.key = item.name.replace(/\./ig,'-');
                return item;
            }).pluck('description','key').all();
        },
        //组装请求参数
        params(){
            let params = {};
            collect(this.api.params).each((param)=>{
                //this.array_set(params,param.name.replace(/\]/ig,'').replace(/\[/ig,'.'),param.example);
                if(param.example!==''){
                    this.array_set(params,param.name,param.example);
                }
            });
            return params;
        },
        params_str(){
            return Qs.stringify(this.params, {arrayFormat: 'brackets'});
        },
        body_params(){
            let params = {};
            collect(this.api.body_params).each((param)=>{
                this.array_set(params,param.name.replace(/\]/ig,'').replace(/\[/ig,'.'),param.example);
                //if(param.example!==''){
                    this.array_set(params,param.name,param.example);
                //}
            });
            return params;
        },
        api_url(){
            return this.use_url+this.api.url;
        },
        form_api_url(){
            if(this.params_str){
                if(this.api_url.indexOf('?')==-1){
                    return  this.api_url+'?'+this.params_str;
                }else {
                    return  this.api_url+'&'+this.params_str;
                }
            }
            return this.api_url;

        },
        //树状结构菜单
        tree_menus(){
            let menus = collect(this.copyObj(this.menus)).map( (menu) =>{
                let currentMenu = this.api;
                if(currentMenu && currentMenu['left_margin']>=menu['left_margin'] && currentMenu['right_margin']<=menu['right_margin']){
                    menu.active = true;
                }else {
                    menu.active = false;
                }
                return menu;
            });
            if(this.keywords){
                let filter_menus = menus.filter( (menu)=> {
                    return menu['name'].indexOf(this.keywords)!=-1 || (menu['_trans_name'] && menu['_trans_name'].indexOf(this.keywords)!=-1);
                });
                menus = menus.filter( (menu)=> {
                    let flog = false;
                    filter_menus.map((filter_menu)=>{
                        if(menu['left_margin']<=filter_menu['left_margin'] && menu['right_margin']>=filter_menu['right_margin']){
                            if(menu['left_margin']!=filter_menu['left_margin']){
                                menu.active = true;
                            }
                            flog = true;
                        }
                    });
                    return flog;
                });
            }
            let result = this.copyObj(list_to_tree(menus.all(),'id','parent_id','childrens'));
            //dd(result);
            return result;
        },
    },
    methods:{
        search(){
           this.keywords = this.keywords_back;
        },
        waitSearch(){
            this.timer = new Date().getTime();
            setTimeout(()=>{
                if(new Date().getTime() - this.timer >= 200){
                    this.search();
                }
            },210);
        },
        copyObj:copyObj,
        submit(){
            if(this.api.use_method=='get'){
                window.open(this.form_api_url, '_blank');
            }else {
                this.$refs['form'].submit();
            }
        },
        look(){
            if(this.loading){
                return false;
            }
            axios.request({
                params:this.params,
                url:this.api_url,
                baseURL:'',
                data: this.body_params,
                method:this.api.use_method,
                headers:this.headers
            }).then( (response)=> {
                dd(response);
                this.result = response;
                this.loading = false;
            }).catch((error) => {
                this.loading = false;
            });

        },
        reset(){
          this.api = this.copyObj(this.back_api);
        },
        empty(){
          collect(this.api.params).each((item)=>{
              item.example = '';
          });
        },
        emptyPostParams(){
            collect(this.api.body_params).each((item)=>{
                item.example = '';
            });
        },
        addParam(){
            this.api.params.push({
                enable:true,
                name: '', //参数名
                type: 1, //参数类型
                title: '自定义参数', //参数说明
                description:'',
                example: '', //参数事例
                validate: '' //是否为必填参数
            });
        },
        addPostParam(){
            this.api.body_params.push({
                enable:true,
                name: '', //参数名
                type: 1, //参数类型
                title: '自定义参数', //参数说明
                description:'',
                example: '', //参数事例
                validate: '' //是否为必填参数
            });
        },
        deep(num){
            let str = '|';
            for (let i = 1; i < num; ++i) {
                str += '—';
            }
            if (num > 1) {
                return str+':';
            }
            return '';
        },
        treeToArr(tree, key, deep){
            key = key ? key + '-' : '';
            deep = deep ? deep + 1 : 1;
            let result = [];
            if (typeof tree == 'object') {
                for (let i in tree) {
                    if (typeof tree[i] != 'object') {
                        result[result.length] = {"key": key + i, "k": i, "type": typeof tree[i], "value": tree[i], "deep": deep};
                    } else {
                        let type = Array.isArray(tree[i])?'array':typeof tree[i];
                        result[result.length] = {"key": key + i, "k": i, "type": type, "value": '['+type+']', "deep": deep};
                        let res = this.treeToArr(tree[i], key + i, deep);
                        for (let j = 0; j < res.length; j++) {
                            result[result.length] = res[j];
                        }
                    }
                }
            } else {
                result[result.length] = {"key": key, "k": 0, "type": typeof tree, "value": tree, "deep": deep};
            }
            return result;
        },
        is_null:function (arg1){
            return !arg1 && arg1!==0 && typeof arg1!=="boolean"?true:false;
        },
        array_get(arr, key, def){
            def = typeof def == 'undefined' ? '' : def;
            key = String(key);
            if (!arr || !key || (typeof key != 'string' && typeof key != 'number') || (typeof arr != "object")) {
                return def;
            }
            if (key.indexOf('.') == -1) {
                return typeof arr[key] == "undefined" ? def : arr[key];
            }
            let keys = key.split('.');
            let reslut = arr;
            for (let i in keys) {
                if (typeof reslut != "object" || this.is_null(reslut)) {
                    return def;
                }
                reslut = reslut[keys[i]];
                if (typeof reslut == "undefined") {
                    return def;
                }
            }
            return reslut === '' ? def : reslut;
        },
        try_array_get(arr, key, def){
            return this.array_get(arr, key, this.array_get(arr, key.replace(/\-[0-9]{1,}/ig,"-$index"), def));
        },
        dd:dd,
        copyObj:function(obj){
            return JSON.parse(JSON.stringify(obj || {}));
        },
        array_set(arr, key, value){
            if(typeof arr!="object"){
                arr = {};
            }
            let obj = arr;
            let keys = key.split('.');
            for (let i in keys){
                if(i==(keys.length-1)){
                    obj[keys[i]] = value;
                    break;
                }
                if(typeof obj[keys[i]]=="undefined"){
                    obj[keys[i]] = {};
                }
                obj = obj[keys[i]];
            }
            return arr;
        },
        //获取所有接口数据
        getMenus(){
            axios.request({
                url:this.use_url+this.menus_url,
                method:'get'
            }).then( (response)=> {
                if(response.data.menus){
                    //dd(response.data.menus);
                    this.menus = response.data.menus;
                    this.selectMenu();
                }
                this.loading = false;
            }).catch((error) => {
                this.loading = false;
            });
        },
        selectMenu(id){
            //查询第一个接口
            this.api = collect(this.menus).first((menu) =>{
                if(id){
                    return menu.id==id;
                }
                return menu.method.length;
            });
            this.api.use_method = this.array_get(this.maps.method,this.api.method[0],'');
            this.select = this.api.use_method!='get'?1:0;
            //dd(JSON.stringify(this.api));
            this.back_api = this.copyObj(this.api);
            this.result = {};
        }
    },

    watch:{

    },
    created(){
        this.getMenus();
    },
    mounted(){

    }

};
const app = Vue.createApp(App);
let template = '#menus';
app.component('menus',{
    props:{
        menus:{
            type:[Array],
            default: function () {
                return [];
            }
        }

    },
    data: function () {
        return {
            items:copyObj(this.menus)
        }
    },
    watch:{
        menus(menus){
            this.items = copyObj(menus);
        }
    },
    template: template,
    methods:{
        switchItem(menu){
            menu.active = !menu.active;
        },
        selectItem(menu){
            if(menu.method && menu.method.length){
                this.$root.selectMenu(menu.id);
            }
        }
    }
});
app.mount('#app');
