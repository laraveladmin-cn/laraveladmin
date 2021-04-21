<template>
    <div class="admin_user_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box box-primary" :options="options">
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
            let def_options = JSON.parse(this.$router.currentRoute.query.options || '{}');
            return {
                options:{
                    id:'data-table', //多个data-table同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    operation:true, //操作列
                    checkbox:false, //选择列
                    btnSizerMore:false, //更多筛选条件按钮
                    keywordKey:'name|key', //关键字查询key
                    keywordGroup:false, //是否为选项组
                    keywordPlaceholder:()=>{
                        return this.$t('enter',{name:this.$t('name')});
                    },//'请输入名称',
                    primaryKey:'id', //数据唯一性主键
                    defOptions:def_options, //默认筛选条件
                    fields: {
                        "id": {"name": "ID", "order": true},
                        "name": {"name": "配置名称", "order": true},
                        "description": {"name": "描述", "order": true},
                        "key": {"name": "配置键", "order": true},
                        "value": {"name": "值", "order": true},
                        //"created_at": {"name": "创建时间", "order": true},
                        "updated_at": {"name": "修改时间", "order": true},
                    },
                }
            };
        },
        computed:{

        }
    };
</script>
<style lang="scss">


</style>
