<template>
    <div class="open_index">
        {{$tp('Home page of official website')}}
        <router-link to="/admin">{{$tp('Backstage home page')}}</router-link>
        <router-link to="/home">{{$tp('Front desk home page')}}</router-link>
        <h3 style="color: red">{{$tp('Please do not register users in this demo environment, The registration and login of this demo environment are only used for demo use')}}</h3>
        <h1>
            <a href="https://www.laraveladmin.cn">{{$tp('Official environment official website')}}https://www.laraveladmin.cn</a>
        </h1>
    </div>
</template>

<script>
    export default {
        props: {
        },
        data(){
            return {
                "{lang_path}":'open.index',
            };
        }
    };
</script>
