<template>
        <div class="admin_app_edit">
        <div class="box" :class="'box-'+theme">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options" ref="edit">
                    <template slot="content" slot-scope="props">
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="name" :options="{name: '名称',type:'text', rules:'required',title:''}" :datas="props">
                            </edit-item>
                            <edit-item key-name="version" :options="{name: '版本号',type:'text', rules:'required',title:''}" :datas="props">
                            </edit-item>
                            <edit-item key-name="description" :options="{name: '描述',type:'textarea', rules:'required',title:''}" :datas="props">
                            </edit-item>
                            <edit-item key-name="operate_id" :options="{name: '操作人',type:'select2', rules:'',title:''}" :datas="props" v-if="props.data.row['operate_id']">
                                <template slot="input-item">
                                    <select2 v-model="props.data.row['operate_id']"
                                             :default-options="props.maps['operate_id']"
                                             :url="use_url+'/admin/operates/list'"
                                             :keyword-key="'name'"
                                             :show="['name']"
                                             :disabled="true"
                                             :placeholder-show="$t('Please select')"
                                             :placeholder-value="0"
                                             :is-ajax="true">
                                    </select2>
                                </template>
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">


                            <edit-item key-name="type" :options="{name: '类型',type:'icheckRadio', rules:'in:0,1',title:''}" :datas="props">
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.maps['type']"
                                             class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <icheck v-model="props.data.row['type']"
                                                    :title="item"
                                                    type="radio"
                                                    :option="index"
                                                    :disabled="!props.url">
                                                {{item}}
                                            </icheck>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="forced_update" :options="{name: '是否强制更新',type:'switch', rules:'in:0,1',title:''}" :datas="props">
                                <template slot="input-item">
                                    <el-switch v-model="props.data.row['forced_update']"
                                               :disabled="!props.url"
                                               :active-value="1"
                                               :inactive-value="0"
                                               active-text="是"
                                               inactive-text="'否'"
                                    >
                                    </el-switch>
                                </template>
                            </edit-item>
                            <edit-item key-name="url" :options="{name: '应用程序下载地址',type:'qiniuUpload', rules:'required|url',title:''}" :datas="props">
                                <template slot="input-item">
                                    <qiniu-upload v-model="props.data.row['url']"
                                                  :accept="props.data.row['type']==1?'application/vnd.android.package-archive':'.ipa'"
                                                  :disabled="!props.url">
                                    </qiniu-upload>
                                </template>
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">

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
        components: {
            edit: ()=>import(/* webpackChunkName: "common_components/edit.vue" */ 'common_components/edit.vue'),
            editItem: ()=>import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
            select2:()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'), //选择框异步组件
            elSwitch:()=>import(/* webpackChunkName: "element-ui/lib/switch" */ 'element-ui/lib/switch'), //开关异步组件
            qiniuUpload:()=>import(/* webpackChunkName: "common_components/qiniuUpload.vue" */ 'common_components/qiniuUpload.vue'), //七牛云上传组件
            icheck:()=>import(/* webpackChunkName: "common_components/icheck.vue" */ 'common_components/icheck.vue'), //单选复选组件

        },
        props: {
            url:{
                type: [String],
                default: function () {
                    return '';
                }
            },
            noBack:{
                type: [Boolean],
                default: function () {
                    return false;
                }
            },
            callback:{
                type: [Function],
                default: function () {
                    return function () {};
                }
            }
        },
        data() {
            return {
                options: {
                    lang_table:'apps', //字段翻译
                    id: 'edit', //多个组件同时使用时唯一标识
                    params: null, //默认筛选条件
                    url:this.url || '', //数据表请求数据地址
                    no_back:this.noBack,
                    callback: (response, row) => { //修改成功
                        this.callback();
                    }
                }
            };
        },
        methods: {},
        computed: {
            ...mapState([
                'use_url',
                'theme'
            ])
        },
        watch:{
            url(val){
                this.options.url = val;
            }
        }
    };
</script>
