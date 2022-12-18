<template>
    <li class="dropdown user user-menu">
        <a class="dropdown-toggle" data-toggle="dropdown">
            <img :src="user['avatar'] || '/dist/img/user_default_180.gif'" class="user-image" :alt="$t('User avatars')">
            <span class="hidden-xs">{{user['name']}}</span>
        </a>
        <ul class="dropdown-menu">
            <li class="user-header">
                <img :src="user['avatar'] || '/dist/img/user_default_180.gif'" class="img-circle" :alt="$t('User avatars')">
                <p>
                    {{user['name']}} - {{$tp(isAdmin?roleName:'Ordinary Member',shared_roule)}}
                    <small>{{$tp('Date of entry : {date}',{date:user['created_at']})}}</small>
                </p>
            </li>
            <li class="user-footer">
                <div class="pull-left">
                    <router-link :to="'/'+module+'/personage/index'" class="btn btn-default btn-flat">
                        {{$tp('Personal center')}}
                    </router-link>
                </div>
                <div class="pull-right">
                    <a class="btn btn-default btn-flat" @click="logout">{{$t('Logout')}}</a>
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
        },
        data(){
            return {
                "{lang_path}":'admin.layout',
                shared_roule:{
                    '{lang_path}':'_shared.datas.roles.name',
                    '{lang_root}':''
                },
            };
        }
    }
</script>

<style scoped>
    li.user-header {
        background-color: #3c8dbc;
    }
</style>
