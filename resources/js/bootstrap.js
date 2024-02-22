//对数据集合进行处理
window.collect = require('collect.js');
//加载jQuery
try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {}
//加载jQuery
try {
    window.JSEncrypt = require('jsencrypt').default;
} catch (e) {}
import { Base64 } from 'js-base64';
window.Base64 = Base64;
try {
    window.CryptoJS = require("crypto-js");
} catch (e) {}
//网络请求
window.axios = require('axios');
//velocity动画
window.Velocity = require('velocity-animate');
require("velocity-animate/velocity.ui.js");

