<template>
    <div class="home_layout h100">
        <div v-if="locales.length>1" class="language">
            <a @click="openLanguage">
                <language ref="language" :value="language" @change="setLanguage"></language>
            </a>
        </div>
      <!--  <div>{{$tp('Header')}}</div>
        <div>{{$tp('Menu field')}}</div>-->
        <transition name="fade" enter-active-class="animated lightSpeedIn faster" mode="out-in" leave-active-class="animated lightSpeedOut faster">
            <router-view></router-view>
        </transition>
   <!--     <div>{{$tp('Footer')}}</div>-->
    </div>
</template>

<script>
    import { mapState, mapActions, mapMutations, mapGetters } from 'vuex';
    export default {
        components:{
            "language":()=>import(/* webpackChunkName: "common_components/language/language.vue" */ 'common_components/language/language.vue'),
        },
        props: {
        },
        computed:{
            ...mapState([
                'language',
                'locales'
            ]),
        },
        methods:{
            ...mapActions({
                getMenus:'menu/getMenus', //获取菜单数据
                getUser:'user/getUser', //获取用户数据
                logout:'user/logout' //退出登录
            }),
            ...mapMutations({
                menuSet:'menu/set',  //设置当前路由,用于菜单选中
                setLanguage:'setLanguage',
            }),
            openLanguage(){
                this.$refs['language'].open();
            },
        },
        watch: {
            '$route' (to, from) {
                this.menuSet({
                    key:'path',
                    path:to.path
                });
            }
        },
        created() {
            this.menuSet({
                key:'path',
                path:this.$router.currentRoute.path
            });
            this.getUser();
            this.getMenus();
        },
        data(){
            return {
                "{lang_path}":'home.layout',
            };
        }
    };
</script>
<style scoped>
    .language{
        padding: 5px;
        position: fixed;
        right: 5px;
        z-index: 10;
    }
</style>
