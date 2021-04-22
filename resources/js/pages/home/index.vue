<template>
    <div class="admin_index">
        {{$tp('Front desk home page')}}
        <br>
        <router-link to="/admin">{{$tp('Backstage home page')}}</router-link>
        <br>
        <router-link to="/">{{$tp('Home page of official website')}}</router-link>
        <br>
        {{user}}

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
        },
        data(){
            return {
                "{lang_path}":'home.index',
            };
        }
    };
</script>
