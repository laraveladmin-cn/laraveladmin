<template>
        <div class="admin_message_edit">
        <div class="box" :class="'box-'+theme">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options" ref="edit">
                    <template slot="content" slot-scope="props">
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="user_id" :options="{name: '用户',type:'select2', rules:'',title:''}" :datas="props">
                                <template slot="input-item">
                                        <select2 v-model="props.data.row['user_id']"
                                                 :default-options="props.maps['user_id']"
                                                 :url="use_url+'/admin/users/list'"
                                                 :keyword-key="'name'"
                                                 :show="['name','uname']"
                                                 :disabled="!props.url"
                                                 :placeholder-show="$t('Please select')"
                                                 :placeholder-value="0"
                                                 :is-ajax="true">
                                        </select2>
                                </template>
                            </edit-item>
                            <edit-item key-name="title" :options="{name: '标题',type:'text', rules:'required',title:''}" :datas="props">
                            </edit-item>
                            <edit-item key-name="type" :options="{name: '类型',type:'icheckRadio', rules:'required|in:0,1,2',title:''}" :datas="props">
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

                            <edit-item key-name="operate_id" :options="{name: '操作者',type:'text', rules:'',title:''}" :datas="props"  v-if="props.data.row['operate_id']">
                                <template slot="input-item">
                                    <select2 v-model="props.data.row['operate_id']"
                                             :default-options="props.maps['operate_id']"
                                             :url="use_url+'/admin/users/list'"
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
                        <div class="move-items col-lg-8 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="content" :options="{name: '内容',type:'markdown', rules:'',title:''}" :datas="props">
                                    <template slot="input-item">
                                        <editor-md v-model="props.data.row['content']"
                                                   :disabled="!props.url">
                                        </editor-md>
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
            editorMd:()=>import(/* webpackChunkName: "common_components/editorMd.vue" */ 'common_components/editorMd.vue'), //markdown编辑器
            select2:()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'), //选择框异步组件
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
                    lang_table:'messages', //字段翻译
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
