<template>
        <div class="app\_models\_technology_edit">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">快速填写</h3>
            </div>
            <div class="box-body">
                <edit :options="options">
                    <template slot="content" slot-scope="props">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="name" :options="{name: '名称',type:'text', rules:'required|min:2|max:20',title:''}" :datas="props">
                            </edit-item>
                            <edit-item key-name="url" :options="{name: '链接地址',type:'url', rules:'url',title:''}" :datas="props">
                            </edit-item>

                            <edit-item key-name="description" :options="{name: '描述',type:'textarea', rules:'required|min:20|max:150',title:''}" :datas="props">
                            </edit-item>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="logo" :options="{name: 'LOGO图片地址',type:'url', rules:'required|url',title:''}" :datas="props">
                            </edit-item>
                            <edit-item key-name="logo" :options="{name: 'LOGO图片',type:'upload', rules:'required|url',title:''}" :datas="props">
                                <template slot="input-item">
                                    <upload v-model="props.data.row['logo']"
                                            :width="250"
                                            :height="125"
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
            upload:function(resolve){require(['common_components/upload.vue'], resolve);}, //上传组件
        },
        props: {},
        data() {
            return {
                options: {
                    id: 'edit', //多个组件同时使用时唯一标识
                    url: '', //数据表请求数据地址
                    params: null, //默认筛选条件
                    callback: (response, row) => { //修改成功
                    }
                }
            };
        },
        methods: {},
        computed: {}
    };
</script>
