<template>
    <div class="admin_user_edit">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">快速填写</h3>
            </div>
            <div class="box-body">
                <edit :options="options">
                    <template slot="content" slot-scope="props">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="name" :options="{name: '名称', required: true,rules:'required'}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="firm_id" :options="{name: '保险公司', required: true,rules:'required'}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['firm_id']"
                                                 :default-options="array_get(props,'data.row.firm.id',0)?[array_get(props,'data.row.firm')]:[]"
                                                 :url="use_url+'/admin/firms/list'"
                                                 :keyword-key="'name'"
                                                 :disabled="!props.url"
                                                 :placeholder-show="'请选择保险公司'"
                                                 :placeholder-value="'0'"
                                                 :is-ajax="true" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="uid" :options="{name: '唯一标识', required: false}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="pclassify_ids" :options="{name: '险种分组', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <el-cascader
                                        class="w-100"
                                        v-model="props.data.row['pclassify_ids']"
                                        :disabled="!props.url"
                                        :props="{ expandTrigger: 'hover',value:'id',label:'name' }"
                                        :options="props.data.maps['pclassify_ids']"
                                        @change="props.data.row['pclassify_id'] = array_get(props,'data.row.pclassify_ids',[]).length?props.data.row['pclassify_ids'][props.data.row['pclassify_ids'].length-1]:0"
                                    >
                                    </el-cascader>
                                </template>
                            </edit-item>
                            <edit-item key-name="classify_id" :options="{name: '一级分类', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['classify_id']"
                                                 :disabled="!props.url"
                                                 :default-options="props.data.maps['classify_id']"
                                                 :placeholder-show="'请选择'"
                                                 :placeholder-value="'0'"
                                                 @change="props.data.row['classify2_id']=0"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="classify_id" :options="{name: '二级分类', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['classify2_id']"
                                                 :disabled="!props.url"
                                                 :default-options="array_get(props,'data.maps.classify_id.'+props.data.row['classify_id']+'.children',[])"
                                                 :placeholder-show="'请选择'"
                                                 :placeholder-value="'0'"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="company_no" :options="{name: '保险公司文件编号', required: false}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="no" :options="{name: '文件编号', required: false}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="is_long_time" :options="{name: '长期险种', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['is_long_time']"
                                                 :disabled="!props.url"
                                                 :default-options="props.data.maps['is_long_time']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="class" :options="{name: '类别', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['class']"
                                                 :disabled="!props.url"
                                                 :default-options="props.data.maps['class']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>

                            </edit-item>
                            <edit-item key-name="buy_type" :options="{name: '购买方式', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['buy_type']"
                                                 :disabled="!props.url"
                                                 :default-options="props.data.maps['buy_type']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>

                            </edit-item>
                            <edit-item key-name="pay_type" :options="{name: '交费方式', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content-min">
                                        <div class="row">
                                            <div v-for="(item,index) in props.data.maps['pay_type']" class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                <icheck v-model="props.data.row['pay_type']" :option="index" :disabled="!props.url"> {{item}}</icheck>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="attr" :options="{name: '产品属性', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['attr']"
                                                 :disabled="!props.url"
                                                 :default-options="props.data.maps['attr']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>

                            </edit-item>
                            <edit-item key-name="pdf_url" :options="{name: '文档地址', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            v-model="props.data.row['pdf_url']"
                                            class="form-control"
                                            :disabled="!props.url"
                                            :placeholder="'请输入文档地址'">
                                        <div class="input-group-addon">
                                            <a v-if="props.data.row['pdf_url']" :href="props.data.row['pdf_url']" target="_blank">
                                                <i class="fa fa-link"></i>
                                            </a>
                                            <i v-else class="fa fa-link"></i>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="status" :options="{name: '状态', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['status']"
                                                 :disabled="!props.url"
                                                 :default-options="props.data.maps['status']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="issue_at" :options="{name: '发布时间', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <el-date-picker
                                        class="w-100"
                                        v-model="props.data.row['issue_at']"
                                        type="datetime"
                                        value-format="yyyy-MM-dd HH:mm:ss"
                                        :disabled="!props.url"
                                        placeholder="请选择发布时间点">
                                    </el-date-picker>
                                </template>
                            </edit-item>
                            <edit-item key-name="stop_at" :options="{name: '停售日期', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <el-date-picker class="w-100"
                                                    v-model="props.data.row['stop_at']"
                                                    type="date"
                                                    value-format="yyyy-MM-dd"
                                                    :disabled="!props.url"
                                                    placeholder="请选择停售日期">
                                    </el-date-picker>
                                </template>
                            </edit-item>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                          <edit-item key-name="year_ids" :options='{"name": "可选年期", "required": false,type:"checkbox"}'  :datas="props">
                                <template slot="input-item">
                                    <hide-more :tool="count(array_get(props,'data.maps.year_ids',[]))>33">
                                        <template>
                                            <div v-for="(item,index) in props.data.maps['year_ids']" class="col-lg-4 col-md-4 col-sm-4 col-xs-4" v-if="index<=33">
                                                <icheck v-model="props.data.row['year_ids']" :option="index" :disabled="!props.url"> {{item}}</icheck>
                                            </div>
                                        </template>
                                        <template slot="hide">
                                            <div v-for="(item,index) in props.data.maps['year_ids']" class="col-lg-4 col-md-4 col-sm-4 col-xs-4" v-if="index>33">
                                                <icheck v-model="props.data.row['year_ids']" :option="index" :disabled="!props.url"> {{item}}</icheck>
                                            </div>
                                        </template>
                                    </hide-more>
                                </template>
                            </edit-item>
                        </div>
                    </template>
                </edit>

            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations, mapGetters} from 'vuex';
    export default {
        components:{
            'edit':function(resolve){require(['common_components/edit.vue'], resolve);},
            "edit-item": function (resolve) {
                require(['common_components/editItem.vue'], resolve);
            },
            "select2":function(resolve){
                require(['common_components/select2.vue'], resolve);
            },
            "icheck":function(resolve){
                require(['common_components/icheck.vue'], resolve);
            },
            "el-date-picker": function (resolve) {
                require(['element-ui/lib/date-picker'], resolve);
            },
            "el-cascader": function (resolve) {
                require(['element-ui/lib/cascader'], resolve);
            },
            "hide-more": function (resolve) {
                require(['common_components/hideMore'], resolve);
            }
        },
        props: {
        },
        data(){
            return {
                options:{
                    id:'edit', //多个组件同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    params:this.$router.currentRoute.query || {}
                }
            };
        },
        methods: {
        },
        computed:{
            ...mapState([
                'api_url',
                'use_url'
            ]),
        }
    };
</script>
