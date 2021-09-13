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
                            <edit-item key-name="_type" :options="{name: props.transField('Menu type')}" :datas="props">
                                <template slot="input-item">
                                    <label-edit v-model="props.data.row['_type']"
                                                :disabled="!props.url || props.data.row.resource_id>0"
                                                @change="changeType(props.data.row['_type'],props)"
                                                :map="props.maps['_type']">
                                    </label-edit>
                                </template>
                            </edit-item>
                            <edit-item key-name="name"
                                       :options="{name: props.transField('Name'), rules:'required',placeholder:getTitle('name',props)}"
                                       :datas="props">
                            </edit-item>
                            <edit-item key-name="url"
                                       :options="{name: props.transField('Url path'),rules:requiredUrl(props,'url'),placeholder:getTitle('url',props),disabled:props.data.row['resource_id']>1}"
                                       :datas="props">
                            </edit-item>
                            <edit-item key-name="group"
                                       v-if="props.data.row['_type']!=0 && props.data.row['resource_id']<1"
                                       :options="{name: props.transField('Group to which the route belongs'),type:'text',rules:requiredUrl(props,'group'),placeholder:getTitle('group',props)}"
                                       :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['group']"
                                                 :disabled="!props.url"
                                                 :default-options="array_get(props,'data.maps.group',[])"
                                                 :placeholder-value="''"
                                                 :is-ajax="false">
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="item_name"
                                       v-if="props.data.row['resource_id']==-1"
                                       :options="{name: props.transField('Resource Name'),type:'text', rules:'',placeholder:getTitle('item_name',props),title:$tp('Use to generate the name of the subordinate resource, Default is name')}"
                                       :datas="props">
                            </edit-item>
                            <edit-item key-name="action"
                                       :options="{name: props.transField('Binding controller method'),type:'text', rules:'',placeholder:getTitle('action',props),title:$tp('The default recognition is based on the URL')}"
                                       v-show="props.data.row['_type']==2 && props.data.row['resource_id']<1"
                                       :datas="props">
                            </edit-item>
                            <edit-item key-name="as"
                                       v-show="props.data.row['_type']==2 && props.data.row['resource_id']<1"
                                       :options="{name: props.transField('Routing alias'),type:'text', rules:'',placeholder:getTitle('as',props),disabled: props.data.row['resource_id']==-1}"
                                       :datas="props">
                            </edit-item>
                            <edit-item key-name="resource_id"
                                       :options="{name: props.transField('Resources'), rules:'',placeholder:getTitle('resource_id',props)}"
                                       v-show="props.data.row['_type']==2"
                                       :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['resource_id']"
                                                 :default-options="array_get(props,'data.row.resource_id',0)>0?[array_get(props,'data.row.resource')]:[]"
                                                 :url="use_url+'/admin/menus/list'"
                                                 :keyword-key="'name'"
                                                 :disabled="true"
                                                 :placeholder-value="'0'"
                                                 :params="{where:{resource_id:-1}}"
                                                 :show="['name','id']"
                                                 :is-ajax="true">
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="description"
                                       :options='{"name": props.transField("Describe"), "required": false,"type":"textarea",placeholder:getTitle("description",props)}'
                                       :datas="props">
                            </edit-item>
                            <edit-item key-name="plug_in_key"
                                       :options="{name: props.transField('Plug in menu unique ID'),type:'text', rules:'',title:'',disabled:true}"
                                       :datas="props">
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="icons" :options="{name: props.transField('Icon'),title:$tp('Double-click the icon to select it')}" :datas="props">
                                <template slot="input-item">
                                    <icon-edit
                                        v-model="props.data.row['icons']"
                                        :disabled="!props.url"
                                        :placeholder="$tp('Please enter the icon style')">
                                    </icon-edit>
                                </template>
                            </edit-item>
                            <edit-item
                                key-name="method"
                                v-show="props.data.row['resource_id']==-1"
                                :options="{name: props.transField('Resources included'), required: false}"
                                :datas="props">
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.maps['_options']"
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
                                :options="{name: props.transField('Request method'), rules:props.data.row['_type']==2?'required':''}"
                                :datas="props"
                                v-show="props.data.row['_type']!=0"
                            >
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.maps['method']"
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
                            <edit-item key-name="is_page" :options="{name: props.transField('Is it a page'), required: false}" :datas="props">
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.maps['is_page']"
                                             class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
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
                            <edit-item key-name="status" :options="{name: props.transField('State'), required: false}" :datas="props">
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.maps['status']"
                                             class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
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
                                       :options="{name: props.transField('Specify where the route is used'),type:'checkbox', rules:'',title:$tp('Automatic recognition according to API mode when not selected')}"
                                       v-show="props.data.row['_type']!=0"
                                       :datas="props">
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.maps['use']"
                                             class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <icheck v-model="props.data.row['use']" :option="index"
                                                    :disabled="!props.url"> {{item}}
                                            </icheck>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="middleware"
                                       :options="{name: props.transField('Using middleware alone'),type:'text', rules:'',title:''}"
                                       v-show="props.data.row['resource_id']==2" :datas="props">
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.maps['middleware']"
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
                            <edit-item key-name="env" :options="{name: props.transField('Restricted use environment'),type:'text', rules:'',title:''}"
                                       :datas="props">
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.maps['env']"
                                             class="col-lg-4 col-md-4 col-sm-6 col-xs-4">
                                            <icheck v-model="props.data.row['env']" type="radio" :title="item"
                                                    :option="index" :disabled="!props.url"> {{item}}
                                            </icheck>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-4">
                                            <button :title="$t('Empty')"
                                                    type="button"
                                                    :disabled="!props.url"
                                                    class="btn btn-danger btn-xs"
                                                    @click="props.data.row['env']=''">
                                                <i class="fa fa-trash-o"></i> {{$t('Empty')}}
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                           <edit-item key-name="parent_id" :options='{"name": props.transField("Parent selection"), rules:props.data.row.id>1?"required":""}'
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
                "{lang_path}": 'admin.menus',
                modal: false,
                shared: {
                    "{lang_path}": '_shared.menus',
                    '{lang_root}': ''
                },
                options:{
                    lang_table:'menus',
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
                        name: 'For example: Menu settings',//'例如:菜单设置',
                        item_name: 'For example:Menu',//'例如:菜单',
                        url: "For example: will automatically bind to",//'例如:/admin/menus,将自动绑定到Admin\\MenuController',
                        description: 'For example:Menu lists'//'例如:菜单列表'
                    },
                    {
                        name: "For example: background home page",//'例如:后台主页',
                        url:  "For example: admin index",//'例如:/admin/index',
                        description: "For example: background home page",//'例如:后台主页',
                        action:"For example: IndexController@index",//'例如:IndexController@index',
                        as:"For example: admin_index"//'例如:admin_index'
                    }
                ]
            };
        },
        watch: {
            url(val) {
                this.options.url = val;
            },
            '$refs.edit.data'(data){
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
                    row._options = copyObj(props.maps['_options']);
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
                let value = array_get(this.title_map, row._type + '.' + key, '');
                return this.$tp(value);
            },
            getMapName(key,name){
                let _name;
                if(key=='_list'){
                    _name = '{name} pagination';//name+'分页';
                }else if(key=='_show'){
                    _name = 'Edit view {l_name}';//'编辑查看'+name;
                }else if(key=='_create'){
                    _name = 'Create {l_name}';//'创建'+name;
                }else if(key=='_update'){
                    _name = 'Update {l_name}';//'更新'+name;
                }else if(key=='_destroy'){
                    _name = 'Delete {l_name}';//'删除'+name;
                }else if(key=='_export'){
                    _name = 'Export {l_name}';//'导出'+name;
                }else if(key=='_import'){
                    _name = 'Import {l_name}';//'导入'+name;
                }else{
                    _name = 'Delete {l_name}';//'删除'+name;
                }
                let value = array_get(this.$refs['edit'].data.maps._options_name,key,_name);
                let shared = {
                    "{lang_path}": '_shared.menus',
                    '{lang_root}': '',
                    'name':name.toLowerCase().replace(/( |^)[a-z]/g, (L) => L.toUpperCase()),
                    'l_name':name.toLowerCase()
                };
                return this.$tp(value,shared);
            }

        },
        mounted() {
        },
        computed: {
            ...mapState([
                'use_url'
            ]),
            maps_type(){
                return collect(array_get(this.$refs['edit'],'data.maps._type',[])).map((value)=>{
                    this.$tp(value);
                }).all();
            }

        },


    };
</script>
