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
            if (typeof reslut != "object" || isNull(reslut)) {
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
    },
    /**
     * 对日期进行格式化，
     * @param date 要格式化的日期
     * @param format 进行格式化的模式字符串
     *     支持的模式字母有：
     *     y:年,
     *     M:年中的月份(1-12),
     *     d:月份中的天(1-31),
     *     h:小时(0-23),
     *     m:分(0-59),
     *     s:秒(0-59),
     *     S:毫秒(0-999),
     *     q:季度(1-4)
     * @return String
     * @author yanis.wang
     */
    date_format(date, format,is_obj){
        if(!format){
            format = 'yyyy-MM-dd hh:mm:ss';
        }
        if(!date){
            return '--';
        }
        if(!is_obj){
            date = new Date(date*1000);
        }

        let map = {
            "M": date.getMonth() + 1, //月份
            "d": date.getDate(), //日
            "h": date.getHours(), //小时
            "m": date.getMinutes(), //分
            "s": date.getSeconds(), //秒
            "q": Math.floor((date.getMonth() + 3) / 3), //季度
            "S": date.getMilliseconds() //毫秒
        };
        format = format.replace(/([yMdhmsqS])+/g, function(all, t){
            var v = map[t];
            if(v !== undefined){
                if(all.length > 1){
                    v = '0' + v;
                    v = v.substr(v.length-2);
                }
                return v;
            }
            else if(t === 'y'){
                return (date.getFullYear() + '').substr(4 - all.length);
            }
            return all;
        });
        return format;
    },
    //字符串截取
    str_limit(value, limit, end, order){
        limit = limit || 100;
        end = typeof end == 'undefined' ? '...' : end;
        order = typeof order == 'undefined' ? 0 : 1;
        var _str = value ? String(value) : '';
        if (_str.length > limit) {
            if(order){
                return end+_str.substring(_str.length-limit, _str.length);
            }else {
                return _str.substring(0, limit) + end;
            }
        }
        return _str;
    },

}
