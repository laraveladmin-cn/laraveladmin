<template>
    <div class="admin_user_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box" :class="'box-'+theme" :options="options">
                    <template slot="col" slot-scope="props">
                        <span v-if="props.k =='name' || props.k =='parent.name' ">
                            {{$tp(array_get(props.row ,props.k),shared_name)}}
                        </span>
                        <span v-else-if="props.k =='description'">
                            {{$tp(array_get(props.row ,props.k),shared_description) | str_limit(80,'...')}}
                        </span>
                        <span v-else-if="props.field.type =='label'">
                            <span class="label" :class="'label-'+statusClass[props.row[props.k]%statusClass.length]">
                                {{ props.maps[props.k] | array_get(props.row[props.k]) }}
                            </span>
                        </span>
                        <div v-else-if="props.k =='name'" style="text-align: left">
                            {{ props.row['level'] | deep}} {{props.row | array_get(props.k)}}
                        </div>
                        <span v-else-if="props.k =='admins_count'">
                              <router-link :to="'/admin/admins?options='+getOptions({where:{'roles.id':props.row['id']}})">
                                {{props.row | array_get(props.k)}}
                              </router-link>
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
                shared_name:{
                    "{lang_path}":'_shared.datas.roles.name',
                    '{lang_root}':''
                },
                shared_description:{
                    "{lang_path}":'_shared.datas.roles.description',
                    '{lang_root}':''
                },
                options:{
                    lang_table:'roles',
                    id:'data-table', //多个data-table同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    operation:true, //操作列
                    checkbox:true, //选择列
                    btnSizerMore:false, //更多筛选条件按钮
                    keywordKey:'name', //关键字查询key
                    keywordGroup:false, //是否为选项组
                    keywordPlaceholder:()=>{
                        return this.$t('enter',{name:this.$t('name')});
                    },//'请输入Name',
                    primaryKey:'id', //数据唯一性主键
                    defOptions:def_options, //默认筛选条件
                    fields: {
                        "id": {"name": "ID", "order": true},
                        "name": {"name": "Name", "order": true,levelName:'level',class:'text-left'},
                        "description": {"name": "Describe", "order": true},
                        "parent.name": {"name": "Parent name", "order": false},
                        "admins_count": {"name": "Administrator number", "order": true},
                        //"created_at": {"name": "Created At", "order": true},
                        "updated_at": {"name": "Updated At", "order": true},
                    },
                    "mapsRelations": {
                        "parent": "roles"
                    },
                }
            };
        },
        computed:{
            ...mapState([
                'statusClass',
                'theme'
            ]),
        }
    };
</script>
<style lang="scss">


</style>
