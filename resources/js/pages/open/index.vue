<template>
    <div class="open_index">
        {{$tp('Home page of official website')}}
        <router-link to="/admin">{{$tp('Backstage home page')}}</router-link>
        <router-link to="/home">{{$tp('Front desk home page')}}</router-link>
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
