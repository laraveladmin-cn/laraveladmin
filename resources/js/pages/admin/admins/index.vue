<template>
    <div class="admin_user_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box box-primary" :options="options">
                    <template slot="col" slot-scope="props">
                        <span v-if="props.k =='roles_name'">
                            {{rolesName(props.row['roles'])}}
                        </span>
                        <span v-else-if="props.field.type =='label'">
                            <span class="label" :class="props.labelClass(props.row,props.k)">
                                {{ props.maps | array_get(props.k,[]) | array_get(array_get(props.row,props.k)) }}
                            </span>
                        </span>
                        <span v-else>
                            {{props.row | array_get(props.k)}}
                        </span>
                    </template>
                    <template slot="col-operation" slot-scope="props">
                        <button v-show="props.data.configUrl['deleteUrl']"
                                :title="$t('Delete selected')"
                                type="button"
                                class="btn btn-danger btn-xs"
                                :disabled="props.row[options.primaryKey]==1"
                                @click="props.remove([props.row[options.primaryKey]])">
                            <i class="fa fa-trash-o"></i>
                        </button>
                        <router-link class="btn btn-info btn-xs"
                                     :title="$t('Edit')"
                                     :to="props.data.configUrl['showUrl'].replace('{id}',props.row[options.primaryKey])"
                                     v-if="props.data.configUrl['showUrl']">
                            <i class="fa fa-edit"></i>
                        </router-link>
                    </template>
                    <template slot="col-checkbox" slot-scope="props">
                        <icheck v-model="props.check_ids"
                                class="ids"
                                :disabled="props.row[options.primaryKey]==1"
                                :disabled-label="true"
                                :option="props.row[options.primaryKey]"></icheck>
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
            'data-table':()=>import(/* webpackChunkName: "common_components/datatable.vue" */ 'common_components/datatable.vue'),
            "icheck":()=>import(/* webpackChunkName: "common_components/icheck.vue" */ 'common_components/icheck.vue'),
        },
        props: {
        },
        data(){
            let def_options = JSON.parse(this.$router.currentRoute.query.options || '{}');
            return {
                shared_rule_name: {
                    "{lang_path}": '_shared.datas.roles.name',
                    '{lang_root}': ''
                },
                options:{
                    lang_table:'admins',
                    id:'data-table', //多个data-table同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    operation:true, //操作列
                    checkbox:true, //选择列
                    btnSizerMore:false, //更多筛选条件按钮
                    keywordKey:'user.name|user.uname', //关键字查询key
                    keywordGroup:true, //是否为选项组
                    keywordPlaceholder:()=>{
                        return this.$t('enter',{name:this.$t('name')});
                    },//'请输入名称',
                    primaryKey:'id', //数据唯一性主键
                    defOptions:def_options, //默认筛选条件
                    fields: {
                        "id": {"name": "ID", "order": true},
                        "user.uname": {"name": "Username", "order": false},
                        "user.name": {"name": "Name", "order": false},
                        "roles_name": {"name": "Have roles", "order": false},
                        "user.mobile_phone": {"name": "Mobile phone number", "order": false},
                        "user.status": {"name": "Status", "order": false,type:'label'},
                        //"created_at": {"name": "Created At", "order": true},
                        "updated_at": {"name": "Updated At", "order": true},
                    },
                }
            };
        },
        computed:{
            ...mapState([
                'statusClass'
            ]),
        },
        methods:{
            rolesName(roles){
                return collect(roles).map((role)=>{
                    if(typeof role._back_name=="undefined"){
                        role._back_name = role.name;
                    }
                    role.name = this.$tp(role._back_name,this.shared_rule_name);
                    return role;
                }).pluck('name').implode(',');
            }
        }
    };
</script>
<style lang="scss">


</style>
