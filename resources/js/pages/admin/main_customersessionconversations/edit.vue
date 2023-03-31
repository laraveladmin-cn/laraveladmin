<template>
    <div class="admin_main_customersessionconversation_edit">
        <div class="box" :class="'box-'+theme">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}
                </h3>
            </div>
            <div class="box-body">
                <edit :options="options" ref="edit">
                    <template slot="content" slot-scope="props">
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="customer_session_id" :options="{name: '会话',type:'select2', rules:'required',title:''}" :datas="props">
                                <template slot="input-item">
                                    <select2 v-model="props.data.row['customer_session_id']"
                                        :default-options="props.maps['main_customersession_id']"
                                        :url="use_url+'/admin/main-customersessions/list'"
                                        :keyword-key="'title'"
                                        :show="['title']"
                                        :disabled="!props.url"
                                        :placeholder-show="$t('Please select')"
                                        :placeholder-value="0"
                                        :is-ajax="true">
                                    </select2>
                                </template>
                            </edit-item>
                            <edit-item key-name="user_id" :options="{name: '用户',type:'select2', rules:'required',title:''}" :datas="props">
                                <template slot="input-item">
                                    <select2 v-model="props.data.row['user_id']"
                                        :default-options="props.maps['main_customer_id']"
                                        :url="use_url+'/admin/main-customers/list'"
                                        :keyword-key="'name|mobile'"
                                        :show="['name','mobile']"
                                        :disabled="!props.url"
                                        :placeholder-show="$t('Please select')"
                                        :placeholder-value="0"
                                        :is-ajax="true">
                                    </select2>
                                </template>
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="human" :options="{name: '用户输入',type:'textarea', rules:'required',title:''}" :datas="props">
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="ai" :options="{name: 'AI回答',type:'textarea', rules:'',title:''}" :datas="props">
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
                    lang_table:'main_customersessionconversation', //字段翻译
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
