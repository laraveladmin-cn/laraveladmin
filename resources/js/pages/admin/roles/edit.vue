<template>
    <div class="admin_user_edit">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options" ref="edit">
                    <template slot="content" slot-scope="props">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="name" :options="{name: props.transField('Name'), required: true,rules:'required',disabled:props.data.row['id']==1}"  :datas="props"></edit-item>
                            <edit-item key-name="is_tmp" :options='{"name": props.transField("Set as template"), "type":"select"}' :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['is_tmp']"
                                                 :disabled="!props.url"
                                                 :default-options="props.maps['is_tmp']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="is_tmp" :options='{"name": props.transField("Template selection"), "type":"select"}' :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['tmp_id']"
                                                 @change="changeTmp(props.data.row,props.maps['permissions'])"
                                                 :disabled="!props.url || props.data.row['id']==1"
                                                 :default-options="array_get(props,'data.row.tmp.id',0)?[array_get(props,'data.row.tmp')]:[]"
                                                 :url="use_url+'/admin/roles/list?where[is_tmp]=1'"
                                                 :keyword-key="'name'"
                                                 :placeholder-value="0"
                                                 :is-ajax="true" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="description" :options="{name: props.transField('Describe'), required: false,type:'textarea'}"  :datas="props"></edit-item>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12" v-show="(props.maps['optional_parents'] || []).length">
                            <edit-item key-name="parent_id" :options='{"name": props.transField("Parent selection"), "required": true,rules:"required"}' :datas="props">
                                <template slot="input-item">
                                    <div>
                                        <ztree v-model="props.data.row['parent_id']"
                                               :check-enable="false"
                                               :multiple="false"
                                               :disabled="!props.url"
                                               :id="'parent'"
                                               :chkbox-type='{ "Y" : "", "N" : "" }'
                                               :data="map_optional_parents()">
                                        </ztree>
                                    </div>
                                </template>
                            </edit-item>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="_menu_ids" :options='{"name": props.transField("Whether or not to associate the cancellation privilege assignment child node")}' :datas="props">
                                <template slot="input-item">
                                    <el-switch v-model="cancel_children"
                                               :disabled="!props.url"
                                               :active-text="$t('Yes')"
                                               :inactive-text="$t('No')"
                                               :active-value="1"
                                               :inactive-value="0">
                                    </el-switch>
                                </template>
                            </edit-item>
                            <edit-item key-name="menu_ids" :options="{name: props.transField('Allocation of permissions'),rules:'required'}"  :datas="props">
                                <template slot="input-item">
                                    <div>
                                        <ztree v-model="props.data.row['menu_ids']"
                                               :disabled="!props.url || props.data.row['tmp_id']>0 || props.data.row['id']==1"
                                               :id="'menus'"
                                               :chkbox-type='cancel_children?{"Y": "ps", "N": "s"}:{"Y": "ps", "N": ""}'
                                               :data="map_permissions()">
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
                shared: {
                    "{lang_path}": '_shared.menus',
                    '{lang_root}': ''
                },
                shared_rule_name: {
                    "{lang_path}": '_shared.datas.roles.name',
                    '{lang_root}': ''
                },
                options:{
                    lang_table:'roles',
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
            map_optional_parents(){
                let data = collect(array_get(this.$refs,'edit.data.maps.optional_parents',[])).each((item)=>{
                    if(typeof item._back_name=="undefined"){
                        item._back_name = item.name;
                    }
                    if(item._language!=this._i18n.locale){
                        item._language = this._i18n.locale;
                        item.name = this.$tp(item['_back_name'],this.shared_rule_name);
                    }
                    return item;
                }).all();
                return data;
            },
            map_permissions(){
                let data = collect(array_get(this.$refs,'edit.data.maps.permissions',[])).each((item)=>{
                    if(typeof item._back_name=="undefined"){
                        item._back_name = item.name;
                    }
                    if(item._language!=this._i18n.locale){
                        item._language = this._i18n.locale;
                        item.name = this.translation(item,'_back_name');
                    }
                    return item;
                }).all();
                return data;
            },
            translation(item,key){
                let value = array_get(item,key,'');
                let resource_id = item['resource_id'];
                let res = this.$tp(value , this.shared);
                if(resource_id && res==value && (this._i18n.locale!='en' || value.indexOf('{')!=-1)){ //没有翻译成功
                    let parent_name = array_get(item,'parent.item_name','') || array_get(item,'parent.name','') || '';
                    let key = value.replace(parent_name,'{name}');
                    let shared = copyObj(this.shared);
                    if(key.indexOf('{name}')==0){
                        shared.name=this.$tp(parent_name,shared);
                    }else {
                        key = value.replace(parent_name.toLowerCase(),'{name}');
                        shared.l_name=this.$tp(parent_name,shared);
                        key = key.replace('{name}','{l_name}');
                    }
                    res = this.$tp(key , shared);
                }
                return res;
            },
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
