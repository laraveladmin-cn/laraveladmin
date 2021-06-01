<template>
        <div class="app\_models\_feature_edit">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options">
                    <template slot="content" slot-scope="props">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="name" :options="{name: props.transField('Name'),type:'text', rules:'required|min:2|max:8',title:'请填入2-8个字符'}" :datas="props">
                            </edit-item>
                            <edit-item key-name="icon" :options="{name: props.transField('Icon'),type:'icon', rules:'alpha_dash',title:''}" :datas="props">
                            </edit-item>
                            <edit-item key-name="color" :options="{name: props.transField('Colour'),type:'color', rules:'required',title:''}" :datas="props">
                                <template slot="input-item">
                                    <colorpicker v-model="props.data.row['color']"
                                                 :disabled="!props.url">
                                    </colorpicker>
                                </template>
                            </edit-item>
                            <edit-item key-name="description" :options="{name: props.transField('Describe'),type:'textarea', rules:'required|min:20|max:100',title:'请填入20-100个字符'}" :datas="props">
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
            colorpicker:()=>import(/* webpackChunkName: "common_components/colorpicker.vue" */ 'common_components/colorpicker.vue'),
        },
        props: {},
        data() {
            return {
                options:{
                    lang_table:'features',
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
