<template>
    <div class="admin_user_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box box-primary" :options="options">
                    <template slot="sizer-more" slot-scope="props">
                        <div class="row" >
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sizer-item">
                                <input-in v-model="props.where['value']" :placeholder="$tp('Please enter the value , split')"></input-in>
                            </div>
                        </div>
                    </template>
                    <template slot="table" slot-scope="props">
                        <div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6" v-for="(row,i) in (props.data.list?props.data.list.data:[])">
                                <div class="thumbnail">
                                    <div class="caption text-center">
                                        <h3>{{row.value}}</h3>
                                        <p>

                                            {{row.name}}
                                        </p>
                                        <div>
                                            <icheck v-model="props.check_ids"
                                                    class="ids"
                                                    :disabled-label="true"
                                                    :option="row.id">
                                            </icheck>
                                            <div class="operation-item">
                                                <button v-show="props.data.configUrl['deleteUrl']"
                                                        :title="$t('Delete selected')"
                                                        type="button"
                                                        class="btn btn-danger btn-xs"
                                                        @click="props.remove([row.id])">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                                <router-link class="btn btn-info btn-xs"
                                                             :title="$t('Edit')"
                                                             :to="props.data.configUrl['showUrl'].replace('{id}',row.id)"
                                                             v-if="props.data.configUrl['showUrl']">
                                                    <i class="fa fa-edit"></i>
                                                </router-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!--<template slot="col" slot-scope="props">
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
                    </template>-->
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
            "input-in":()=>import(/* webpackChunkName: "common_components/inputIn.vue" */ 'common_components/inputIn.vue'),

        },
        props: {
        },
        data(){
            let def_options = JSON.parse(this.$router.currentRoute.query.options || '{}');
            return {
                "{lang_path}":'_shared.pages.admin.years',
                '{lang_root}':'',
                options:{
                    lang_table:'years',
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
                    hideTopPagerTool:true,
                    fields: {
                        "id": {"name": "ID", "order": true},
                        "value": {"name": "Value", "order": true},
                        "name": {"name": "Name", "order": true},
                        "created_at": {"name": "Created At", "order": true},
                        "updated_at": {"name": "Updated At", "order": true},
                    },
                    per_page_options:[16,40,120],
                }
            };
        },
        computed:{

        }
    };
</script>
<style lang="scss" scoped>
.operation-item{
    margin-bottom: 5px;
    display: inline-block;
}

</style>
