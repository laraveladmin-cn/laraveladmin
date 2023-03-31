<template>
    <div class="admin_main_customer_index">
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
                    lang_table:'main_customer', //字段翻译
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
                    fields: {id:{name:"id",order:true},mobile:{name:"手机号(含区号)",order:true},nickname:{name:"昵称",order:true},avatar:{name:"头像",order:true,type:"upload"},name:{name:"真实姓名",order:true},email:{name:"电子邮箱",order:true},is_active:{name:"状态",order:true,type:"radio"},last_login:{name:"最后登录日期",order:true,type:"datetime"},role_id:{name:"用户角色",order:true,type:"select2"},created_at:{name:"Created At",order:true,type:"time"},updated_at:{name:"Updated At",order:true,type:"time"}}
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
