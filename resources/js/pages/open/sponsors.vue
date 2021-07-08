<template>
    <div class="open_sponsors">
        <div class="container">
            <data-table :options="options">
                <template slot="sizer" slot-scope="props">
                    <div class="row sizer">
                        <div class="col-lg-6 col-md-8 col-sm-8 col-xs-12 col-lg-offset-3 col-md-offset-2 col-sm-offset-2">
                            <div class="input-group">
                                <input @keyup.enter="search"  v-model="props.data.options.where[options.keywordKey]" :placeholder="$t('enter',{name:$t('name')})" type="text" class="form-control">
                                <div class="input-group-btn">
                                    <button type="button" :title="$t('Search')" class="btn btn-primary" @click="props.search">
                                        <i class="fa fa-search"></i> {{$t('Search')}}
                                    </button>
                                    <button type="button" :title="$t('Reset')" class="btn btn-primary " @click="props.reset">
                                        <i class="fa fa-repeat"></i> {{$t('Reset')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template slot="table" slot-scope="props">
                    <div class="items">
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6" v-for="(row,i) in (props.data.list?props.data.list.data:[])">
                            <div class="thumbnail">
                                <a :href="row.url" target="_blank">
                                    <img :src="row.logo" class="item">
                                </a>
                            </div>
                        </div>
                    </div>
                </template>

            </data-table>
        </div>
    </div>
</template>

<script>
    import { mapState, mapActions, mapMutations, mapGetters } from 'vuex';
    export default {
        components:{
            'data-table':()=>import(/* webpackChunkName: "common_components/datatable.vue" */ 'common_components/datatable.vue'),
        },
        props: {
        },
        computed:{
            ...mapState([
                'app_url'
            ]),
        },
        mounted() {
        },
        created() {
        },
        methods:{

        },
        data(){
            let def_options = JSON.parse(this.$router.currentRoute.query.options || '{}');
            return {
                options:{
                    lang_table:'sponsors',
                    "{lang_path}":'open.sponsors',
                    id:'data-table', //多个data-table同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    operation:true, //操作列
                    checkbox:true, //选择列
                    btnSizerMore:false, //更多筛选条件按钮
                    btnRefresh:false,//刷新按钮
                    keywordKey:'name', //关键字查询key
                    keywordGroup:false, //是否为选项组
                    keywordPlaceholder:()=>{
                        return this.$t('enter',{name:this.$t('name')});
                    },//'请输入Name'',
                    primaryKey:'id', //数据唯一性主键
                    defOptions:def_options, //默认筛选条件
                    hideTopPagerTool:true,
                    fields: {

                    },
                    per_page_options:[16,40,120],
                }
            };
        }

    };
</script>
<style scoped>
    .page-header{
        border-bottom:1px solid #a4aaae;
        font-size: 14px;
    }
    .featurette-divider{
        border-top: 1px solid #a4aaae;
    }
    .thumbnail{
        height: 150px;
    }
    .caption h3{
        color: white;
    }
    .items .item{
        max-height: 100%;
        max-width: 100%;
    }
    .sizer{
        margin-top: 20px;
    }
</style>
