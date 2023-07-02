<template>
    <div class="open_app_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box" :class="'box-'+theme" :options="options" ref="table">
                </data-table>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations, mapGetters} from 'vuex';
    export default {
        components:{
            'data-table':()=>import(/* webpackChunkName: "common_components/datatable.vue" */ 'common_components/datatable.vue')
        },
        props: {
        },
        data(){
            return {
                options:{
                    lang_table:'apps', //字段翻译
                    id:'data-table', //多个data-table同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    operation:true, //操作列
                    checkbox:true, //选择列
                    btnSizerMore:false, //更多筛选条件按钮
                    keywordKey:'name', //关键字查询key
                    keywordGroup:false, //是否为选项组
                    keywordPlaceholder:()=>{
                        return this.$t('Please enter keywords');
                    },
                    primaryKey:'id', //数据唯一性主键
                    defOptions:null, //默认筛选条件
                    fields: {id:{name:"ID",order:true},type:{name:"类型",order:true,type:"icheckRadio"},name:{name:"名称",order:true},description:{name:"描述",order:true,type:"textarea"},url:{name:"应用程序下载地址",order:true,type:"qiniuUpload"},version:{name:"版本号",order:true},forced_update:{name:"是否强制更新",order:true,type:"switch"},operate_id:{name:"操作人",order:true,type:"select2"},created_at:{name:"Created At",order:true,type:"time"},updated_at:{name:"Updated At",order:true,type:"time"}}
                }
            };
        },
        computed:{
            ...mapState([
                'use_url',
                'theme'
            ])
        },
        methods:{

        }
    };
</script>
<style lang="scss" scoped>


</style>
