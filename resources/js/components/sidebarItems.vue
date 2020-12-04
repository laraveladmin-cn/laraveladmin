<template>
    <li class="treeview">
        <router-link :to="menu['url']" v-if="menu['url']">
            <i class="fa" :class="menu['icons']"></i>
            <span>{{menu['name']}}</span>
            <span class="pull-right-container" v-if="menu['childrens']">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </router-link>
        <a v-else>
            <i class="fa" :class="menu['icons']"></i>
            <span>{{menu['name']}}</span>
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
            return {};
        },
        methods: {
        },
    }
</script>
