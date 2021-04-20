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
                            <edit-item key-name="name" :options="{name: '名称', required: true,rules:'required',disabled:props.data.row['id']==1}"  :datas="props"></edit-item>
                            <edit-item key-name="is_tmp" :options='{"name": "设置为模板", "type":"select"}' :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['is_tmp']"
                                                 :disabled="!props.url"
                                                 :default-options="props.data.maps['is_tmp']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="is_tmp" :options='{"name": "模板选择", "type":"select"}' :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['tmp_id']"
                                                 @change="changeTmp(props.data.row,props.data.maps['permissions'])"
                                                 :disabled="!props.url || props.data.row['id']==1"
                                                 :default-options="array_get(props,'data.row.tmp.id',0)?[array_get(props,'data.row.tmp')]:[]"
                                                 :url="use_url+'/admin/roles/list?where[is_tmp]=1'"
                                                 :keyword-key="'name'"
                                                 :placeholder-value="0"
                                                 :placeholder-show="'请选择模板'"
                                                 :is-ajax="true" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="description" :options="{name: '描述', required: false,type:'textarea'}"  :datas="props"></edit-item>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12" v-show="(props.data.maps['optional_parents'] || []).length">
                            <edit-item key-name="parent_id" :options='{"name": "所属父级选择", "required": true,rules:"required"}' :datas="props">
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
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="_menu_ids" :options='{"name": "是否关联取消权限分配子节点"}' :datas="props">
                                <template slot="input-item">
                                    <el-switch v-model="cancel_children"
                                               :disabled="!props.url"
                                               active-text="是"
                                               inactive-text="否"
                                               :active-value="1"
                                               :inactive-value="0">
                                    </el-switch>
                                </template>
                            </edit-item>
                            <edit-item key-name="menu_ids" :options="{name: '权限分配',rules:'required'}"  :datas="props">
                                <template slot="input-item">
                                    <div>
                                        <ztree v-model="props.data.row['menu_ids']"
                                               :disabled="!props.url || props.data.row['tmp_id']>0 || props.data.row['id']==1"
                                               :id="'menus'"
                                               :chkbox-type='cancel_children?{"Y": "ps", "N": "s"}:{"Y": "ps", "N": ""}'
                                               :data="props.data.maps['permissions']">
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
            "select2":()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),
            "edit-item": ()=>import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
            "ztree":()=>import(/* webpackChunkName: "common_components/ztree.vue" */ 'common_components/ztree.vue'),
            "el-switch": ()=>import(/* webpackChunkName: "element-ui/lib/switch" */ 'element-ui/lib/switch'),
        },
        props: {
        },
        data(){
            return {
                options:{
                    id:'edit', //多个组件同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    params:this.$router.currentRoute.query || {}
                },
                cancel_children:1
            };
        },
        computed:{
            ...mapState([
                'use_url'
            ])
        },
        watch:{
        },
        methods:{
            changeTmp(row,permissions){
                if(row['tmp_id']>0){
                    axios.get(this.use_url+'/admin/role/edit',{params:{'id':row['tmp_id']}}).then( (response)=> {
                        let permission_ids = collect(permissions).pluck('id');
                        let menus = collect(array_get(response,'data.row.menus',[])).filter(function (item) {
                            return permission_ids.contains(item['id']);
                        }).pluck('id').sort().all();
                        row['menu_ids'] = menus;
                    }).catch((error) => {
                    });

                }
            }
        }
    };
</script>
