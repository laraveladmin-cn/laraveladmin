<template>
        <div class="app\_models\_sponsor_edit">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options" ref="edit">
                    <template slot="content" slot-scope="props">
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="name" :options="{name: '赞助商',type:'text', rules:'required|alpha_dash|between:2,100',title:''}" :datas="props">
                            </edit-item>
                            <edit-item key-name="url" :options="{name: '链接',type:'url', rules:'required|active_url',title:''}" :datas="props">
                                    <template slot="input-item">
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                v-model="props.data.row['url']"
                                                class="form-control"
                                                :placeholder="$t('Please enter')"
                                                :disabled="!props.url" />
                                            <div class="input-group-addon">
                                                <a v-if="props.data.row['url']" :href="props.data.row['url']" target="_blank">
                                                    <i class="fa fa-link">
                                                    </i>
                                                </a>
                                                <i v-else class="fa fa-link">
                                                </i>
                                            </div>
                                        </div>
                                    </template>
                            </edit-item>
                            <edit-item key-name="logo" :options="{name: 'LOGO图标',type:'upload', rules:'required|active_url',title:''}" :datas="props">
                                <template slot="input-item">
                                    <div style="margin-bottom: 5px">
                                        <input
                                            type="text"
                                            v-model="props.data.row['logo']"
                                            class="form-control"
                                            :placeholder="$t('Please enter the link address')"
                                            :disabled="!props.url" />
                                    </div>
                                    <upload v-model="props.data.row['logo']"
                                            :disabled="!props.url">
                                    </upload>
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
            upload:()=>import(/* webpackChunkName: "common_components/upload.vue" */ 'common_components/upload.vue'), //上传组件
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
            },
        },
        data() {
            return {
                options: {
                    lang_table:'sponsors', //字段翻译
                    id: 'edit', //多个组件同时使用时唯一标识
                    "{lang_path}":'pages.admin.sponsors',
                    '{lang_root}':'',
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
                'use_url'
            ])
        },
        watch:{
            url(val){
                this.options.url = val;
            }
        }
    };
</script>
