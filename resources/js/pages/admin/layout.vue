<template>
    <div class="main_body admin_layout skin-blue sidebar-mini h100" v-if="loaded || !loading" v-cloak>
        <message></message>
        <modal></modal>
        <div class="wrapper">
            <header class="main-header">
                <router-link to="/admin/index" class="logo">
                    <span class="logo-mini" style="display: inline-block">
                        <img :src="logo" width="40px" height="40px">
                    </span>
                    <span class="logo-lg" style="display: inline-block"><b>{{name_short}}</b>后台系统</span>
                </router-link>
                <nav class="navbar navbar-static-top">
                    <a class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">切换导航</span>
                    </a>
                    <div class="navbar-custom-menu pull-left">
                        <ul class="nav navbar-nav">
                            <li :class="{active:module['active']}" v-for="module in modules">
                                <router-link :to="module['url']">
                                    <i class="fa" :class="module['icons']"></i> {{module['name']}}
                                </router-link>
                            </li>
                        </ul>
                    </div>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown messages-menu">
                                <a class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="label label-success">1</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">你有1条消息</li>
                                    <li>
                                        <ul class="menu">
                                            <li>
                                                <a>
                                                    <div class="pull-left">
                                                        <img src="/dist/img/user2-160x160.jpg" class="img-circle"
                                                             alt="用户头像">
                                                    </div>
                                                    <h4>
                                                        系统
                                                        <small><i class="fa fa-clock-o"></i> 5分钟前</small>
                                                    </h4>
                                                    <p>你好!</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer"><a>查看全部</a></li>
                                </ul>
                            </li>
                            <li class="dropdown notifications-menu">
                                <a class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">1</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">你有1个提醒</li>
                                    <li>
                                        <ul class="menu">
                                            <li>
                                                <a>
                                                    <i class="fa fa-users text-aqua"></i> 今天有5个用户加入
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer"><a>查看全部</a></li>
                                </ul>
                            </li>
                            <li class="dropdown tasks-menu">
                                <a class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-flag-o"></i>
                                    <span class="label label-danger">1</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">你有1个任务</li>
                                    <li>
                                        <ul class="menu">
                                            <li>
                                                <a>
                                                    <h3>
                                                        任务百分比
                                                        <small class="pull-right">20%</small>
                                                    </h3>
                                                    <div class="progress xs">
                                                        <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                             role="progressbar"
                                                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">完成 20%</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a>查看全部</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown user user-menu">
                                <a class="dropdown-toggle" data-toggle="dropdown">
                                    <img :src="user['avatar'] || '/dist/img/user_default_180.gif'" class="user-image" alt="用户头像">
                                    <span class="hidden-xs">{{user['name']}}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <img :src="user['avatar'] || '/dist/img/user_default_180.gif'" class="img-circle" alt="用户头像">

                                        <p>
                                            {{user['name']}} - {{roleName}}
                                            <small>入职日期:2019-08-01</small>
                                        </p>
                                    </li>
                                    <li class="user-body">
                                        <div class="row">
                                            <div class="col-xs-4 text-center">
                                                <a>栏目一</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a>栏目二</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a>栏目三</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a class="btn btn-default btn-flat">个人中心</a>
                                        </div>
                                        <div class="pull-right">
                                            <a class="btn btn-default btn-flat" @click="logout">退出</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <div class="my-body">
                <aside class="main-sidebar">
                    <section class="sidebar">
                        <div class="user-panel">
                            <div class="pull-left image">
                                <img :src="user['avatar'] || '/dist/img/user_default_180.gif'" class="img-circle" alt="用户图片">
                            </div>
                            <div class="pull-left info">
                                <p>{{user['name']}}</p>
                                <a>{{roleName}}</a>
                            </div>
                        </div>
                        <div class="sidebar-form">
                              <div class="input-group">
                                  <input @keydown.enter="search" @keyup="waitSearch" v-model="keywords" type="text" name="keywords" class="form-control" placeholder="菜单搜索">
                                  <span class="input-group-btn">
                                  <button @click="search" type="button" class="btn btn-flat">
                                      <i class="fa fa-search"></i>
                                  </button>
                                </span>
                              </div>
                          </div>
                        <transition-group
                            name="staggered-fade"
                            tag="ul"
                            class="sidebar-menu"
                            data-widget="tree"
                            v-if="tree_menus"
                            v-on:before-enter="beforeEnter"
                            v-on:enter="enter"
                            v-on:leave="leave"
                            :data-height="44"
                        >
                            <li is="sidebar-items"
                                v-for="(menu,index) in tree_menus"
                                :class="{'active':menu['active'],'menu-open':menu['active']}"
                                :open="menu['active']"
                                :key="menu.id"
                                :data-index="index"
                                :menu="menu"
                                :current-menu="current_menu">
                            </li>
                        </transition-group>
                    </section>
                </aside>
                <div class="content-wrapper">
                    <transition
                        name="progress-tool"
                        tag="div"
                        v-on:before-enter="beforeEnter"
                        v-on:enter="enter"
                        v-on:leave="leave"
                        :data-index="1"
                        :data-height="20"
                    >
                        <div class="progress-tool"  v-if="downloading"  :data-index="1">
                            <div class="progress my-progress" :class="{active:(download_progress<100 && !download_pauseing)}" :style="{width:download_progress+'%'}">
                                <div class="progress-bar progress-bar-striped my-progress-bar" role="progressbar" :aria-valuenow="download_progress" :aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <span v-show="download_progress<100">{{download_progress}}%</span>
                                    <span v-show="download_progress>=100">完成!</span>
                                </div>
                            </div>
                            <div class="pull-right progress-tool" v-show="downloading && download_progress<100" style="margin-right: 10px">
                                <button v-show="!download_pauseing"  @click="downloadPause" type="button" title="取消"  class="btn btn-box-tool my-progress-cancel">
                                        <span class="text-primary">
                                              暂停 <i class="fa fa-pause"></i>
                                        </span>
                                </button>
                                <button v-show="download_pauseing"  @click="downloadStart" type="button" title="取消"  class="btn btn-box-tool my-progress-cancel">
                                        <span class="text-primary">
                                              继续 <i class="fa fa-play"></i>
                                        </span>
                                </button>
                                <button @click="downloadCancel" type="button" title="取消"  class="btn btn-box-tool my-progress-cancel">
                                         <span class="text-danger">
                                             取消 <i class="fa fa-times"></i>
                                         </span>
                                </button>
                            </div>
                        </div>
                    </transition>
                    <section class="content-header" :class="{'my-content-header':downloading}">
                        <h1>
                            {{current_menu['name']}}
                            <small>{{current_menu['description']}}</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li :class="{active:navbar.active}" v-for="navbar in navbars">
                                <router-link :to="navbar['url']" v-if="!navbar.active && navbar['url']">
                                    <i class="fa" :class="navbar['id']==current_menu['id'] ? navbar['icons']+' active':navbar['icons']"></i>
                                    {{navbar['name']}}
                                </router-link>
                                <span v-else>
                                 <i class="fa" :class="navbar['id']==current_menu['id'] ? navbar['icons']+' active':navbar['icons']"></i>
                                {{navbar['name']}}
                            </span>
                            </li>
                        </ol>
                    </section>
                    <section class="content">
                        <transition name="fade" enter-active-class="animated lightSpeedIn faster" mode="out-in" leave-active-class="animated lightSpeedOut faster">
                            <router-view></router-view>
                        </transition>
                    </section>
                </div>
                <footer class="main-footer">
                    <div class="pull-right hidden-xs">
                        <b>系统版本：</b> {{version}}
                    </div>
                    <strong>Copyright &copy; 2020
                        <a target="_blank" href="http://www.laraveladmin.cn">Laravel Admin</a>
                    </strong>
                    <span class="wangjing"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span> 备案号:{{icp}}
                </footer>
            </div>
            <aside class="control-sidebar control-sidebar-dark">
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                    <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a>
                    </li>
                    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
                </ul>
                <div class="tab-content">
                    <!-- Home tab content -->
                    <div class="tab-pane active" id="control-sidebar-home-tab">
                        <h3 class="control-sidebar-heading">最近活动</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">我的生日</h4>
                                        <p>2019-01-01</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-user bg-yellow"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">你的生日</h4>

                                        <p>2019-01-01</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">活动一</h4>

                                        <p>nora@example.com</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-file-code-o bg-green"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">活动二</h4>

                                        <p>Execution time 5 seconds</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <h3 class="control-sidebar-heading">任务进度</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        任务一
                                        <span class="label label-danger pull-right">70%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        任务二
                                        <span class="label label-success pull-right">95%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        任务三
                                        <span class="label label-warning pull-right">50%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        任务四
                                        <span class="label label-primary pull-right">68%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane" id="control-sidebar-settings-tab">
                        <form method="post">
                            <h3 class="control-sidebar-heading">其它设置</h3>

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    设置一
                                    <input type="checkbox" class="pull-right" checked>
                                </label>
                                <p>
                                    设置一说明
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </aside>
            <div class="control-sidebar-bg"></div>
        </div>
    </div>
</template>

<script>
    require('public/dist/js/adminlte.js');
    import SidebarItems from 'common_components/sidebarItems.vue';
    import Message from 'admin_components/message.vue';
    import Modal from 'admin_components/modal.vue';
    import { mapState, mapActions, mapMutations, mapGetters } from 'vuex';
    export default {
        components: {
            "sidebar-items": SidebarItems,
            "message":Message,
            "modal":Modal
        },
        props: {},
        data(){
            return {
                loading:true,
                keywords:'',
                timer:null
            };
        },
        mounted(){

        },
        methods:{
            load(){
                //重载触发事件绑定
                $(window).trigger('load');
            },
            ...mapActions({
                getMenus:'menu/getMenus', //获取菜单数据
                getUser:'user/getUser', //获取用户数据
                logout:'user/logout', //退出登录
                downloadPause:'excel/progressPause', //下载暂停
                downloadStart:'excel/progressStart', //下载继续
                downloadCancel:'excel/progressCancel', //下载取消
            }),
            ...mapMutations({
                menuSet:'menu/set',  //设置当前路由,用于菜单选中
            }),
            search(){
                this.menuSet({
                    key:'keywords',
                    keywords:this.keywords
                });
            },
            waitSearch(){
                this.timer = new Date().getTime();
                setTimeout(()=>{
                    if(new Date().getTime() - this.timer >= 200){
                        this.search();
                    }
                },210)
            },
            beforeEnter: function (el) {
                el.style.opacity = 0;
                el.style.height = 0;
            },
            enter: function (el, done) {
                let delay = el.dataset.index * 150;
                let height = el.dataset.height;
                setTimeout(function () {
                    Velocity(
                        el,
                        { opacity: 1, height: height+'px'},
                        { complete: ()=>{
                                el.style.height='auto';
                            } }
                    )
                }, delay);
            },
            leave: function (el, done) {
                let delay = el.dataset.index * 150;
                setTimeout(function () {
                    Velocity(
                        el,
                        { opacity: 0, height: 0 },
                        { complete: done }
                    )
                }, delay);
            },

        },
        computed:{
            ...mapState([
                '_token',
                'use_url',
                'logo',
                'name_short',
                'version',
                'icp',
                'alerts'
            ]),
            ...mapState('menu',{
                menus:state => state.menus,
                loadingMenu:state => state.loading,
            }),
            ...mapState('user',{
                user:state => state.user,
                loadingUser:state => state.loading
            }),
            ...mapState('excel',{
                downloading:state => state.downloading,
                download_progress:state => state.download_progress,
                download_pauseing:state => state.pauseing,
            }),
            ...mapGetters('user',[
                'isAdmin',
                'roleName'
            ]),
            ...mapGetters('menu',[
                'modules',
                'navbars',
                'current_menu',
                'tree_menus',
                'no_permission',
                'module_route'
            ]),
            //数据加载状态
            loaded(){
                let loading = this.loadingMenu || this.loadingUser;
                if(!loading){ //没有登录就跳转登录
                    if(!this.user['id']){
                        this.$router.replace({path: `/open/login`});
                        return false;
                    }else if(!this.isAdmin){
                        this.$router.replace({path: `/home/index`});
                        return false;
                    }else if(this.no_permission===1){
                        this.$router.replace({ path: this.module_route+'404'});
                    }else if(this.no_permission===2){
                        this.$router.replace({ path: this.module_route+'403'});
                    }
                }
                if(!loading){
                    this.loading = false;
                    setTimeout(()=>{this.load()},50)
                }
                return !loading;
            }
        },
        watch: {
            '$route' (to, from) {
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
            if(!document.getElementById('velocity-js')){
                let velocityJs = document.createElement('script');
                velocityJs.id = 'bootstrap-js';
                velocityJs.type = 'text/javascript';
                velocityJs.src = 'https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js';
                document.body.appendChild(velocityJs);
            }
            this.menuSet({
                key:'path',
                path:this.$router.currentRoute.matched[1].path.replace(':id','{id}')
            });
            this.getMenus();
            this.getUser();
        }
    };
</script>
<style lang="scss">
    .my-body{
        position: relative;
    }
    .my-progress{
        margin-bottom: 0px;
        background-color: unset;
        display: inline-block;
        min-width: 2em;
    }
    .my-progress-bar{
        min-width: 2em;
    }
    .my-progress-cancel{
        padding-top: 0px;
        padding-bottom: 0px;
    }
    .my-content-header{
        padding-top: 0px;
        margin-top: 18px;
    }
    .app .user-panel > .image > img{
        width: 45px;
        height: 45px;
    }
    .app .sidebar-collapse .user-panel > .image > img{
        width: 30px;
        height: 30px;
    }
    .progress-tool{
        height: 20px;
    }

</style>
