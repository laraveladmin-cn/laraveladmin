import AppConfig from "../config";

export default {
    isNull:function (arg1){
        return !arg1 && arg1!==0 && typeof arg1!=="boolean"?true:false;
    },
    //获取多级数据
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
            if (typeof reslut != "object" || this.isNull(reslut)) {
                return def;
            }
            reslut = reslut[keys[i]];
            if (typeof reslut == "undefined") {
                return def;
            }
        }
        return reslut === '' ? def : reslut;
    },
    catchError(error){
        let data = error.response ? error.response.data : {};
        let errors = {};
        if(typeof data == "object"){
            data = data.errors;
            if(typeof data=='undefined'){
                //window.location.reload();
            }
            for(let i in data){
                errors[i] = [];
                if(typeof data[i]== "object"){
                    for(let j in data[i]){
                        data[i][j] = data[i][j]+'';
                        errors[i][errors[i].length]= data[i][j].replace(i,'').replace(i.replace('_',' '),'');
                    }
                }else {
                    data[i] = data[i]+'';
                    errors[i][errors[i].length]=data[i].replace(i,'').replace(i.replace('_',' '),'');
                }
            }
            return errors;
        }
        return errors;
    },
    copyObj:function(obj){
        return JSON.parse(JSON.stringify(obj || {}));
    },
    dd:function () {
        if(!AppConfig.debug){
            return;
        }
        for (let i in arguments){
            console.log(arguments[i]);
        }
    },
    count:function (obj) {
        return collect(obj).count()
    },
    setCookie: function (cname,cvalue,exdays) {
        let d = new Date();
        d.setTime(d.getTime()+(exdays*24*60*60*1000));
        let expires = "expires="+d.toGMTString();
        let cookie = cname + "=" + cvalue + "; " + expires+";path=/;";
        if(window.AppConfig.domain){
            cookie = cookie+'domain='+window.AppConfig.domain+';';
        }
        document.cookie = cookie;
    },
    getCookie:function (cname)
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
    }

}
