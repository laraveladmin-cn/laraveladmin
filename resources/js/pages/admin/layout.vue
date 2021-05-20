<template>

    <div class="main_body admin_layout sidebar-mini h100" :class="dark?'skin-dark':skin" v-if="loaded || !loading" v-cloak>
        <message></message>
        <modal></modal>
        <div class="wrapper">
            <header class="main-header">
                <router-link to="/admin/index" class="logo">
                    <span class="logo-mini" style="display: inline-block">
                        <img :src="logo" width="40px" height="40px">
                    </span>
                    <span class="logo-lg" style="display: inline-block"><b>{{name_short}}</b>{{$tp('Backend systems')}}</span>
                </router-link>
                <nav class="navbar navbar-static-top">
                    <a class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">{{$tp('Toggle navigation')}}</span>
                    </a>
                    <div class="navbar-custom-menu pull-left">
                        <ul class="nav navbar-nav">
                            <li :class="{active:module['active']}" v-for="module in modules">
                                <a @click="toUrl(module['url'],$event)" :href="module['url']?module['url']:null">
                                    <i class="fa" :class="module['icons']"></i>
                                    {{$tp(module['name'],shared)}}
                                </a>
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
                                    <li class="header">{{$tp('You have {number} messages',1,{number:1})}}</li>
                                    <li>
                                        <ul class="menu">
                                            <li>
                                                <a>
                                                    <div class="pull-left">
                                                        <img src="/dist/img/user2-160x160.jpg" class="img-circle"
                                                             :alt="$tp('User avatars')">
                                                    </div>
                                                    <h4>
                                                        {{$t('System')}}
                                                        <small><i class="fa fa-clock-o"></i> {{$tp('{number} minutes ago',{number:5})}}</small>
                                                    </h4>
                                                    <p>{{$t('Hello')}}</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer"><a>{{$t('See them all')}}</a></li>
                                </ul>
                            </li>
                            <li class="dropdown notifications-menu">
                                <a class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">1</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">{{$tp('You have {number} reminders',{number:1})}}</li>
                                    <li>
                                        <ul class="menu">
                                            <li>
                                                <a>
                                                    <i class="fa fa-users text-aqua"></i> {{$tp('{number} users joined today',5,{number:5})}}
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer"><a>{{$t('See them all')}}</a></li>
                                </ul>
                            </li>
                            <li class="dropdown tasks-menu">
                                <a class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-flag-o"></i>
                                    <span class="label label-danger">1</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">{{$tp('You have {number} tasks',{number:1})}}</li>
                                    <li>
                                        <ul class="menu">
                                            <li>
                                                <a>
                                                    <h3>
                                                        {{$t('Percentage of tasks')}}
                                                        <small class="pull-right">20%</small>
                                                    </h3>
                                                    <div class="progress xs">
                                                        <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                             role="progressbar"
                                                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">{{$t('Progress')}} 20%</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a>{{$t('See them all')}}</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown user user-menu">
                                <a class="dropdown-toggle" data-toggle="dropdown">
                                    <img :src="user['avatar'] || '/dist/img/user_default_180.gif'" class="user-image" :alt="$t('User avatars')">
                                    <span class="hidden-xs">{{user['name']}}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <img :src="user['avatar'] || '/dist/img/user_default_180.gif'" class="img-circle" :alt="$t('User avatars')">

                                        <p>
                                            {{user['name']}} - {{$tp(roleName,shared_roule)}}
                                            <small>{{$tp('Date of entry : {date}',{date:'2019-08-01'})}}</small>
                                        </p>
                                    </li>
                                    <li class="user-body">
                                        <div class="row">
                                            <div class="col-xs-4 text-center">
                                                <a>{{$tc('Section',0)}}</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a>{{$tc('Section',1)}}</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a>{{$tc('Section',2)}}</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a class="btn btn-default btn-flat">{{$tp('Personal center')}}</a>
                                        </div>
                                        <div class="pull-right">
                                            <a class="btn btn-default btn-flat" @click="logout">{{$t('Logout')}}</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li v-if="locales.length>1">
                                <a @click="openLanguage">
                                    <language ref="language" :value="language" @change="setLanguage"></language>
                                </a>
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
                                <img :src="user['avatar'] || '/dist/img/user_default_180.gif'" class="img-circle" :alt="$t('User avatars')">
                            </div>
                            <div class="pull-left info">
                                <p>{{user['name']}}</p>
                                <a>{{$tp(roleName,shared_roule)}}</a>
                            </div>
                        </div>
                        <div class="sidebar-form">
                              <div class="input-group">
                                  <input @keydown.enter="search" @keyup="waitSearch" v-model="keywords" type="text" name="keywords" class="form-control" :placeholder="$tp('Search menu')">
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
                                    <span v-show="download_progress>=100">{{$t('Has been completed')}}</span>
                                </div>
                            </div>
                            <div class="pull-right progress-tool" v-show="downloading && download_progress<100" style="margin-right: 10px">
                                <button v-show="!download_pauseing"  @click="downloadPause" type="button" :title="$t('Pause')"  class="btn btn-box-tool my-progress-cancel">
                                        <span class="text-primary">
                                              {{$t('Pause')}} <i class="fa fa-pause"></i>
                                        </span>
                                </button>
                                <button v-show="download_pauseing"  @click="downloadStart" type="button" :title="$t('Continue')"  class="btn btn-box-tool my-progress-cancel">
                                        <span class="text-primary">
                                              {{$t('Continue')}} <i class="fa fa-play"></i>
                                        </span>
                                </button>
                                <button @click="downloadCancel" type="button" :title="$t('Cancel')"  class="btn btn-box-tool my-progress-cancel">
                                         <span class="text-danger">
                                             {{$t('Cancel')}} <i class="fa fa-times"></i>
                                         </span>
                                </button>
                            </div>
                        </div>
                    </transition>
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
                        <transition name="fade" enter-active-class="animated lightSpeedIn faster" mode="out-in" leave-active-class="animated lightSpeedOut faster">
                            <router-view></router-view>
                        </transition>
                    </section>
                </div>
                <footer class="main-footer">
                    <div class="pull-right hidden-xs">
                        <b>{{$t('System version:')}}</b> {{version}}
                    </div>
                    <strong>{{$t('Copyright')}}
                        <a target="_blank" href="http://www.laraveladmin.cn">Laravel Admin</a>
                    </strong>
                    <span v-if="icp">
                         <span class="wangjing"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span> {{$t('The record number:')}}{{icp}}
                    </span>
                </footer>
            </div>
            <aside class="control-sidebar" ref="control_sidebar">
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                    <li class="active">
                        <a href="#control-sidebar-home-tab" data-toggle="tab">
                            <i class="fa fa-home"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#control-sidebar-settings-tab" data-toggle="tab">
                            <i class="fa fa-gears"></i>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- Home tab content -->
                    <div class="tab-pane active" id="control-sidebar-home-tab">
                        <h3 class="control-sidebar-heading">{{$tp('Recent Activities')}}</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">{{$tp('My birthday')}}</h4>
                                        <p>2019-01-01</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-user bg-yellow"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">{{$tp('Your birthday')}}</h4>

                                        <p>2019-01-01</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">{{$t('Email')}}</h4>

                                        <p>nora@example.com</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-file-code-o bg-green"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">{{$tc('Section',0)}}</h4>

                                        <p>Execution time 5 seconds</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <h3 class="control-sidebar-heading">{{$t('Progress')}}</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        {{$tc('Section',0)}}
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
                                        {{$tc('Section',1)}}
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
                                        {{$tc('Section',2)}}
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
                                        {{$tc('Section',4)}}
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
                        <h3 class="control-sidebar-heading">
                            {{$tp('Theme')}}
                            <span class="pull-right" @click="switchDark">
                                {{dark?$tp('Day'):$tp('Night')}}
                                <i class="fa" :class="dark?'fa-sun-o':'fa-moon-o'"></i>
                            </span>

                        </h3>

                        <ul class="list-unstyled clearfix">
                            <li class="skin-item" v-for="(item,index) in skins">
                                <a href="javascript:void(0)" class="clearfix full-opacity-hover" @click="setSkin(item.class)">
                                    <div>
                                        <span class="span1" :class="item.class1" :style="{background: item.background1}"></span>
                                        <span class="span2" :class="item.class2" :style="{background: item.background2}"></span>
                                    </div>
                                    <div>
                                        <span class="span3" :style="{background: item.background3}"></span>
                                        <span class="span4" :style="{background: item.background4}"></span>
                                    </div>
                                </a>
                                <p class="text-center no-margin">{{$tp(item.name)}}</p>
                            </li>
                        </ul>
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
            "modal":Modal,
            "language":()=>import(/* webpackChunkName: "common_components/language/language.vue" */ 'common_components/language/language.vue'),
        },
        props: {},
        data(){
            let dark = localStorage.getItem('dark')==1?1:0;
            return {
                shared:{
                    '{lang_path}':'_shared.menus',
                    '{lang_root}':''
                },
                "{lang_path}":'admin.layout',
                shared_roule:{
                    '{lang_path}':'_shared.datas.roles.name',
                    '{lang_root}':''
                },
                loading:true,
                keywords:'',
                timer:null,
                skin:localStorage.getItem('skin') || 'skin-blue',
                dark:dark,
                skins: [
                    {
                    "name": "Blue",
                    "class": "skin-blue",
                    "background1": "#367fa9",
                    "class2": "bg-light-blue",
                    "background3": "#222d32",
                    "background4": "#f4f5f7"
                }, {
                    "name": "White",
                    "class": "skin-black",
                    "background1": "#fefefe",
                    "background2": " #fefefe",
                    "background3": "#222",
                    "background4": "#f4f5f7"
                }, {
                    "name": "Purple",
                    "class": "skin-purple",
                    "class1": "bg-purple-active",
                    "class2": "bg-purple",
                    "background3": "#222d32",
                    "background4": "#f4f5f7"
                }, {
                    "name": "Green",
                    "class": "skin-green",
                    "class1": "bg-green-active",
                    "class2": "bg-green",
                    "background3": "#222d32",
                    "background4": "#f4f5f7"
                }, {
                    "name": "Red",
                    "class": "skin-red",
                    "class1": "bg-red-active",
                    "class2": "bg-red",
                    "background3": "#222d32",
                    "background4": "#f4f5f7"
                }, {
                    "name": "Yellow",
                    "class": "skin-yellow",
                    "class1": "bg-yellow-active",
                    "class2": "bg-yellow",
                    "background3": "#222d32",
                    "background4": "#f4f5f7"
                }, {
                    "name": "Blue Light",
                    "class": "skin-blue-light",
                    "background1": "#367fa9",
                    "class2": "bg-light-blue",
                    "background3": "#f9fafc",
                    "background4": "#f4f5f7"
                }, {
                    "name": "All White",
                    "class": "skin-black-light",
                    "background1": "#fefefe",
                    "background2": " #fefefe",
                    "background3": "#f9fafc",
                    "background4": "#f4f5f7"
                }, {
                    "name": "Purple Light",
                    "class": "skin-purple-light",
                    "class1": "bg-purple-active",
                    "class2": "bg-purple",
                    "background3": "#f9fafc",
                    "background4": "#f4f5f7"
                }, {
                    "name": "Green Light",
                    "class": "skin-green-light",
                    "class1": "bg-green-active",
                    "class2": "bg-green",
                    "background3": "#f9fafc",
                    "background4": "#f4f5f7"
                }, {
                    "name": "Red Light",
                    "class": "skin-red-light",
                    "class1": "bg-red-active",
                    "class2": "bg-red",
                    "background3": "#f9fafc",
                    "background4": "#f4f5f7"
                }, {
                    "name": "Yellow Light",
                    "class": "skin-yellow-light",
                    "class1": "bg-yellow-active",
                    "class2": "bg-yellow",
                    "background3": "#f9fafc",
                    "background4": "#f4f5f7"
                }]
            };
        },
        mounted(){

        },
        methods:{
            checkDark(){
                let $control_sidebar = $(this.$refs['control_sidebar']);
                let $body = $(document.body);
                if(this.dark){
                    $control_sidebar.addClass('control-sidebar-dark');
                    $control_sidebar.removeClass('control-sidebar-light');
                    $body.addClass('_dark');
                }else {
                    $control_sidebar.addClass('control-sidebar-light');
                    $control_sidebar.removeClass('control-sidebar-dark');
                    $body.removeClass('_dark');
                }
                localStorage.setItem('dark',this.dark);
            },
            switchDark(){
               this.dark = this.dark?0:1;
               this.checkDark();
            },
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
            //设置主题
            setSkin(value){
                this.skin = value;
                localStorage.setItem('skin',value);
            },
            load(){
                //重载触发事件绑定
                $(window).trigger('load');
                this.checkDark();
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
                setLanguage:'setLanguage',
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
                'alerts',
                'language',
                'locales'
            ]),
            ...mapState('menu',{
                menus:state => state.menus,
                loadingMenu:state => state.loading,
                last_menu_show:state => state.last_menu_show
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
            },
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
        },
        mounted(){
        }
    };
</script>
<style lang="scss" scoped>
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
    .skin-item{
        float:left;
        width: 33.33333%;
        padding: 5px;
        a{
            display: block;
            box-shadow: 0 0 3px rgba(0,0,0,0.4)
        }
        .span1{
            display:block; width: 20%; float: left; height: 7px;
        }
        .span2{
            display:block; width: 80%; float: left; height: 7px;
        }
        .span3{
            display:block; width: 20%; float: left; height: 20px;
        }
        .span4{
            display:block; width: 80%; float: left; height: 20px;
        }
    }
    .navbar-custom-menu a{
        cursor:pointer;
    }
    @media screen and (max-width: 768px) {
        .control-sidebar-bg, .control-sidebar {
            top: 50px
        }
    }

</style>
