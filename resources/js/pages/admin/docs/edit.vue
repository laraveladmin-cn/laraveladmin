<template>
        <div class="app\_models\_doc_edit">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options">
                    <template slot="content" slot-scope="props">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="name" :options="{name: props.transField('Route'),type:'text', rules:'required',title:''}" :datas="props">
                            </edit-item>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <edit-item key-name="description" :options="{name: props.transField('Content'),type:'markdown', rules:'required',title:''}" :datas="props">
                                <template slot="input-item">
                                    <markdown-view v-model="props.data.row['description']">
                                    </markdown-view>
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
            markdownView:()=>import(/* webpackChunkName: "common_components/markdownView.vue" */ 'common_components/markdownView.vue'), //markdown编辑器

        },
        props: {},
        data() {
            return {
                options:{
                    lang_table:'docs',
                    id: 'edit', //多个组件同时使用时唯一标识
                    url: '', //数据表请求数据地址
                    params: null, //默认筛选条件
                    callback: (response, row) => { //修改成功
                    }
                }
            };
        },
        methods: {},
        computed: {
            ...mapState([
                'use_url'
            ])
        }
    };
</script>
