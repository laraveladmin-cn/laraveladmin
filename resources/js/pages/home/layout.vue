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
                                    <a @click="toUrl(menu.url,$event,menu['is_out_link'])"
                                       :href="menu.url?menu.url:null"
                                       class="dropdown-toggle"
                                       data-toggle="dropdown"
                                    >
                                        {{$tp(menu.name,menu_lang)}}
                                        <span class="caret" v-if="menu.childrens && menu.childrens.length"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu" v-if="menu.childrens">
                                        <li v-for="(child,index) in menu.childrens">
                                            <a :href="child.url"
                                               @click="toUrl(child.url,$event,child['is_out_link'])"
                                            >
                                                {{$tp(child.name,menu_lang)}}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav" v-if="user && user.id">
                                <!--  <li class="dropdown messages-menu">
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
                                  </li>-->
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
                    <section class="content-header" :class="{'my-content-header':downloading}">
                        <h1>
                            {{current_menu_name}}
                            <small>
                                {{current_menu_description}}
                            </small>
                        </h1>
                        <ol class="breadcrumb">
                            <li :class="{active:navbar.active}" v-for="navbar in navbars">
                                <router-link :to="navbar['url']" v-if="!navbar.active && navbar['url']">
                                    <i class="fa" :class="navbar['id']==current_menu['id'] ? navbar['icons']+' active':navbar['icons']"></i>
                                    {{translation(navbar,'name')}}
                                </router-link>
                                <span v-else>
                                 <i class="fa" :class="navbar['id']==current_menu['id'] ? navbar['icons']+' active':navbar['icons']"></i>
                                    {{last_menu_show_name ? last_menu_show_name:translation(navbar,'name')}}
                            </span>
                            </li>
                        </ol>
                    </section>
                    <section class="content">
                        <transition name="fade"
                                    enter-active-class="animated fadeIn faster" mode="out-in"
                                    leave-active-class="animated fadeOut faster">
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
    require('public_path/dist/js/adminlte.js');
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
            ...mapState('menu',{
                menus:state => state.menus,
                loadingMenu:state => state.loading,
                last_menu_show:state => state.last_menu_show
            }),
            ...mapState('excel',{
                downloading:state => state.downloading,
                download_progress:state => state.download_progress,
                download_pauseing:state => state.pauseing,
            }),
            last_menu_show_name(){
                if(this.last_menu_show && this.last_menu_show.name){
                    return this.translation(this.last_menu_show,'name');
                }
                return '';
            },
            current_menu_name(){
                return this.last_menu_show_name || this.translation(this.current_menu,'name');
            },
            current_menu_description(){
                if(this.last_menu_show && this.last_menu_show.description ){
                    return this.last_menu_show.description
                }
                return this.translation(this.current_menu,'description');
            }
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
            translation(item,key){
                let value = array_get(item,key,'');
                let resource_id = item['resource_id'];
                let res = this.$tp(value , this.shared);
                if(resource_id && res==value && (this._i18n.locale!='en' || value.indexOf('{')!=-1)){ //没有翻译成功
                    let parent_name = array_get(item,'parent.item_name','') || array_get(item,'parent.name','') || '';
                    let key = value.replace(parent_name,'{name}');
                    let shared = copyObj(this.shared);
                    if(key.indexOf('{name}')==0){
                        shared.name=this.$tp(parent_name,shared);
                    }else {
                        key = value.replace(parent_name.toLowerCase(),'{name}');
                        shared.l_name=this.$tp(parent_name,shared);
                        key = key.replace('{name}','{l_name}');
                    }
                    res = this.$tp(key , shared);
                }
                return res;
            },
        },
        watch: {
            '$route'(to, from) {
                dd(to);
                this.menuSet({
                    key:'path',
                    path:to.matched[1].path.replace(':id','{id}')
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
                key:'path',
                path:this.$router.currentRoute.matched[1].path.replace(':id','{id}')
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
                },
                shared:{
                    '{lang_path}':'_shared.menus',
                    '{lang_root}':''
                },
            };
        }
    };
</script>
<style scoped>
    .navbar-brand{
        padding: 5px 15px;
        line-height: 42px;
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
