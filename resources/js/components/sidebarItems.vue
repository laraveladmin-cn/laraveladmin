<template>
    <li class="treeview">
        <a @click="toUrl(menu['url'],$event)" :href="menu['url']?menu['url']:null">
            <i class="fa" :class="menu['icons']"></i>
            <span>{{$tp(menu['name'])}}</span>
            <span class="pull-right-container" v-if="menu['childrens']">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu" v-show="menu['childrens'] && open" >
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
<style scoped>
    .treeview a{
        cursor:pointer;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:nowrap;
    }
</style>
