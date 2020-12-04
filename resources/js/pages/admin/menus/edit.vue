<template>
    <div class="admin_user_edit">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">快速填写</h3>
            </div>
            <div class="box-body">
                <edit :options="options">
                    <template slot="content" slot-scope="props">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="name" :options="{name: '名称', required: false}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="icons" :options="{name: '图标', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            v-model="props.data.row['icons']"
                                            class="form-control"
                                            :disabled="!props.url"
                                            :placeholder="'请输入图标样式'">
                                        <div class="input-group-addon">
                                            <i class="fa" :class="props.data.row['icons']"></i>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="url" :options="{name: 'RUL路径', required: false}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="description" :options='{"name": "描述", "required": false,"type":"textarea","title":"提示信息"}' :datas="props">
                            </edit-item>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="method" :options="{name: '请求方式', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.data.maps['method']" class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <icheck v-model="props.data.row['method']" :option="index" :disabled="!props.url"> {{item}}</icheck>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="is_page" :options="{name: '是否为页面', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.data.maps['is_page']" class="col-lg-3 col-md-3 col-sm-3 col-xs-2">
                                            <icheck v-model="props.data.row['is_page']" type="radio" :option="index" :disabled="!props.url"> {{item}}</icheck>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="status" :options="{name: '状态', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.data.maps['status']" class="col-lg-4 col-md-4 col-sm-4 col-xs-3">
                                            <icheck v-model="props.data.row['status']" type="radio" :option="index" :disabled="!props.url"> {{item}}</icheck>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="parent_id" :options='{"name": "所属父级选择", "required": false}' :datas="props">
                                <template slot="input-item">
                                    <div>
                                        <ztree v-model="props.data.row['parent_id']"
                                               :check-enable="false"
                                               :multiple="false"
                                               :disabled="!props.url"
                                               :id="'parent'"
                                               :chkbox-type='{ "Y" : "", "N" : "" }'
                                               :data="props.data.maps['optional_parents']">
                                        </ztree>
                                    </div>
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
        components:{
            'edit':()=>import(/* webpackChunkName: "common_components/edit.vue" */ 'common_components/edit.vue'),
            "edit-item": ()=>import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
            "icheck":()=>import(/* webpackChunkName: "common_components/icheck.vue" */ 'common_components/icheck.vue'),
            "ztree":()=>import(/* webpackChunkName: "common_components/ztree.vue" */ 'common_components/ztree.vue')
        },
        props: {
        },
        data(){
            return {
                options:{
                    id:'edit', //多个组件同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    params:this.$router.currentRoute.query || {}
                }
            };
        }
    };
</script>
