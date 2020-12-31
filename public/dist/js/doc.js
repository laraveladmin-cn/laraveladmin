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
    plugins:[
        function(hook, vm) {
            hook.init(function() {
                // 初始化完成后调用，只调用一次，没有参数。
            });

            hook.beforeEach(function(content) {
                // 每次开始解析 Markdown 内容时调用
                return content;
            });

            hook.afterEach(function(html, next) {
                // 解析成 html 后调用。
                // beforeEach 和 afterEach 支持处理异步逻辑
                // ...
                // 异步处理完成后调用 next(html) 返回结果
                html = html+'<div id="comments">评论加载中...</div>';
                next(html);
            });

            hook.doneEach(function() {
                // 每次路由切换时数据全部加载完成后调用，没有参数。
       /*         const giteement = new Giteement({
                    id: 'demo page', // optional
                    owner: 'laravel-admin',
                    repo: 'laraveladmin',
                    backcall_uri: 'https://www.laraveladmin.cn/home/index',
                    oauth_uri: 'https://cors-anywhere.herokuapp.com/https://www.laraveladmin.cn/home/index',
                    oauth: {
                        client_id: '7173c415bd9e1d9f6d5660c1646da0aad295fd4266c34bf5c4ca9353298426ff',
                        client_secret: 'c7bb795b6a6446f540f37126fc2eab14b960d8cef2cd9055362c38f1fa323fc9'
                    },https://github.com/laraveladmin-cn/laraveladmin.git
                    enable:true
                });
                giteement.render('comments');*/
               try {
                   const gitalk = new Gitalk({
                       clientID: 'cc773b758ba981ee03c5',
                       clientSecret: '1408f07f17667d34bd78947cdd597b2ae9cd62f5',
                       repo: 'laraveladmin',
                       owner: 'laraveladmin-cn',
                       admin: ['laraveladmin-cn'],
                       // facebook-like distraction free mode
                       distractionFreeMode: true,
                       id: location.hash.replace('#','')
                   });
                       gitalk.render('comments');
               }catch (e) {
                   console.log(e);
               }

            });

            hook.mounted(function() {
                // 初始化并第一次加载完成数据后调用，只触发一次，没有参数。
            });

            hook.ready(function() {
                // 初始化并第一次加载完成数据后调用，没有参数。
            });
        }
    ]
};
if(self == top){
    setTimeout(()=>{
        window.location.href = '/home/index';
    },800);
}
