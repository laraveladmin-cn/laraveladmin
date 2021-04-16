<template>
    <div class="admin_user_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box box-primary" :options="options">
                    <template slot="thead" slot-scope="props">
                        <tr>
                            <th class="id" v-if="props.checkbox" rowspan="2">
                                <icheck v-model="props.selectAll" @change="props.selectAllMethod" :option="1" :disabled-label="true"></icheck>
                            </th>
                            <th v-for="(field,index) in props.showFields"
                                :class="field['class']"
                                @click="props.orderBy(index)"
                                v-if="index!='classify2.name'"
                                :rowspan="index=='classify.name'?1:2"
                                :colspan="index=='classify.name'?2:1">
                                <span v-if="index=='classify.name'">
                                     分类
                                </span>
                                <span v-else>
                                     {{field['name']}}
                                </span>

                            </th>
                            <th class="operate" v-if="props.operation" rowspan="2">操作</th>
                        </tr>
                        <tr>
                            <th v-for="(field,index) in props.showFields" :class="field['class']" @click="props.orderBy(index)"
                                v-if="index=='classify.name' || index=='classify2.name'">
                                {{field['name']}}
                            </th>
                        </tr>
                    </template>
                    <template slot="sizer-more" slot-scope="props">
                        <div class="row" >
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sizer-item">
                                <select2 v-model="props.where['status']"
                                         :default-options="props.maps['status']"
                                         :placeholder-show="'状态'"
                                         :placeholder-value="''"
                                         :is-ajax="false" >
                                </select2>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sizer-item">
                                <select2 v-model="props.where['firm_id']"
                                         :default-options="array_get(props,'maps.firm_id',[])"
                                         :url="use_url+'/admin/firms/list'"
                                         :keyword-key="'name'"
                                         :placeholder-show="'保险公司'"
                                         :placeholder-value="''"
                                         :is-ajax="true" >
                                </select2>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sizer-item">
                                <select2 v-model="props.where['is_long_time']"
                                         :default-options="props.maps['is_long_time']"
                                         :placeholder-show="'是否长期险种'"
                                         :placeholder-value="''"
                                         :is-ajax="false" >
                                </select2>
                            </div>
                        </div>
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
            'data-table':function(resolve){require(['common_components/datatable.vue'], resolve);},
            "select2":function(resolve){
                require(['common_components/select2.vue'], resolve);
            },
            "icheck":()=>import(/* webpackChunkName: "common_components/icheck.vue" */ 'common_components/icheck.vue'),

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
                    checkbox:true, //选择列
                    btnSizerMore:true, //更多筛选条件按钮
                    keywordKey:'name', //关键字查询key
                    keywordGroup:false, //是否为选项组
                    keywordPlaceholder:'请输入名称',
                    primaryKey:'id', //数据唯一性主键
                    defOptions:def_options, //默认筛选条件
                    fields: {
                        "id": {"name": "ID", "order": true},
                        "name": {"name": "名称", "order": true},
                        "code": {"name": "代码", "order": false},
                        "firm.name": {"name": "保险公司", "order": false},
                        "classify.name": {"name": "一级分类", "order": false},
                        "classify2.name": {"name": "二级分类", "order": false},
                        "is_long_time": {"name": "是否长期险种", "order": true,type:'label'},
                        "status": {"name": "状态", "order": true,type:'label'},
                        //"created_at": {"name": "创建时间", "order": true},
                        "updated_at": {"name": "修改时间", "order": true},
                    },
                }
            };
        },
        computed:{
            ...mapState([
                'use_url'
            ])
        },

    };
</script>
<style lang="scss" scoped>
    div table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after{
        top: 28px;
    }

</style>
