<template>
    <li class="treeview">
        <a @click="toUrl(menu['url'],$event)" :href="menu['url']?menu['url']:null" :class="{'no-childrens':!(menu['childrens'] && menu['childrens'].length)}">
            <i class="fa" :class="menu['icons']"></i>
            <span>{{$tp(menu['name'])}}</span>
            <span class="pull-right-container" v-if="menu['childrens']">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu" v-if="menu['childrens'] && menu['childrens'].length" v-show="open" >
            <li is="sidebar-items"
                v-for="children in menu['childrens']"
                :class="{active:children['active'],'menu-open':children['active']}"
                :key="children.id"
                :menu="children">
            </li>
        </ul>
    </li>
</template>

<script>
    export default {
        name:'sidebar-items',
        props: {
            menu: {
                type: Object,
                default: function () {
                    return {};
                }
            },
            currentMenu: {
                type: Object,
                default: function () {
                    return {};
                }
            },
            open:{
                type: Boolean,
                default: function () {
                    return false;
                }
            }
        },
        data(){
            return {
                "{lang_path}":'_shared.menus',
                "{lang_root}":'',
            };
        },
        methods: {
            goUrl(url,event){
                let oEvent=window.event || event;
                //获取ctrl 键对应的事件属性
                let bCtrlKeyCode = oEvent.ctrlKey || oEvent.metaKey;
                let is_external = url.indexOf('http://')==0 || url.indexOf('https://')==0;
                //新窗口打开
                if(!bCtrlKeyCode && !is_external && url){
                    $('.sidebar-open').removeClass('sidebar-open');
                }
                this.toUrl(url,event);
            }
        },
    }
</script>
<style>
    .sidebar-menu>li>a,.treeview>a{
        cursor:pointer;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:nowrap;
        padding-right: 25px;
    }
    @media (min-width: 768px){
        .sidebar-mini:not(.sidebar-mini-expand-feature).sidebar-collapse .sidebar-menu>li:hover>.treeview-menu,
        .sidebar-mini:not(.sidebar-mini-expand-feature).sidebar-collapse .sidebar-menu>li:hover>a>span:not(.pull-right) {
            overflow:hidden;
            text-overflow:ellipsis;
            white-space:nowrap;
            padding-right: 25px;
        }
        .sidebar-mini:not(.sidebar-mini-expand-feature).sidebar-collapse .sidebar-menu>li:hover>a>.pull-right-container {
            padding-right: 0px !important;
            padding-left: 0px;
            left: 200px!important;
        }
        .sidebar-mini.sidebar-collapse .sidebar-menu>li>a {
            overflow:unset;
        }
    }

</style>
