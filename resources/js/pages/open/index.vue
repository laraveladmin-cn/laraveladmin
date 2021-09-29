<template>
    <div class="open_index">
        <div class="flex-center position-ref full-height">
            <div class="top-left links">
                <router-link to="/admin">{{$tp('Backstage home page')}}</router-link>
                <router-link to="/home">{{$tp('Front desk home page')}}</router-link>
            </div>
            <div class="content">
                <div class="title m-b-md">
                    {{name}}
                </div>
                <div class="links">
                    <a href="https://www.laraveladmin.cn/home/index">{{$tp('Document')}}</a>
                    <a href="https://www.laraveladmin.cn">{{$tp('Website')}}</a>
                    <a href="https://www.laraveladmin.cn/ate.zip">{{$tp('Template download')}}</a>
                    <a href="https://gitee.com/laravel-admin/laraveladmin">{{$tp('Gitee')}}</a>
                    <a href="https://github.com/laraveladmin-cn/laraveladmin">Github</a>
                    <a href="https://laravelacademy.org/">{{$tp('Laravel documentation')}}</a>
                </div>
                <h3 class="red">
                    {{$tp('Please do not register users in this demo environment, The registration and login of this demo environment are only used for demo use')}}
                </h3>
                <h1>
                    <a href="https://www.laraveladmin.cn">
                        {{$tp('Official environment official website')}}https://www.laraveladmin.cn
                    </a>
                </h1>
                <div>
                    {{$tp('Home page of official website')}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState} from 'vuex';
    export default {
        props: {
        },
        data(){
            return {
                "{lang_path}":'open.index',
            };
        },
        computed:{
            ...mapState([
                'name'
            ]),
        }
    };
</script>
<style scoped>
    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-left {
        position: absolute;
        left: 10px;
        top: 10px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 84px;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        margin-bottom: 30px;
    }
    .red{
        color: red;
    }
</style>
