<template>
    <div class="admin_index">
        后台主页
        <router-link to="/admin">后台</router-link>
        <router-link to="/">官网</router-link>
        {{user}}
        <h1>
            <a href="https://www.laraveladmin.cn">正式环境官网:https://www.laraveladmin.cn</a>
        </h1>
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    export default {
        props: {
        },
        computed:{
            ...mapState('user',{
                user:state => state.user,
                loadingUser:state => state.loading
            }),
        }
    };
</script>
