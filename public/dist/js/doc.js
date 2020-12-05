let getCookie = function (cname)
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
let token = getCookie('Authorization');
window.$docsify = {
    el: '#app',
    repo: 'https://gitee.com/laravel-admin/laraveladmin',
    basePath: '/api/home/docs/',
    auto2top: true,
    requestHeaders: {
        'Authorization': decodeURIComponent(token)
    },
    markdown: {
        renderer: {
            code: function(code, lang) {
                lang = lang.replace(' script','');
                return this.origin.code.apply(this, arguments);
            }
        }
    },
    copyCode: {
        buttonText : '复制',
        errorText  : '错误',
        successText: '复制成功'
    },
    pagination: {
        previousText: '上一页',
        nextText: '下一页',
        crossChapter: true,
        crossChapterText: true,
    },
    count:{
        countable:true,
        fontsize:'0.9em',
        color:'rgb(90,90,90)',
        language:'chinese'
    },
    loadSidebar: true,
    alias: {
        '/.*/_sidebar.md': '/_sidebar.md'
    },
    logo: '/dist/img/logo.png',


};

