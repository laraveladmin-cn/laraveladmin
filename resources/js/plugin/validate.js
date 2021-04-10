//自定义验证
import {configure,extend,localize,validate} from 'vee-validate'; //表单验证
import * as rules from 'vee-validate/dist/rules'; //验证规则
import zh_CN from './vee-validate/zh_CN'; //验证语言包


Object.keys(rules).forEach(rule => {
    extend(rule, {
        ...rules[rule]
    });
});
const regexs = {
    mobile:/^1[3-9][0-9]{9}$/,
    name:/^[\u4e00-\u9fa5]+[\.、·\u4e00-\u9fa5}]{0,}[\u4e00}-\u9fa5]+$|^[A-Za-z]+[ A-Za-z]{1,}[A-Za-z]+$/,
    mobile_code:/\d{6}$/,
    id_card:/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/,
    fix_phone:/^0(10|21|22|23|[1-9]{1}[0-9]{1})[\-]{0,1}[0-9]{7,8}$/,
    addr:/^[\u4e00-\u9fa5]{2,}[\u4e00-\u9fa5\-0-9a-zA-Z]{2,}$/,
    english_addr:/^[A-Za-z]{2,}[A-Za-z0-9\- ,\.]{2,}$/,
    ip:/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/,
    ipv4:/^((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$/,
    ipv6:/^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*$/,

};
collect(regexs).each((item,key) => {
    extend(key, {
        validate:value => {
            return item.test(value);
    }});
});
let required = {
    validate:(value,{ type }) => {
        let value_type = typeof value;
        if((type=='number' || type=='zero') && value_type=="string"){ //强转为数字
            value = value-0;
        }
        if(Array.isArray(value)){ //数组判断
            return value.length>0;
        }else if(value_type=='object'){ //对象判断
            let json_str = JSON.stringify(value);
            return json_str != "{}" && json_str !='null';
        }else if(value_type=='number' && type!='zero' && !value){
            return value===0;
        }
        return !!value;
    },
    params: ['type'],
    computesRequired: true
};
extend('required', required);
let url = {
    validate:(value) => {
        if(!value+''){
            return true;
        }
        let strRegex = '^((https|http|ftp|rtsp|mms)?://)'
            + '?(([0-9a-z_!~*\'().&=+$%-]+: )?[0-9a-z_!~*\'().&=+$%-]+@)?' //ftp的user@
            + '(([0-9]{1,3}.){3}[0-9]{1,3}' // IP形式的URL- 199.194.52.184
            + '|' // 允许IP和DOMAIN（域名）
            + '([0-9a-z_!~*\'()-]+.)*' // 域名- www.
            + '([0-9a-z][0-9a-z-]{0,61})?[0-9a-z].' // 二级域名
            + '[a-z]{2,6})' // first level domain- .com or .museum
            + '(:[0-9]{1,4})?' // 端口- :80
            + '((/?)|' // a slash isn't required if there is no file name
            + '(/[0-9a-z_!~*\'().;?:@&=+$,%#-]+)+/?)$';
        let re=new RegExp(strRegex);
        let RegUrl = new RegExp();
        RegUrl.compile("^[A-Za-z0-9-_]+\\.[A-Za-z0-9-_%&\?\/.=]+$");
        if (re.test(value) || RegUrl.test(value)) {
            return true;
        } else {
            return false;
        }
    },
    params: [],
    computesRequired: false
};
extend('url', url);
extend('in', rules.oneOf);
let array =  {
    validate:(value) => {
        let type = Object.prototype.toString.call(value);
        return type=='[object Array]' || type=='[Object Object]';
    },
    params: [],
    computesRequired: false
};
extend('array', array);
//数字之间
extend('digits_between', {
    validate:(value,{ min ,max}) => {
        if(value!==0 && !value){
            return true;
        }
        let length = (value+'').length;
        return length>=min && length<=max && (value-0)==value;
    },
    params: ['min','max'],
    computesRequired: true
});
extend('alpha_numeric', rules.alpha_num);
//同意
let accepted =  {
    validate:(value) => {
        return ['yes',1,'1','no'].indexOf(value)!=-1 || value===true;
    },
    params: [],
    computesRequired: false
};
extend('accepted', accepted);
extend('boolean', {
    validate:(value) => {
        return (typeof value)=='boolean';
    },
    params: [],
    computesRequired: false
});
configure({
    locale: 'zh_CN'
});
localize('zh_CN', zh_CN);
