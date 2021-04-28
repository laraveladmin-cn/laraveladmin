<template>
    <div class="admin_user_edit">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    {{$t('Quickly fill in')}}
                </h3>
            </div>
            <div class="box-body">
                <edit :options="options" ref="edit">
                    <template slot="content" slot-scope="props">
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="_type" :options="{name: '菜单类型'}" :datas="props">
                                <template slot="input-item">
                                    <label-edit v-model="props.data.row['_type']"
                                                :disabled="!props.url || props.data.row.resource_id>0"
                                                @change="changeType(props.data.row['_type'],props)"
                                                :map="props.data.maps['_type']">
                                    </label-edit>
                                </template>
                            </edit-item>
                            <edit-item key-name="name"
                                       :options="{name: '名称', rules:'required',placeholder:getTitle('name',props)}"
                                       :datas="props">
                            </edit-item>
                            <edit-item key-name="url"
                                       :options="{name: 'RUL路径',rules:requiredUrl(props,'url'),placeholder:getTitle('url',props),disabled:props.data.row['resource_id']>1}"
                                       :datas="props">
                            </edit-item>
                            <edit-item key-name="group"
                                       v-if="props.data.row['_type']!=0 && props.data.row['resource_id']<1"
                                       :options="{name: '路由所属组',type:'text',rules:requiredUrl(props,'group'),placeholder:getTitle('group',props)}"
                                       :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['group']"
                                                 :disabled="!props.url"
                                                 :default-options="array_get(props,'data.maps.group',[])"
                                                 :placeholder-show="'请选择'"
                                                 :placeholder-value="''"
                                                 :is-ajax="false">
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="item_name"
                                       v-if="props.data.row['resource_id']==-1"
                                       :options="{name: '资源名称',type:'text', rules:'',placeholder:getTitle('item_name',props),title:'用于生成下级资源名称,不填默认是名称'}"
                                       :datas="props">
                            </edit-item>
                            <edit-item key-name="action"
                                       :options="{name: '绑定控制器方法',type:'text', rules:'',placeholder:getTitle('action',props),title:'默认根据URL进行识别'}"
                                       v-show="props.data.row['_type']==2 && props.data.row['resource_id']<1"
                                       :datas="props">
                            </edit-item>
                            <edit-item key-name="as"
                                       v-show="props.data.row['_type']==2 && props.data.row['resource_id']<1"
                                       :options="{name: '路由别名',type:'text', rules:'',placeholder:getTitle('as',props),disabled: props.data.row['resource_id']==-1}"
                                       :datas="props">
                            </edit-item>
                            <edit-item key-name="resource_id"
                                       :options="{name: '所属资源', rules:'',placeholder:getTitle('resource_id',props)}"
                                       v-show="props.data.row['_type']==2"
                                       :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['resource_id']"
                                                 :default-options="array_get(props,'data.row.resource_id',0)>0?[array_get(props,'data.row.resource')]:[]"
                                                 :url="use_url+'/admin/menus/list'"
                                                 :keyword-key="'name'"
                                                 :disabled="true"
                                                 :placeholder-show="'请选择所属资源'"
                                                 :placeholder-value="'0'"
                                                 :params="{where:{resource_id:-1}}"
                                                 :show="['name','id']"
                                                 :is-ajax="true">
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="description"
                                       :options='{"name": "描述", "required": false,"type":"textarea",placeholder:getTitle("description",props)}'
                                       :datas="props">
                            </edit-item>
                            <edit-item key-name="plug_in_key"
                                       :options="{name: '插件菜单唯一标识',type:'text', rules:'',title:'',disabled:true}"
                                       :datas="props">
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="icons" :options="{name: '图标',title:'双击图标即可选中'}" :datas="props">
                                <template slot="input-item">
                                    <icon-edit
                                        v-model="props.data.row['icons']"
                                        :disabled="!props.url"
                                        :placeholder="'请输入图标样式'">
                                    </icon-edit>
                                </template>
                            </edit-item>
                            <edit-item
                                key-name="method"
                                v-show="props.data.row['resource_id']==-1"
                                :options="{name: '包含资源', required: false}"
                                :datas="props">
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.data.maps['_options']"
                                             class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <icheck v-model="props.data.row['_options']"
                                                    :title="getMapName(item,props.data.row['item_name'])"
                                                    :option="item"
                                                    :disabled="!props.url">
                                                {{getMapName(item,props.data.row['item_name'] || props.data.row['name'])}}
                                            </icheck>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item
                                key-name="method"
                                :options="{name: '请求方式', rules:props.data.row['_type']==2?'required':''}"
                                :datas="props"
                                v-show="props.data.row['_type']!=0"
                            >
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.data.maps['method']"
                                             class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <icheck v-model="props.data.row['method']"
                                                    :title="item"
                                                    :option="index"
                                                    :disabled="!props.url || props.data.row['resource_id']==-1 || props.data.row['resource_id']>0">
                                                {{item}}
                                            </icheck>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="is_page" :options="{name: '是否为页面', required: false}" :datas="props">
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.data.maps['is_page']"
                                             class="col-lg-3 col-md-3 col-sm-3 col-xs-2">
                                            <icheck v-model="props.data.row['is_page']"
                                                    type="radio"
                                                    :option="index"
                                                    :title="item"
                                                    :disabled="!props.url || props.data.row['resource_id']>0"> {{item}}
                                            </icheck>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="status" :options="{name: '状态', required: false}" :datas="props">
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.data.maps['status']"
                                             class="col-lg-4 col-md-4 col-sm-4 col-xs-3">
                                            <icheck v-model="props.data.row['status']"
                                                    type="radio"
                                                    :option="index"
                                                    :title="item"
                                                    :disabled="!props.url || props.data.row['resource_id']>0">
                                                {{item}}
                                            </icheck>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="use"
                                       :options="{name: '指定路由使用地方',type:'checkbox', rules:'',title:'不选时根据API模式自动识别'}"
                                       v-show="props.data.row['_type']!=0"
                                       :datas="props">
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.data.maps['use']"
                                             class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <icheck v-model="props.data.row['use']" :option="index"
                                                    :disabled="!props.url"> {{item}}
                                            </icheck>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="middleware"
                                       :options="{name: '单独使用中间件',type:'text', rules:'',title:''}"
                                       v-show="props.data.row['resource_id']==2" :datas="props">
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.data.maps['middleware']"
                                             class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <icheck v-model="props.data.row['middleware']" :option="index"
                                                    :title="item"
                                                    :disabled="!props.url || props.data.row['resource_id']==-1">
                                                {{item}}
                                            </icheck>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="env" :options="{name: '限制使用环境',type:'text', rules:'',title:''}"
                                       :datas="props">
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.data.maps['env']"
                                             class="col-lg-4 col-md-4 col-sm-6 col-xs-4">
                                            <icheck v-model="props.data.row['env']" type="radio" :title="item"
                                                    :option="index" :disabled="!props.url"> {{item}}
                                            </icheck>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-4">
                                            <button title="清除"
                                                    type="button"
                                                    :disabled="!props.url"
                                                    class="btn btn-danger btn-xs"
                                                    @click="props.data.row['env']=''">
                                                <i class="fa fa-trash-o"></i>清除
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                           <edit-item key-name="parent_id" :options='{"name": "所属父级选择", rules:props.data.row.id>1?"required":""}'
                                       :datas="props">
                                <template slot="input-item">
                                    <div>
                                        <ztree v-model="props.data.row['parent_id']"
                                               :check-enable="false"
                                               :multiple="false"
                                               :disabled="!props.url || props.data.row['resource_id']>0"
                                               :id="'menus_edit_parent'"
                                               :chkbox-type='{ "Y" : "", "N" : "" }'
                                               :data="map_optional_parents()">
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
        components: {
            'edit': () => import(/* webpackChunkName: "common_components/edit.vue" */ 'common_components/edit.vue'),
            "edit-item": () => import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
            "icheck": () => import(/* webpackChunkName: "common_components/icheck.vue" */ 'common_components/icheck.vue'),
            "ztree": () => import(/* webpackChunkName: "common_components/ztree.vue" */ 'common_components/ztree.vue'),
            "iconEdit": () => import(/* webpackChunkName: "common_components/iconEdit.vue" */ 'common_components/iconEdit.vue'),
            "select2": () => import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),
            "labelEdit": () => import(/* webpackChunkName: "common_components/labelEdit.vue" */ 'common_components/labelEdit.vue'),
        },
        props: {
            url: {
                type: [String],
                default: function () {
                    return '';
                }
            },
            noBack: {
                type: [Boolean],
                default: function () {
                    return false;
                }
            },
            callback: {
                type: [Function],
                default: function () {
                    return function () {
                    };
                }
            },
        },
        data() {
            return {
                modal: false,
                shared: {
                    "{lang_path}": '_shared.menus',
                    '{lang_root}': ''
                },
                options: {
                    id: 'edit', //多个组件同时使用时唯一标识
                    url: this.url || '', //数据表请求数据地址
                    params: {},
                    no_back: this.noBack,
                    callback:(response,row)=>{ //修改成功
                        this.getMenus();
                        this.callback();
                    }
                },
                title_map: [
                    {},
                    {
                        name: '例如:菜单设置',
                        item_name: '例如:菜单',
                        url: '例如:/admin/menus,将自动绑定到Admin\\MenuController',
                        description: '例如:菜单列表'
                    },
                    {
                        name: '例如:后台主页',
                        url: '例如:/admin/index',
                        description: '例如:后台主页',
                        action:'例如:IndexController@index',
                        as:'例如:admin_index'
                    }
                ]
            };
        },
        watch: {
            url(val) {
                this.options.url = val;
            },
            '$refs.edit.data'(data){
                dd(data);
            }
        },
        methods: {
            ...mapActions({
                getMenus:'menu/getMenus', //更新菜单
            }),
            map_optional_parents(){
                let data = collect(array_get(this.$refs,'edit.data.maps.optional_parents',[])).each((item)=>{
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
            openModal() {
                this.modal = true;
            },
            requiredUrl(props,key) {
                let row = props.data.row;
                if (row['resource_id'] == -1 || row._type==2) {
                    return 'required';
                }
                return '';
            },
            changeType(val, props) {
                let row = props.data.row;
                if (val == 1) { //资源路由
                    row.resource_id = -1; //资源路由标记
                    row.method = [1];
                    row.as = '';
                    row.middleware = [];
                    row.action = '';
                    row.is_page = 1;
                    row.status = 1;
                    row._options = copyObj(props.data.maps['_options']);
                } else if(val == 0){ //普通链接
                    row.resource_id = 0;
                    row.method = [];
                    row.group = '';
                    row.action = '';
                    row.use = [];
                    row.as = '';
                    row.middleware=[];
                    row.is_page = 0;
                    row.item_name = '';
                }else if(val == 2){ //单独路由
                    row.resource_id = 0;
                    row.method = [1];
                    row.item_name = '';
                }
            },
            getTitle(key, props) {
                let row = props.data.row;
                return array_get(this.title_map, row._type + '.' + key, '');
            },
            getMapName(key,name){
                let _name;
                if(key=='_list'){
                    _name = name+'分页';
                }else if(key=='_show'){
                    _name = '编辑查看'+name;
                }else if(key=='_create'){
                    _name = '创建'+name;
                }else if(key=='_update'){
                    _name = '更新'+name;
                }else if(key=='_destroy'){
                    _name = '删除'+name;
                }else if(key=='_export'){
                    _name = '导出'+name;
                }else if(key=='_import'){
                    _name = '导入'+name;
                }else{
                    _name = '删除'+name;
                }
                return array_get(this.$refs['edit'].data.maps._options_name,key,_name);
            }

        },
        mounted() {
        },
        computed: {
            ...mapState([
                'use_url'
            ]),

        },


    };
</script>
