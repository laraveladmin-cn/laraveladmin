<template>
    <div class="open_markdown">
            <edit :options="options" ref="edit" @loaded="loaded">
                <template slot="content" slot-scope="props">
                    <div class="markdown-show">
                        <markdown-view v-model="props.data.row['markdown']">
                        </markdown-view>
                    </div>
                </template>
            </edit>
    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations, mapGetters} from 'vuex';

    export default {
        components: {
            edit: ()=>import(/* webpackChunkName: "common_components/edit.vue" */ 'common_components/edit.vue'),
            markdownView:()=>import(/* webpackChunkName: "common_components/markdownView.vue" */ 'common_components/markdownView.vue'), //markdown编辑器
        },
        props: {
            url:{
                type: [String],
                default: function () {
                    return '/open/markdown';
                }
            },
            noBack:{
                type: [Boolean],
                default: function () {
                    return false;
                }
            },
            callback:{
                type: [Function],
                default: function () {
                    return function () {};
                }
            },
        },
        data() {
            let key = this.$route.params.key || '';
            let url = this.url || '';
            url = key?url+'?key='+key:url;

            return {
                options: {
                    lang_table:'subjects', //字段翻译
                    id: 'edit', //多个组件同时使用时唯一标识
                    params: null, //默认筛选条件
                    url:url, //数据表请求数据地址
                    no_back:this.noBack,
                    hideFoot:true,
                    deleteClassRow:true,
                    callback: (response, row) => { //修改成功
                        this.callback();
                    }
                },
                page_title:''
            };
        },
        methods: {
            loaded(){
                let name = this.$refs['edit'].data.row.name || '';
                if(name){
                    //修改页面title
                    this.page_title = window.document.title;
                    window.document.title = name;

                }
            }
        },
        computed: {
            ...mapState([
                'use_url',
                'theme'
            ])
        },
        watch:{
            url(val){
                this.options.url = val;
            }
        },
        destroyed(){
            if(this.page_title){
                window.document.title = this.page_title;
            }
        },
        mounted(){
            $('body,html').addClass('bg-white');
        },
        beforeDestroy(){
            $('body,html').removeClass('bg-white');
        }

    };
</script>
<style scoped>
.markdown-show{
    margin-top: 5px;
}
</style>
