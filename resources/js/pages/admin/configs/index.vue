<template>
    <div class="admin_user_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box" :class="'box-'+theme" :options="options">
                    <template slot="col" slot-scope="props">
                        <span v-if="props.k =='name'">
                            {{$tp(array_get(props.row ,props.k),shared_name)}}
                        </span>
                        <span v-else-if="props.field.type =='code'">
                            <code v-if="props.field.limit">
                                {{props.row | array_get(props.k) | str_limit(props.field.limit)}}
                            </code>
                            <code v-else>
                                  {{props.row | array_get(props.k)}}
                            </code>
                        </span>
                        <span v-else-if="props.k =='description'">
                            {{$tp(array_get(props.row ,props.k),shared_description) | str_limit(80,'...')}}
                        </span>
                        <span v-else>
                            {{props.row | array_get(props.k)}}
                        </span>
                    </template>
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
                shared_name:{
                    "{lang_path}":'_shared.datas.configs.name',
                    '{lang_root}':''
                },
                shared_description:{
                    "{lang_path}":'_shared.datas.configs.description',
                    '{lang_root}':''
                },
                options:{
                    lang_table:'configs',
                    id:'data-table', //多个data-table同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    operation:true, //操作列
                    checkbox:false, //选择列
                    btnSizerMore:false, //更多筛选条件按钮
                    keywordKey:'name|key', //关键字查询key
                    keywordGroup:false, //是否为选项组
                    keywordPlaceholder:()=>{
                        return this.$t('enter',{name:this.$t('name')});
                    },//'请输入Name',
                    primaryKey:'id', //数据唯一性主键
                    defOptions:def_options, //默认筛选条件
                    fields: {
                        "id": {"name": "ID", "order": true},
                        "name": {"name": "Configuration name", "order": true},
                        //"description": {"name": "Describe", "order": true},
                        "key": {"name": "Key name", "order": true},
                        "value": {"name": "Value", "order": true,type:"code",limit:30},
                        //"created_at": {"name": "Created At", "order": true},
                        "updated_at": {"name": "Updated At", "order": true},
                    },
                }
            };
        },
        computed:{
            ...mapState([
                'theme'
            ])
        }
    };
</script>
<style lang="scss">


</style>
