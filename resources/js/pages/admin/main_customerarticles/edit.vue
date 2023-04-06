<template>
        <div class="admin_main_customerarticle_edit">
        <div class="box" :class="'box-'+theme">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options" ref="edit">
                    <template slot="content" slot-scope="props">
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="title" :options="{name: '文章标题',type:'text', rules:'required',title:''}" :datas="props">
                            </edit-item>
                            <edit-item key-name="input" :options="{name: '用户输入',type:'textarea', rules:'required',title:''}" :datas="props">
                            </edit-item>

                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="prompt" :options="{name: '文章提示语',type:'textarea', rules:'required',title:''}" :datas="props">
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="content" :options="{name: '文章内容',type:'textarea', rules:'required',title:''}" :datas="props">
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <edit-item key-name="options" :options="{name: '文章选项',type:'json', rules:'required',title:''}" :datas="props">
                                <template slot="input-item">
                                    <json-edit
                                        v-model="props.data.row['options']"
                                        :disabled="!props.url">
                                    </json-edit>
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
            jsonEdit:()=>import(/* webpackChunkName: "common_components/jsonEdit.vue" */ 'common_components/jsonEdit.vue'), //json编辑器组件
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
                    lang_table:'main_customerarticle', //字段翻译
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
