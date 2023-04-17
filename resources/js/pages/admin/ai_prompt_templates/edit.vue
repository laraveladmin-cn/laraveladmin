<template>
        <div class="admin_ai_prompt_template_edit">
        <div class="box" :class="'box-'+theme">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options" ref="edit">
                    <template slot="content" slot-scope="props">
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="name" :options="{name: '模板名称',type:'text', rules:'required',title:''}" :datas="props">
                            </edit-item>
                            <edit-item key-name="cue_word" :options="{name: '提示词内容',type:'textarea', rules:'required',title:''}" :datas="props">
                            </edit-item>
                            <edit-item key-name="icon" :options="{name: '图标',title:'双击图标即可选中'}" :datas="props">
                                <template slot="input-item">
                                    <icon-edit
                                        v-model="props.data.row['icon']"
                                        :disabled="!props.url"
                                        :placeholder="'请输入图标样式'">
                                    </icon-edit>
                                </template>
                            </edit-item>
                            <edit-item key-name="content" :options="{name: '模板内容',type:'textarea', rules:'',title:''}" :datas="props">
                            </edit-item>

                        </div>
                        <div class="move-items col-lg-8 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="options" :options="{name: '可选项配置',type:'text', rules:'array',title:''}" :datas="props">
                                <template slot="input-item">
                                    <options :disabled="!props.url"
                                             :datas="props">
                                    </options>
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
            options: ()=>import(/* webpackChunkName: "pages/admin/ai_prompt_templates/options.vue" */ 'pages/admin/ai_prompt_templates/options.vue'),
            "iconEdit": () => import(/* webpackChunkName: "common_components/iconEdit.vue" */ 'common_components/iconEdit.vue'),
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
                    lang_table:'ai_prompt_templates', //字段翻译
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
