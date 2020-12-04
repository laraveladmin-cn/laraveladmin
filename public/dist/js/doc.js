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
    repo: 'https://gitee.com/zsping1989/laraveladmin',
    basePath: '/api/home/docs/',
    requestHeaders: {
        'Authorization': decodeURIComponent(token)
    },
    markdown: {
        renderer: {
            code: function(code, lang) {
                lang = lang.replace(' script','');
                if(lang=='shell'){
                    lang = 'bash'
                }
                return this.origin.code.apply(this, arguments);
            }
        }
    }
};

