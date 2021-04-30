<template>
    <div class="admin_user_edit">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options">
                    <template slot="content" slot-scope="props">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="name" :options="{name: props.transField('Name'), required: true,disabled:true}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="key" :options="{name: '键', required: true,disabled:true}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="type" :options='{"name": props.transField("Type"), "required": false,"type":"select"}' :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['type']"
                                                 :disabled="'disabled'"
                                                 :default-options="props.maps['type']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="itype" :options='{"name": props.transField("Input box type"), "required": false,"type":"select"}' :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['itype']"
                                                 :disabled="'disabled'"
                                                 :default-options="props.maps['itype']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="description" :options="{name: props.transField('Describe'), required: false,type:'textarea'}"  :datas="props">
                            </edit-item>
                        </div>
                        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                            <edit-item key-name="options" :options="{name: props.transField('Component properties'), required: false,type:'textarea'}"  :datas="props">
                                <template slot="input-item">
                                    <json-edit
                                        v-model="props.data.row['options']"
                                        :disabled="!props.url"
                                        :placeholder="'请输入组件属性'">
                                    </json-edit>
                                </template>
                            </edit-item>
                            <edit-item key-name="value" :options="{name: '值', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <input
                                        v-if="props.data.row['itype']==1"
                                        type="text"
                                        v-model="props.data.row['value']"
                                        class="form-control"
                                        :disabled="!props.url"
                                        :placeholder="$t('Please enter')">
                                    <textarea
                                        v-else-if="props.data.row['itype']==2"
                                        v-model="props.data.row['value']"
                                        class="form-control"
                                        rows="6"
                                        :disabled="!props.url"
                                        :placeholder="$t('Please enter')">
                                    </textarea>
                                    <div v-else-if="props.data.row['itype']==3">
                                        <editor-md
                                            v-model="props.data.row['value']"
                                            :disabled="!props.url">
                                        </editor-md>
                                    </div>
                                    <div v-else-if="props.data.row['itype']==4">
                                        <json-edit
                                            v-model="props.data.row['value']"
                                            :disabled="!props.url"
                                            :placeholder="$t('Please enter')">
                                        </json-edit>
                                    </div>
                                    <div class="edit-item-content" v-else-if="props.data.row['itype']==5">
                                        <el-switch v-model="props.data.row['value']"
                                                   :disabled="!props.url"
                                                   :active-text="$t('Closed')"
                                                   :inactive-text="$t('Open')"
                                                   :active-value="1"
                                                   :inactive-value="0">
                                        </el-switch>
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
            "el-input-number": ()=>import(/* webpackChunkName: "element-ui/lib/input-number" */ 'element-ui/lib/input-number'),
            "edit-item": ()=>import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
            "select2":()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),
            "editor-md": ()=>import(/* webpackChunkName: "common_components/editorMd.vue" */ 'common_components/editorMd.vue'),
            "el-switch": ()=>import(/* webpackChunkName: "element-ui/lib/switch" */ 'element-ui/lib/switch'),
            "json-edit":()=>import(/* webpackChunkName: "common_components/jsonEdit.vue" */ 'common_components/jsonEdit.vue')
        },
        props: {
        },
        data(){
            return {
                options:{
                    lang_table:'configs',
                    id:'edit', //多个组件同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    params:this.$router.currentRoute.query || {}
                },
            };
        }
    };
</script>
