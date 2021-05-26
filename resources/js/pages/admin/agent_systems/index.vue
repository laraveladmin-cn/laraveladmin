<template>
    <div class="admin_user_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box box-primary" ref="table" :options="options">
                    <template slot="col" slot-scope="props">
                        <span v-if="props.field.type =='label'">
                            <span class="label" :class="'label-'+statusClass[props.row[props.k]%statusClass.length]">
                                {{ props.maps[props.k] | array_get(props.row[props.k]) }}
                            </span>
                        </span>
                        <span v-else-if="props.k =='firms_count'">
                             <router-link :to="'/admin/firms?options='+getOptions({where:{'banks.bank_id':props.row['id']}})">
                                {{props.row | array_get(props.k)}}
                             </router-link>
                        </span>
                        <span v-else>
                            {{props.row | array_get(props.k)}}
                        </span>
                    </template>
                    <template slot="input_group_add_btn" slot-scope="props">
                        <button type="button" :title="$t('Delete within condition')" v-if="props.data.configUrl.conditionDeleteUrl" class="btn btn-primary" @click="conditionDelete(props.data.options)">
                            <i class="glyphicon glyphicon glyphicon-trash"></i>
                        </button>
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
            'data-table':function(resolve){require(['common_components/datatable.vue'], resolve);}
        },
        props: {
        },
        data(){
            let def_options = JSON.parse(this.$router.currentRoute.query.options || '{}');
            return {
                options:{
                    lang_table:'agent_systems',
                    id:'data-table', //多个data-table同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    operation:true, //操作列
                    checkbox:true, //选择列
                    btnSizerMore:false, //更多筛选条件按钮
                    keywordKey:'name', //关键字查询key
                    keywordGroup:false, //是否为选项组
                    keywordPlaceholder:()=>{
                        return this.$t('enter',{name:this.$t('name')});
                    },//'请输入Name'',
                    primaryKey:'id', //数据唯一性主键
                    defOptions:def_options, //默认筛选条件
                    fields: {
                        "id": {"name": "ID", "order": true},
                        "name": {"name": "Name", "order": true},
                        "full_name": {"name": "Full name", "order": true},
                        "ip": {"name": "Binding IP", "order": true},
                        "mac": {"name": "Server unique ID", "order": true},
                        //"created_at": {"name": "Created At", "order": true},
                        "updated_at": {"name": "Updated At", "order": true},
                    },
                }
            };
        },
        computed:{
            ...mapState([
                'use_url'
            ]),
        },
        methods:{
            //全局数据设置,设置弹窗提示
            ...mapMutations({
                set:'set'
            }),
            conditionDelete(options){
                if(this.submiting){
                    return;
                }
                this.set({
                    key:'modal',
                    modal:{
                        title:'提示',
                        content: '您确定要删除吗?',
                        callback:()=>{
                            this.submiting = true;
                            axios['delete'](this.use_url+this.$refs.table.data.configUrl.conditionDeleteUrl, {data:options}).then( (response)=>{
                                this.submiting = false;
                                this.$refs.table.refresh();
                            }).catch((error) =>{
                                this.submiting = false;
                                if(error.response && error.response.status==422){
                                    this.pushMessage({
                                        'showClose':true,
                                        'title':trans('The operation failure!'),
                                        'message':'',
                                        'type':'danger',
                                        'position':'top',
                                        'iconClass':'fa-warning',
                                        'customClass':'',
                                        'duration':3000,
                                        'show':true
                                    });
                                }
                            });
                        }},
                });

            }
        }
    };
</script>
<style lang="scss">


</style>
