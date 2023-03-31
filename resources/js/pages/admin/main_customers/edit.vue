<template>
        <div class="admin_main_customer_edit">
        <div class="box" :class="'box-'+theme">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options" ref="edit">
                    <template slot="content" slot-scope="props">
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="mobile" :options="{name: '手机号(含区号)',type:'text', rules:'required',title:''}" :datas="props">
                            </edit-item>
                            <edit-item key-name="nickname" :options="{name: '昵称',type:'text', rules:'',title:''}" :datas="props">
                            </edit-item>
                            <edit-item key-name="avatar" :options="{name: '头像',type:'upload', rules:'',title:''}" :datas="props">
                                <template slot="input-item">
                                    <upload v-model="props.data.row['avatar']"
                                            :disabled="!props.url">
                                    </upload>
                                </template>
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="name" :options="{name: '真实姓名',type:'text', rules:'',title:''}" :datas="props">
                            </edit-item>
                            <edit-item key-name="email" :options="{name: '电子邮箱',type:'text', rules:'email',title:''}" :datas="props">
                            </edit-item>
                            <edit-item key-name="is_active" :options="{name: '状态',type:'radio', rules:'in:0,1',title:''}" :datas="props">
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="last_login" :options="{name: '最后登录日期',type:'datetime', rules:'',title:''}" :datas="props">
                                    <template slot="input-item">
                                        <el-date-picker v-model="props.data.row['last_login']"
                                                        class="w-100"
                                                        value-format="yyyy-MM-dd HH:mm:ss"
                                                        :placeholder="$t('Select time')"
                                                        type="datetime"
                                                        :editable="false"
                                                        :disabled="!props.url">
                                        </el-date-picker>
                                    </template>
                            </edit-item>
                            <edit-item key-name="role_id" :options="{name: '用户角色',type:'select2', rules:'required',title:''}" :datas="props">
                                <template slot="input-item">
                                        <select2 v-model="props.data.row['role_id']"
                                                 :default-options="props.maps['role_id']"
                                                 :url="use_url+'/admin/roles/list'"
                                                 :keyword-key="'name'"
                                                 :show="['name']"
                                                 :disabled="!props.url"
                                                 :placeholder-show="$t('Please select')"
                                                 :placeholder-value="0"
                                                 :is-ajax="true">
                                        </select2>
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
        components: {
            edit: ()=>import(/* webpackChunkName: "common_components/edit.vue" */ 'common_components/edit.vue'),
            editItem: ()=>import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
            select2:()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'), //选择框异步组件
            upload:()=>import(/* webpackChunkName: "common_components/upload.vue" */ 'common_components/upload.vue'), //上传组件
            elDatePicker:()=>import(/* webpackChunkName: "element-ui/lib/date-picker" */ 'element-ui/lib/date-picker'), //日期组件
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
                    lang_table:'main_customer', //字段翻译
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
