let getCookie = function (cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i].trim();
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
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
            code: function (code, lang) {
                lang = lang ? lang.replace(' script', '') : lang;
                return this.origin.code.apply(this, arguments);
            }
        }
    },
    copyCode: {
        buttonText: '复制',
        errorText: '错误',
        successText: '复制成功'
    },
    pagination: {
        previousText: '上一页',
        nextText: '下一页',
        crossChapter: true,
        crossChapterText: true,
    },
    count: {
        countable: true,
        fontsize: '0.9em',
        color: 'rgb(90,90,90)',
        language: 'chinese'
    },
    loadSidebar: true,
    alias: {
        '/.*/_sidebar.md': '/_sidebar.md'
    },
    logo: '/dist/img/logo.png',
    themeColor: '#3c8dbc',
    //disqus: 'shortname'

};
const giteement = new Giteement({
    id: 'demo page', // optional
    owner: 'laravel-admin',
    repo: 'laraveladmin',
    backcall_uri: 'https://www.laraveladmin.cn/home/index',
    oauth_uri: 'https://cors-anywhere.herokuapp.com/https://www.laraveladmin.cn/home/index',
    oauth: {
        client_id: '7173c415bd9e1d9f6d5660c1646da0aad295fd4266c34bf5c4ca9353298426ff',
        client_secret: 'c7bb795b6a6446f540f37126fc2eab14b960d8cef2cd9055362c38f1fa323fc9'
    },
});
giteement.render('comments');

