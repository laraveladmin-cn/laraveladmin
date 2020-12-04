<template>
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
                    <small>加入日期:{{user['created_at']}}</small>
                </p>
            </li>
            <li class="user-footer">
                <div class="pull-left">
                    <router-link :to="'/'+module+'/personage/index'" class="btn btn-default btn-flat">
                        个人中心
                    </router-link>
                </div>
                <div class="pull-right">
                    <a class="btn btn-default btn-flat" @click="logout">退出</a>
                </div>
            </li>
        </ul>
    </li>
</template>

<script>
    import { mapState, mapActions, mapMutations, mapGetters } from 'vuex';
    export default {
        name: "userMenu",
        computed:{
            ...mapState('user',{
                user:state => state.user,
                loadingUser:state => state.loading
            }),
            ...mapGetters('user',[
                'isAdmin',
                'roleName'
            ]),
            module(){
                if(this.user.admin){
                    return 'admin';
                }
                return 'home';
            }
        },
        methods:{
            ...mapActions({
                logout: 'user/logout', //退出登录
            })
        }
    }
</script>

<style scoped>
    li.user-header {
        background-color: #3c8dbc;
    }
</style>
