<template>
    <div class="home_layout h100 hold-transition skin-blue layout-top-nav" v-cloak>
        <message></message>
        <modal></modal>
        <div class="wrapper">
            <header class="main-header">
                <nav class="navbar navbar-static-top">
                    <div class="container">
                        <div class="navbar-header">
                            <router-link to="/open/index" class="navbar-brand">
                                <img :src="app_url+logo" alt="LOGO" class="img-circle logo">
                                <span class="hidden-xs">
                                   {{name}}
                                </span>
                            </router-link>
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target="#navbar-collapse">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>
                        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li :class="{active:menu.active}" v-for="(menu,index) in tree_menus">
                                    <router-link :to="menu.url" v-if="menu.url.indexOf('http')!=0" class="dropdown-toggle" data-toggle="dropdown">
                                        {{$tp(menu.name,menu_lang)}}
                                        <span class="caret" v-if="menu.childrens && menu.childrens.length"></span>
                                    </router-link>
                                    <a :href="menu.url" target="_blank" v-else>
                                        {{$tp(menu.name,menu_lang)}}
                                    </a>
                                    <ul class="dropdown-menu" role="menu" v-if="menu.childrens">
                                        <li v-for="(child,index) in menu.childrens">
                                            <router-link :to="child.url" v-if="child.url.indexOf('http')!=0">
                                                {{$tp(child.name,menu_lang)}}
                                            </router-link>
                                            <a :href="child.url" target="_blank" v-else>
                                                {{$tp(child.name,menu_lang)}}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav" v-if="user && user.id">
                                <li class="dropdown messages-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-envelope-o"></i>
                                    </a>
                                    <ul class="dropdown-menu">

                                    </ul>
                                </li>
                                <li class="dropdown notifications-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-bell-o"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                    </ul>
                                </li>
                                <li class="dropdown tasks-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-flag-o"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                    </ul>
                                </li>
                                <user-menu></user-menu>
                                <li v-if="locales.length>1" class="language">
                                    <a @click="openLanguage">
                                        <language ref="language" :value="language" @change="setLanguage"></language>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right hidden-sm" v-else>
                                <li>
                                    <router-link to="/open/login">{{$t('Login')}}</router-link>
                                </li>
                                <li>
                                    <router-link to="/open/register">{{$t('Register')}}</router-link>
                                </li>
                                <li v-if="locales.length>1" class="language">
                                    <a @click="openLanguage">
                                        <language ref="language" :value="language" @change="setLanguage"></language>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <div class="content-wrapper">
              <!--  <div class="container">-->
                <div>
                    <section class="content-header">
                        <h1>
                            {{$tp(current_menu['name'],menu_lang)}}
                            <small>{{$tp(current_menu['description'],menu_lang)}}</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li :class="{active:navbar.active}" v-for="navbar in navbars">
                                <router-link :to="navbar['url']" v-if="!navbar.active && navbar['url']">
                                    <i class="fa" :class="navbar['id']==current_menu['id'] ? navbar['icons']+' active':navbar['icons']"></i>
                                    {{$tp(navbar['name'],menu_lang)}}
                                </router-link>
                                <span v-else>
                                 <i class="fa" :class="navbar['id']==current_menu['id'] ? navbar['icons']+' active':navbar['icons']"></i>
                                {{$tp(navbar['name'],menu_lang)}}
                            </span>
                            </li>
                        </ol>
                    </section>
                    <section class="content">
                        <transition name="fade"
                                    enter-active-class="animated lightSpeedIn faster" mode="out-in"
                                    leave-active-class="animated lightSpeedOut faster">
                            <router-view></router-view>
                        </transition>
                    </section>
                </div>
            </div>
            <footer class="main-footer">
                <div class="container">
                    <div class="pull-right hidden-xs">
                        <b>{{$t('System version:')}}</b> {{version}}
                    </div>
                    <strong>
                        {{$t('Copyright')}}
                        <a target="_blank" href="http://www.laraveladmin.cn">{{name}}</a>
                    </strong>
                    <span class="wangjing"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
                    {{$t('The record number:')}}<a href="http://beian.miit.gov.cn" target="_blank">{{icp}}</a>
                </div>
            </footer>
        </div>
    </div>
</template>

<script>
    require('public/dist/js/adminlte.js');
    import {mapState, mapActions, mapMutations, mapGetters} from 'vuex';
    import userMenu from 'pages_components/userMenu.vue';
    import Message from 'admin_components/message.vue';
    import Modal from 'admin_components/modal.vue';
    export default {
        components:{
            "message":Message,
            "modal":Modal,
            "user-menu":userMenu,
            "language":()=>import(/* webpackChunkName: "common_components/language/language.vue" */ 'common_components/language/language.vue'),
        },
        props: {},
        computed: {
            ...mapState([
                'icp',
                'logo',
                'app_url',
                'name',
                'version',
                'name_short',
                'language',
                'locales'
            ]),
            ...mapState('user', {
                user: state => state.user
            }),
            ...mapGetters('menu',[
                'modules',
                'navbars',
                'current_menu',
                'tree_menus',
                'no_permission',
                'module_route'
            ]),
        },
        methods: {
            ...mapActions({
                getMenus: 'menu/getMenus', //获取菜单数据
                getUser: 'user/getUser', //获取用户数据
                logout: 'user/logout' //退出登录
            }),
            ...mapMutations({
                menuSet: 'menu/set',  //设置当前路由,用于菜单选中
                setLanguage:'setLanguage',
            }),
            openLanguage(){
                this.$refs['language'].open();
            },
        },
        watch: {
            '$route'(to, from) {
                this.menuSet({
                    key: 'path',
                    path: to.path
                });
            }
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
                key: 'path',
                path: this.$router.currentRoute.path
            });
            this.getUser();
            this.getMenus();
        },
        data(){
            return {
                "{lang_path}":'home.layout',
                menu_lang:{
                    "{lang_path}":'_shared.menus',
                    "{lang_root}":''
                }
            };
        }
    };
</script>
<style scoped>
    .navbar-brand{
        padding: 5px 15px;
    }
    .logo{
        background-color:unset;
        width: unset;
        border-radius:unset;
        height: 45px;
        display: inline-block;
        padding: 0 10px;
    }
    .skin-blue .main-header .logo {
        background-color:unset;
    }
</style>
