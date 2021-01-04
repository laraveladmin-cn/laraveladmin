<template>
    <div class="open_layout h100" v-cloak>
        <message></message>
        <modal></modal>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">菜单切换</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand hidden-sm" href="#" >
                        <img :src="app_url+logo" alt="LOGO" class="img-circle logo">
                        {{name}}
                    </a>
                </div>
                <div class="navbar-collapse collapse" role="navigation">
                    <ul class="nav navbar-nav">
                        <li :class="{active:menu.active}" v-for="(menu,index) in tree_menus" v-if="loginMenus(menu)">
                            <router-link :to="menu.url" v-if="menu.url.indexOf('http')!=0">{{menu.name}}</router-link>
                            <a :href="menu.url" target="_blank" v-else>{{menu.name}}</a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right hidden-sm" v-if="user && user.id">
                        <user-menu></user-menu>
                    </ul>
                    <ul class="nav navbar-nav navbar-right hidden-sm" v-else>
                        <li :class="{active:menu.active}" v-for="(menu,index) in tree_menus" v-if="!loginMenus(menu)">
                            <router-link :to="menu.url" v-if="menu.url.indexOf('http')!=0">{{menu.name}}</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <transition name="fade" enter-active-class="animated lightSpeedIn faster" mode="out-in"  leave-active-class="animated lightSpeedOut faster">
            <router-view class="open-content"></router-view>
        </transition>
        <footer>
            <div class="container">
                <p class="pull-right"><a href="#">返回顶部</a></p>
                <p style="margin: 0px 0px">
                    &copy; 版权所有 &middot; <a>{{name}}</a>
                    <span class="wangjing">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    备案号:<a href="http://beian.miit.gov.cn" target="_blank">{{icp}}</a>
                </p>
            </div>
        </footer>
        <a id="scrollUp" href="#top" style="position: fixed; z-index: 2147483647;">
            <i class="fa fa-angle-up"></i>
        </a>
    </div>
</template>

<script>
    import { mapState, mapActions, mapMutations, mapGetters } from 'vuex';
    import Message from 'admin_components/message.vue';
    import Modal from 'admin_components/modal.vue';
    import userMenu from 'pages_components/userMenu.vue';
    export default {
        components:{
            "message":Message,
            "modal":Modal,
            "user-menu":userMenu
        },
        props: {
        },
        methods:{
            ...mapActions({
                getMenus:'menu/getMenus', //获取菜单数据
                getUser:'user/getUser', //获取用户数据
                logout:'user/logout' //退出登录
            }),
            ...mapMutations({
                menuSet:'menu/set',  //设置当前路由,用于菜单选中
            }),
            loginMenus(menu){
                return [66,63].indexOf(menu.id)==-1;
            }
        },
        watch: {
            '$route' (to, from) {
                this.menuSet({
                    key:'path',
                    path:to.path
                });
            }
        },
        computed:{
            ...mapState([
                'icp',
                'logo',
                'app_url',
                'name'
            ]),
            ...mapState('user',{
                user:state => state.user
            }),
            route(){
                return this.$route.path;
            },
            ...mapGetters('menu',[
                'modules',
                'navbars',
                'current_menu',
                'tree_menus',
                'no_permission',
                'module_route'
            ]),

        },
        created() {
            //动态加载js文件
            if(!document.getElementById('bootstrap-js')){
                let editormdJs = document.createElement('script');
                editormdJs.id = 'bootstrap-js';
                editormdJs.type = 'text/javascript';
                editormdJs.src = 'https://cdn.bootcss.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js';
                document.body.appendChild(editormdJs);
            }
            this.menuSet({
                key:'path',
                path:this.$router.currentRoute.path
            });
            this.getUser();
            this.getMenus();
        },
        mounted() {
            setTimeout(()=>{
                document.body.scrollTop = document.documentElement.scrollTop = 0;
            },500);
        },
    };
</script>
<style scoped>
    .logo{
        height: 30px;
        display: inline-block;
        font-size: 20px;
        border-radius:unset;
    }
    footer{
        position: fixed;
        left: 0;
        bottom: 0px;
        right: 0;
        margin: auto;
        background: #101010;
        padding-top: 10px;
        color: white;
    }
    .open-content{
        margin-bottom: 30px;
    }
    body{
        padding-top: 0px;
    }
    @media (min-width: 768px) {
        .navbar-brand{
            margin-top: 5px;
        }
    }

</style>
