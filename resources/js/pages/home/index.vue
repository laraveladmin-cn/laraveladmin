<template>
    <div class="admin_index" v-show="user">
        {{$tp('Front desk home page')}}
        <br>
        <router-link to="/admin">{{$tp('Backstage home page')}}</router-link>
        <br>
        <router-link to="/">{{$tp('Home page of official website')}}</router-link>
        <br>
        <h3 class="red">{{$tp('Please do not register users in this demo environment, The registration and login of this demo environment are only used for demo use')}}</h3>
        <br>
        {{user}}
        <h1>
            <a href="https://www.laraveladmin.cn">{{$tp('Official environment official website')}}https://www.laraveladmin.cn</a>
        </h1>
    </div>
</template>

<script>
    export default {
        props: {
        },
        computed:{

        },
        data(){
            return {
                "{lang_path}":'home.index',
                user:null
            };
        },
        created() {
            this.getData();
        }
    };
</script>
<style scoped>
    .red{
        color: red
    }
</style>
