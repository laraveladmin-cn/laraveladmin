<template>
    <div class="open_index">
        <div class="jumbotron masthead">
            <div class="container">
                <h1>{{name}}</h1>
                <h2>简洁、直观、强悍的前端后端开发框架，让全栈开发更迅速、简单。</h2>
                <p class="masthead-button-links">
       <!--             <router-link :to="user.id?'/home/index':'/open/login'" class="btn btn-lg btn-primary btn-shadow" role="button">-->
                    <router-link :to="'/home/index'" class="btn btn-lg btn-primary btn-shadow" role="button">
                        LaravelAdmin文档
                    </router-link>
                </p>
                <ul class="masthead-links">
                    <li>
                        <span class="text-red">
                              (请在www主站注册后再查看文档,不要在演示环境注册用户)
                        </span>
                    </li>
                    <li>
                        <a href="/ate.zip" target="_blank" role="button">后台模板下载</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container projects">
            <div class="projects-header page-header">
                <h2>LaravelAdmin涵盖基本功能</h2>
                <p>这些基础功能可以方便快速让实现我们的业务</p>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-3" v-for="(feature,index) in features">
                    <div class="thumbnail thumbnail1" :style="'background-color:'+feature.color+';'">
                        <div class="caption">
                            <h3>
                                <i class="fa" :class="feature.icon" v-if="feature.icon"></i> {{feature.name}}
                            </h3>
                            <p>{{feature.description}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="projects-header page-header">
                <h2>涉及相关技术栈</h2>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-3" v-for="(technology,index) in technologys">
                    <div class="thumbnail">
                        <a>
                            <img class="lazy" :src="technology.logo" width="300" height="150" :alt="technology.name">
                        </a>
                        <div class="caption">
                            <h3>
                                <a :href="technology.url" :title="technology.name" target="_blank">
                                    {{technology.name}}
                                </a>
                            </h3>
                            <p>{{technology.description}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState, mapActions, mapMutations, mapGetters } from 'vuex';
    export default {
        props: {
        },
        data(){
          return {
              features:[],
              technologys:[]
          }
        },
        computed:{
            ...mapState([
                'app_url',
                'name'
            ]),
            ...mapState('user',{
                user:state => state.user
            }),
        },
        mounted() {
        },
        created() {
            this.getData();
        },
        methods:{

        }

    };
</script>
<style scoped>

    .media .pay-wx{
        height: 480px;


    }
    .media .alipay{
        height: 520px;
    }
    .page-header{
        border-bottom:1px solid #a4aaae;
        font-size: 14px;
    }
    .thumbnail{
        height: 300px;
        overflow: hidden;
    }
    .featurette-divider{
        border-top: 1px solid #a4aaae;
    }
    .thumbnail1{
        height: 150px;
        overflow: hidden;
    }
    .caption h3{
        color: white;
    }
    .thumbnail .caption{
        padding-top: 0px;
    }
    .masthead-links li{
        display: block;
        margin-bottom: 10px;
    }
</style>
