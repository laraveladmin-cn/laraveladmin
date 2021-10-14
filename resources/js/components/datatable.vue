<template>
    <div :id="id">
        <div class="data-table">
            <div class="box-header sizer">
                <slot name="header" :data="data" :maps="_maps"></slot>
                <slot name="sizer"
                      :data="data"
                      :ids="check_ids"
                      :checkbox="checkbox"
                      :check_ids="check_ids"
                      :refresh="refresh"
                      :remove="remove"
                      :sizer_more="sizer_more"
                      :id="id"
                      :show_export_fields="show_export_fields"
                      :trans-field="transField"
                      :search="search"
                      :reset="reset"

                >
                    <div class="row sizer-row">
                        <div class="col-md-6 col-sm-12 col-xs-12 sizer-item" :class="{'col-lg-7':options.keywordGroup,'col-lg-8':!options.keywordGroup}">
                            <slot name="add" :url="data.configUrl['createUrl']?data.configUrl['createUrl']+'/0':''">
                                <router-link :to="data.configUrl['createUrl']+'/0'" class="btn btn-info" v-if="data.configUrl['createUrl']">
                                    <i class="fa fa-plus"></i> {{$t("New")}}
                                </router-link>
                            </slot>
                            <slot name="refresh">
                                <button class="btn btn-success"
                                        v-show="btnRefresh"
                                        type="button"
                                        @click="refresh">
                                    <i class="fa fa-refresh"></i> {{$t("Refresh")}}
                                </button>
                            </slot>
                            <button class="btn btn-danger"
                                    type="button"
                                    @click="remove(check_ids)"
                                    v-show="checkbox && data.configUrl['deleteUrl']">
                                <i class="fa fa-trash-o"></i> {{$t("Delete selected")}}
                            </button>
                            <button class="btn btn-primary"
                                    type="button"
                                    v-show="btnSizerMore"
                                    @click="sizer_more = !sizer_more"
                                    data-toggle="collapse"
                                    :data-target="'#'+id+' .sizer_more'"
                                    aria-expanded="false">
                                <i class="fa" :class="sizer_more?'fa-angle-double-up':'fa-angle-double-down'"></i>
                                {{$t("More screening")}}
                            </button>
                            <button class="btn btn-warning"
                                    type="button"
                                    v-show="count(data.excel.exportFields) && data.configUrl['exportUrl']"
                                    @click="show_export_fields = !show_export_fields"
                                    data-toggle="collapse"
                                    :data-target="'#'+id+' .export_excel'"
                                    aria-expanded="false">
                                <i class="fa" :class="show_export_fields?'fa-angle-double-up':'fa-angle-double-down'"></i>
                                {{$t("Export fields")}}
                            </button>
                            <button type="button" :title="$t('Import data')" class="btn btn-primary import" @click="importExcel" v-show="data.configUrl['importUrl']">
                                <i class="fa fa-folder-open-o"></i>
                                {{$t("Bulk import")}}
                                <input type="file" @change="selectExcel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" v-show="false" />
                            </button>
                            <slot name="add_btn"></slot>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 sizer-item pull-right hidden-xs hidden-sm" :class="{'col-lg-5':options.keywordGroup,'col-lg-4':!options.keywordGroup}">
                            <div class="box-tools">
                                <div class="input-group">
                                    <div class="input-group-btn" v-if="options.keywordGroup">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{$tp(data.keywordsMap[data.options.where['_key']])}}
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li v-for="(value,index) in data.keywordsMap" @click="changeKeywords(index)">
                                                <a>{{$tp(value)}}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <input v-if="options.keywordGroup" @keyup.enter="search" v-model="data.options.where[data.options.where['_key']]" :placeholder="_placeholder" class="form-control"  type="text">
                                    <input v-else @keyup.enter="search"  v-model="data.options.where[options.keywordKey]" :placeholder="_placeholder" type="text" class="form-control">
                                    <div class="input-group-btn">
                                        <button type="button" :title="$t('Search')" class="btn btn-primary" @click="search">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <button type="button" :title="$t('Reset')" class="btn btn-primary " @click="reset">
                                            <i class="fa fa-repeat"></i>
                                        </button>
                                        <!--  <button type="button" title="导入数据" class="btn btn-primary import" @click="importExcel" v-show="data.configUrl['importUrl']">
                                              <i class="glyphicon glyphicon-folder-open"></i>
                                              <input type="file" @change="selectExcel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" v-show="false"></input>
                                          </button>-->
                                        <button type="button" :title="$t('Export data')" class="btn btn-primary" @click="download" v-if="data.configUrl['exportUrl']">
                                            <i class="glyphicon glyphicon-download-alt"></i>
                                        </button>
                                        <slot name="input_group_add_btn" :data="data"></slot>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </slot>
                <div class="collapse export_excel row">
                    <slot name="export-excel">
                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6" v-for="(field,key) in data.excel.exportFields">
                            <icheck v-model="export_fileds" :option="key">{{transField(field,key)}}</icheck>
                        </div>
                    </slot>
                </div>
                <div class="collapse sizer_more in">
                    <slot name="sizer-more" :data="data" :where="data.options.where" :maps="_maps"  :trans-field="transField">
                    </slot>
                    <div class="row hidden-md hidden-lg">
                        <div class="col-md-6 col-sm-12 col-xs-12 sizer-item" :class="{'col-lg-5':options.keywordGroup,'col-lg-4':!options.keywordGroup}">
                            <div class="box-tools">
                                <div class="input-group">
                                    <div class="input-group-btn" v-if="options.keywordGroup">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{$tp(data.keywordsMap[data.options.where['_key']])}}
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li v-for="(value,index) in data.keywordsMap" @click="changeKeywords(index)">
                                                <a>{{$tp(value)}}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <input v-if="options.keywordGroup" @keyup.enter="search" v-model="data.options.where[data.options.where['_key']]" :placeholder="_placeholder" class="form-control"  type="text">
                                    <input v-else @keyup.enter="search"  v-model="data.options.where[options.keywordKey]" :placeholder="_placeholder" type="text" class="form-control">
                                    <div class="input-group-btn">
                                        <button type="button" :title="$t('Search')" class="btn btn-primary" @click="search">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <button type="button" :title="$t('Reset')" class="btn btn-primary " @click="reset">
                                            <i class="fa fa-repeat"></i>
                                        </button>
                                        <!--  <button type="button" title="导入数据" class="btn btn-primary import" @click="importExcel" v-show="data.configUrl['importUrl']">
                                              <i class="glyphicon glyphicon-folder-open"></i>
                                              <input type="file" @change="selectExcel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" v-show="false"></input>
                                          </button>-->
                                        <button type="button" :title="$t('Export data')" class="btn btn-primary" @click="download" v-if="data.configUrl['exportUrl']">
                                            <i class="glyphicon glyphicon-download-alt"></i>
                                        </button>
                                        <slot name="input_group_add_btn" :data="data"></slot>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-show="btnSizerMore">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <button type="button" class="btn btn-primary pull-right sizer-tool-btn" @click="search">{{$t('Search')}}</button>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pull-left">
                            <button type="button" class="btn btn-default sizer-tool-btn" @click="reset">{{$t('Reset')}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer box-footer-top clearfix pager-tool" v-if="!options.hideTopPagerTool">
                <slot name="pager" :data="data">
                    <div class="row">
                        <div class="col-lg-12">
                            <span class="count m-top">
                                {{$tc('Article {number}',_total,{number:_total})}}
                                <el-select v-model="input_per_page" size="mini" class="per_page" @change="perPage" :placeholder="input_per_page+''">
                                    <el-option v-for="per_page in perPageOptions" :key="per_page" :label="per_page+''" :value="per_page"></el-option>
                                </el-select>
                                {{$tc('{number} items per page',input_per_page,{number:input_per_page})}}
                            </span>
                            <span class="pager-input pull-right m-top">&nbsp;&nbsp;&nbsp;&nbsp;{{$t('Skip to')}}&nbsp;&nbsp;
                                <el-input-number v-model.number="input_page" size="mini" controls-position="right" @change="changePage" :min="1" :max="data.list['last_page'] || 1" class="topage1" ></el-input-number>
                                &nbsp;&nbsp;{{$t('page(jump)')}}
                            </span>
                            <ul class="pagination pagination-sm no-margin pull-right m-top">
                                <li :class="{ disabled: data.list['current_page']<=1 }">
                                    <a aria-label="Previous" @click="toPage(data.list['current_page']-1)">
                                        <span aria-hidden="true">{{$t('Previous')}}</span>
                                    </a>
                                </li>
                                <li v-show="data.list['current_page']>(pageLength+1)">
                                    <a @click="toPage(1)">1</a>
                                </li>
                                <li v-for="v in pageLength" v-show="data.list['current_page']-pageLength+v-1>0">
                                    <a @click="toPage(data.list['current_page']-pageLength+v-1)">{{data.list['current_page']-pageLength+v-1}}</a>
                                </li>
                                <li class="active">
                                    <a>{{data.list['current_page'] || 1}}</a>
                                </li>
                                <li v-for="v in pageLength" v-show="data.list['current_page']+v<=data.list['last_page']">
                                    <a @click="toPage(data.list['current_page']+v)">{{data.list['current_page']+v}}</a>
                                </li>
                                <li v-show="data.list['current_page']+pageLength<data.list['last_page']">
                                    <a @click="toPage(data.list['last_page'])">{{data.list['last_page']}}</a>
                                </li>
                                <li :class="{ disabled: data.list['current_page']==data.list['last_page'] }">
                                    <a aria-label="Next" @click="toPage(data.list['current_page']+1)">
                                        <span aria-hidden="true">{{$t('Next')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </slot>
            </div>
            <div class="box-body table-responsive">
                <slot name="table" :data="data" :check_ids="check_ids" :remove="remove">
                    <table class="table table-hover table-bordered table-striped text-center dataTable">
                        <thead>
                        <slot name="thead"
                              :select-all="select_all"
                              :operation="operation"
                              :trans-field="transField"
                              :checkbox="checkbox"
                              :select-all-method="selectAll"
                              :order-by-method="orderBy"
                              :order-by="orderBy"
                              :show-fields="show_fields">
                            <tr>
                                <th class="id" v-if="checkbox">
                                    <!-- <input type="checkbox" v-model="select_all" @click="selectAll" :value="1">-->
                                    <icheck v-model="select_all" @change="selectAll" :option="1" :disabled-label="true"></icheck>
                                </th>
                                <th v-for="(field,index) in show_fields" :class="field['class']" @click="orderBy(index)">
                                    {{transField(field.name,index)}}
                                </th>
                                <slot name="thead-operate" :operation="operation">
                                    <th class="operate" v-if="operation">{{$t('Operation')}}</th>
                                </slot>
                            </tr>
                        </slot>
                        </thead>
                        <tbody>
                        <tr v-for="(row,i) in (data.list?data.list.data:[])">
                            <td v-if="checkbox">
                                <!--<input type="checkbox" v-model="check_ids" :value="row[options.primaryKey]" />-->
                                <slot name="col-checkbox" :check_ids="check_ids" :data="data" :row="row">
                                    <icheck v-model="check_ids" :option="row[options.primaryKey]" class="ids" :disabled-label="true"></icheck>
                                </slot>
                            </td>
                            <td v-for="(field,k) in show_fields" :class="field['class']">
                                <slot name="col" :field="field" :data="data" :maps="_maps" :row="row" :k="k" :getItems="getItems" :checkboxClass="checkboxClass" :labelClass="labelClass">
                                        <span v-if="field.type =='label' || field.type =='radio'">
                                            <span class="label" :class="labelClass(row,k)">
                                                {{ _maps | array_get(k,[]) | array_get(array_get(row,k,0)) }}
                                            </span>
                                        </span>
                                    <span v-else-if="field.type =='labels' || field.type =='checkbox'">
                                            <span v-for="value in getItems(row,k)" class="label labels-m" :class="checkboxClass(value,2,statusClass,k)">
                                                {{ _maps | array_get(k.replace('.$index','')) | array_get(value) }}
                                            </span>
                                        </span>
                                    <span v-else-if="field.type =='icon'">
                                                  <i class="fa" :class="array_get(row,k,'')"></i>
                                        </span>
                                    <span v-else-if="field.type =='color'">
                                            <span class="input-group-addon1" style="border: none">
                                                <i style="background-color:transparent;" v-if="!array_get(row,k,'')"></i>
                                                <i :style="'background-color:'+array_get(row,k,'')" v-else></i>
                                            </span>
                                        </span>
                                    <span v-else-if="field.type =='level'">
                                            {{ row[field.levelName || 'level'] | deep}}
                                             <span v-if="field.limit" :title="array_get(row,k,'')">
                                                 {{row | array_get(k) | str_limit(field.limit)}}
                                             </span>
                                            <span v-else>
                                                  {{row | array_get(k)}}
                                            </span>
                                        </span>
                                    <span v-else-if="field.type =='code'">
                                            <code v-if="field.limit">
                                                {{row | array_get(k) | str_limit(field.limit)}}
                                            </code>
                                            <code v-else>
                                                  {{row | array_get(k)}}
                                            </code>
                                        </span>
                                        <span v-else-if="field.type =='pre'">
                                            <pre v-if="field.limit">
                                                {{row | array_get(k) | str_limit(field.limit)}}
                                            </pre>
                                            <pre v-else>
                                                  {{row | array_get(k)}}
                                            </pre>
                                        </span>
                                        <span v-else>
                                             <span v-if="field.limit" :title="array_get(row,k,'')">
                                                   {{row | array_get(k) | str_limit(field.limit)}}
                                             </span>
                                            <span v-else>
                                                     {{row | array_get(k)}}
                                            </span>
                                        </span>
                                </slot>
                            </td>
                            <td class="operate" v-if="operation">
                                <slot name="col-operation" :data="data" :row="row" :remove="remove">
                                    <button v-show="data.configUrl['deleteUrl']" :title="$t('Delete selected')" type="button" class="btn btn-danger btn-xs" @click="remove([row[options.primaryKey]])">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    <router-link class="btn btn-info btn-xs" :title="$t('Edit')"  :to="data.configUrl['showUrl'].replace('{id}',row[options.primaryKey])" v-if="data.configUrl['showUrl']">
                                        <i class="fa fa-edit"></i>
                                    </router-link>
                                </slot>
                            </td>
                        </tr>
                        <tr v-show="is_empty">
                            <td :colspan="col_num" class="empty">
                                {{$t('Temporarily no data')}}
                            </td>
                        </tr>
                        </tbody>
                        <tfoot >
                        <tr class="loading" v-if="loading">
                            <td colspan="6" class="overlay">
                                <div class="fa">
                                    <i class="fa fa-refresh fa-spin"></i>
                                    <div class="explain">
                                        {{$t('Loading')}}...
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </slot>
            </div>
            <div class="box-footer clearfix pager-tool" v-if="!options.hideBottomPagerTool">
                <slot name="pager" :data="data">
                    <div class="row">
                        <div class="col-lg-12">
                            <span class="count m-top">
                                {{$tc('Article {number}',_total,{number:_total})}}
                                <el-select v-model="input_per_page" size="mini" class="per_page" @change="perPage" :placeholder="input_per_page+''">
                                    <el-option v-for="per_page in perPageOptions" :key="per_page" :label="per_page+''" :value="per_page"></el-option>
                                </el-select>
                                {{$tc('{number} items per page',input_per_page,{number:input_per_page})}}
                            </span>
                            <span class="pager-input pull-right m-top">&nbsp;&nbsp;&nbsp;&nbsp;{{$t('Skip to')}}&nbsp;&nbsp;
                                <el-input-number v-model.number="input_page" size="mini" controls-position="right" @change="changePage" :min="1" :max="data.list['last_page'] || 1" class="topage1" ></el-input-number>
                                &nbsp;&nbsp;{{$t('page(jump)')}}
                            </span>
                            <ul class="pagination pagination-sm no-margin pull-right m-top">
                                <li :class="{ disabled: data.list['current_page']<=1 }">
                                    <a aria-label="Previous" @click="toPage(data.list['current_page']-1)">
                                        <span aria-hidden="true">{{$t('Previous')}}</span>
                                    </a>
                                </li>
                                <li v-show="data.list['current_page']>(pageLength+1)">
                                    <a @click="toPage(1)">1</a>
                                </li>
                                <li v-for="v in pageLength" v-show="data.list['current_page']-pageLength+v-1>0">
                                    <a @click="toPage(data.list['current_page']-pageLength+v-1)">{{data.list['current_page']-pageLength+v-1}}</a>
                                </li>
                                <li class="active">
                                    <a>{{data.list['current_page'] || 1}}</a>
                                </li>
                                <li v-for="v in pageLength" v-show="data.list['current_page']+v<=data.list['last_page']">
                                    <a @click="toPage(data.list['current_page']+v)">{{data.list['current_page']+v}}</a>
                                </li>
                                <li v-show="data.list['current_page']+pageLength<data.list['last_page']">
                                    <a @click="toPage(data.list['last_page'])">{{data.list['last_page']}}</a>
                                </li>
                                <li :class="{ disabled: data.list['current_page']==data.list['last_page'] }">
                                    <a aria-label="Next" @click="toPage(data.list['current_page']+1)">
                                        <span aria-hidden="true">{{$t('Next')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </slot>
            </div>
            <slot name="end" :data="data"></slot>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations, mapGetters} from 'vuex';
    export default {
        name: "datatable",
        components:{
            "icheck":()=>import(/* webpackChunkName: "common_components/icheck.vue" */ 'common_components/icheck.vue'),
            "el-select": ()=>import(/* webpackChunkName: "element-ui/lib/select" */ 'element-ui/lib/select'),
            "el-option": ()=>import(/* webpackChunkName: "element-ui/lib/option" */ 'element-ui/lib/option'),
            "el-input-number": ()=>import(/* webpackChunkName: "element-ui/lib/input-number" */ 'element-ui/lib/input-number'),
        },
        props: {
            //配置选项
            options:{
                type: [Object],
                default: function () {
                    return {};
                }
            }
        },
        data(){
            let langPath = this.options.langPath || {};
            return {
                ...langPath,
                show_shade:false,
                sizer_more:false, //更多筛选条件显示隐藏
                loading:false, //数据加载中状态
                initLoading:true, //初始化加载状态
                show_export_fields:false, //导出字段按钮显示状态
                data:{
                    options:{
                        where:{},
                        order:{}
                    },
                    maps:{
                    },
                    list:{},
                    configUrl:{
                        indexUrl:'',
                        listUrl:'',
                        showUrl:'',
                        exportUrl:'',
                        deleteUrl:'',
                        createUrl:'',
                        updateUrl:'',
                        importUrl:''
                    },
                    keywordsMap:{},
                    excel:{
                        sheet:'',
                        fileName:'',
                        exportFields:{}
                    },
                    mapsRelations:{}
                }, //数据源
                back_options:undefined, //筛选条件+排序备份
                affirm_options:undefined, //执行搜索后确认选项
                export_fileds:null, //导出excel字段
                check_ids:[], //选中id
                select_all:[], //全选
                pageLength:2, //当前页面前后长度
                input_page:'', //输入页码
                keywordKey:'',
                check_ids_change:false,
                options_str:'',
                per_page_options:[10,15,20,30,50,100,200],
                input_per_page:15
            };
        },
        methods:{
            //消息提醒
            ...mapActions({
                pushMessage: 'pushMessage',
                downloadExcel:'excel/download', //导出数据
                importData:'excel/importExcel'//导入数据

            }),
            //全局数据设置,设置弹窗提示
            ...mapMutations({
                set:'set'
            }),
            transField(name,key,table){
                let sheet = array_get(this.data,'excel.sheet','');
                if(!this.options.lang_table && !sheet){
                    return name;
                }
                if(!table){
                    if(!key || key.indexOf('.')==-1){
                        table = this.options.lang_table || sheet;
                    }else {
                        let arr = key.replace('.$index','').split('.');
                        arr.pop();
                        let key1 = arr.join('.');
                        let table1 = arr.pop();
                        let d=table1.length-1;
                        if(!(d>=0 && table1.lastIndexOf('s')==d)){
                            table1 = table1+'s'
                        };
                        table = array_get(this.data,'mapsRelations.'+key1,'') || table1;
                    }
                }
                return this.$tp(name,{
                    "{lang_path}": '_shared.tables.'+table+'.fields',
                    '{lang_root}': ''
                });
            },
            transMap(name,field,table){
                let sheet = array_get(this.data,'excel.sheet','');
                if(!this.options.lang_table && !sheet){
                    return name;
                }
                if(!table){
                    table = this.options.lang_table || sheet;
                }
                return this.$tp(name,{
                    "{lang_path}": '_shared.tables.'+table+'.maps.'+field,
                    '{lang_root}': ''
                });
            },
            mapEach(maps,field,table,prefix){
                maps = collect(maps).map((value,key)=>{
                    if(value && typeof value=="string"){
                        return this.transMap(value,field,table);
                    }else if(value && typeof value=="object"){
                        let key1 = prefix ? prefix+'.'+key:key;
                        let table1 = array_get(this.data,'mapsRelations.'+key1,'');
                        return this.mapEach(value,key,table1 || table,key1);
                    }else {
                        return value;
                    }
                }).all();
                return maps;
            },
            getItems(item,key){
                if(key.indexOf('$index')!=-1){
                    let keys = key.split('.$index.');
                    return array_get(item,keys[0],[]);
                }
                return array_get(item,key,[]);

            },
            labelClass(item,key){
                let val = array_get(item,key,0);
                return  'label-'+this.statusClass[val%this.statusClass.length];
            },
            count(items){
                return collect(items).count();
            },
            //条件搜索
            search(){
                //当前筛选条件
                let options = copyObj(this.data.options);
                this.getData(options);
                this.$emit('search',options);
            },
            //重置筛选
            reset(){
                let options = copyObj(this.back_options);
                this.data.options = options;
                this.getData(options);
                this.$emit('reset',options);
            },
            //跳转到对应页面
            toPage(page,perPage){
                let per_page = perPage || this.data.list.per_page || 15;
                if((page>0 && page<=this.data.list['last_page'] && page!=this.data.list['current_page']) || per_page!=this.data.list.per_page){
                    let options = copyObj(this.affirm_options);
                    options['page'] = page;
                    options['per_page'] = per_page;
                    if(per_page!=this.data.list.per_page){
                        options['page']=1;
                    }
                    delete options['get_count'];
                    this.getData(options);
                }
            },
            //刷新数据列表
            getData(options,flog){
                if(this.loading){
                    return false;
                }
                //过滤为空的数据
                if(options.where){
                    options.where = collect(options.where).filter((value)=>{
                        return value!=='';
                    }).all();
                }
                options = copyObj(options);
                this.loading = true;
                let options_str = JSON.stringify(options);
                this.options_str = options_str;
                let url = this.data.configUrl['listUrl'] || this.options.url || this.$router.currentRoute.path;
                axios.get(this.use_url+url,{params:options}).then( (response)=> {
                    this.data.options.order = copyObj(options.order || {});
                    if(url==this.data.configUrl['listUrl']){
                        for (let i in response.data ) {
                            Vue.set(this.data.list,i,response.data[i]);
                        }
                        //添加历史记录
                        if(!options['get_count'] && !flog){
                            let query = copyObj(this.$route.query);
                            query[this.options_key] = options_str;
                            this.$router.push({ path: this.$router.currentRoute.path, query: query}).catch(()=>{});
                        }
                    }else {
                        for (let i in response.data ) {
                            Vue.set(this.data,i,response.data[i]);
                        }
                        if(this.count(this.data.excel.exportFields) && !this.export_fileds){
                            if(this.options.defaultExportNotAll){
                                this.export_fileds = [];
                            }else {
                                this.export_fileds = collect(this.data.excel.exportFields).keys().all();
                            }
                        }else if(!this.export_fileds){
                            this.export_fileds = [];
                        }
                    }
                    this.input_page = this.data.list['current_page'];
                    this.input_per_page = this.data.list['per_page'];
                    this.initLoading = false;
                    this.loading = false;
                    if(typeof(this.back_options) == "undefined"){
                        this.back_options = copyObj(response.data.options); //筛选条件+排序备份
                        this.affirm_options = copyObj(response.data.options); //筛选条件+排序备份
                    }else {
                        this.affirm_options = options;
                    }
                    this.select_all = [];
                    this.check_ids = [];

                }).catch((error) => {
                    this.initLoading = false;
                    this.loading = false;
                });

            },
            //删除数据
            remove(ids){
                if(!ids.length){
                    return false;
                }
                this.set({
                    key:'modal',
                    modal:{
                        title:this.$t('Prompt'),
                        content: this.$t('Are you sure you want to delete it?'),
                        callback:()=>{
                            axios.delete(this.use_url+this.data.configUrl['deleteUrl'], {data:{ids: ids}}).then((response)=>{
                                this.refresh();
                                if(typeof this.options.removeCallback=="function"){
                                    this.options.removeCallback();
                                }
                            }).catch((error)=>{
                                this.pushMessage({
                                    'showClose':true,
                                    'title':this.$t('{action} failed!',{action:this.$t('Delete')}),
                                    'message':'',
                                    'type':'danger',
                                    'position':'top',
                                    'iconClass':'fa-warning',
                                    'customClass':'',
                                    'duration':3000,
                                    'show':true
                                });
                            });
                        }}
                });
            },
            //刷新
            refresh(){
                let options = copyObj(this.affirm_options);
                options['page'] = this.data.list['current_page'];
                options['get_count'] = 1;
                this.getData(options);
            },
            selectAll(){
                if(this.check_ids_change){
                    this.check_ids_change = false;
                    return;
                }
                if(this.select_all.length){
                    let ids = collect(array_get(this.data,'list.data',[])).pluck(this.options.primaryKey||'id').all();
                    let ids1 = [];
                    $('.ids :checkbox[disabled=disabled]').each(function(){
                        ids1.push($(this).val()-0);
                    });
                    //过滤禁用选项
                    this.check_ids = collect(ids).diff(ids1).all();
                }else {
                    this.check_ids = [];
                }
            },
            orderBy(key){
                let item = this.options.fields[key];
                let key1 = item.orderField || key;
                if(item['order']){
                    let order = {};
                    if(this.affirm_options.order[key1]=='asc'){
                        order[key1] = 'desc';
                    }else {
                        order[key1] = 'asc';
                    }
                    let options = copyObj(this.affirm_options);
                    collect(options.order).map((item,k)=>{
                        if(k!=key1){
                            order[k]=item;
                        }
                    }).all();
                    options.order = order;
                    options.page = 1;
                    this.getData(options);
                }
            },
            changePage(value){
                let val = (value+'').trim();
                if(/^[1-9]\d*$|^$/.test(val) && val>=1 && val<=this.data.list['last_page']) { //页面输入正确
                    this.toPage(val);
                } else {
                    this.input_page = this.data.list['current_page'];
                }
            },
            perPage(value){
                this.toPage(1,value);
            },
            changeKeywords(index){
                this.data.options.where[this.data.options.where['_key']]='';
                this.data.options.where['_key']=index;
            },
            //下载excel数据
            download(){
                if(!this.export_fileds.length && this.count(this.data.excel.exportFields)){
                    this.set({
                        key:'modal',
                        modal:{
                            title:this.$t('Prompt'),//'提示',
                            content: this.$t('Please check the field you want to export to export correctly.')//'请勾选要导出的字段,才能正确导出!'
                        }
                    });
                    return false;
                }
                //查询数据条数
                let options = copyObj(this.data.options); //当前条件下
                let export_fileds = copyObj(this.export_fileds);
                options['export_fileds'] = export_fileds;
                let url = this.data.configUrl.exportUrl;
                let sheet = array_get(this.data,'excel.sheet','');
                let parms = {
                    options:options,
                    url:url,
                    sheet:sheet,
                    fileName:this.data.excel.fileName
                };
                this.downloadExcel(parms);
            },
            selectExcel(e){
                let files = e.target.files;
                if(files.length == 0) return;
                let file = files[0];
                //验证excel文件
                if(!/\.xlsx$/g.test(file.name)) {
                    this.set({
                        key:'modal',
                        modal:{
                            title:this.$t('Prompt'), //提示
                            content: this.$t('Import of XLSX format files is only supported')//'仅支持导入xlsx格式文件'
                        }
                    });
                    return;
                }
                this.set({
                    key:'modal',
                    modal:{
                        title:this.$t('Prompt'), //提示
                        content: this.$t('Are you sure you want to import all the data in bulk?'), //'您确定要批量导入所有数据吗?',
                        callback:()=>{
                            $(this.$el).find('.import input:file').val('');
                            let sheet = array_get(this.data,'excel.sheet','');
                            this.importData({
                                file:file,
                                sheet:sheet,
                                url:this.data.configUrl.importUrl,
                                callback:()=>{
                                    this.refresh();
                                }
                            });
                        },
                        cancel:()=>{ //取消
                            $(this.$el).find('.import input:file').val('');
                        }
                    },

                });

            },
            importExcel(){
                $(this.$el).find('.import input:file').trigger('click');
            },
            checkboxClass(num, cardinal_number, statusClass,key){
                if(key.indexOf('$index')!=-1){
                    let keys = key.split('.$index.');
                    num = array_get(num,keys[1],0);
                }
                return 'label-' + statusClass[(Math.log(num) / Math.log(cardinal_number) + 1) % statusClass.length];
            }


        },
        watch:{
            check_ids(value,old){
                let count = collect(array_get(this.data,'list.data',[])).pluck(this.options.primaryKey||'id').count();
                if(count==value.length && count){
                    if(!this.select_all.length){
                        this.check_ids_change = true;
                        this.select_all = [1];
                    }
                }else {
                    if(this.select_all.length){
                        this.check_ids_change = true;
                        this.select_all = [];
                    }
                };
            },
            '$route.fullPath'(val){
                let value = this.$route.query[this.options_key];
                if(value!=this.options_str){
                    let options;
                    if(value){
                        options = JSON.parse(value);
                    }else {
                        if(typeof this.$route.query[this.options_key]=="undefined"){
                            options = {where:{},order:{}};
                            this.data.configUrl['listUrl'] = '';
                        }else {
                            options = copyObj(this.back_options);
                        }
                    }
                    this.data.options = options;
                    this.getData(options,1);
                }
            }
        },
        computed:{
            ...mapState([
                '_token',
                'use_url',
                'statusClass'
            ]),
            options_key(){
                return typeof this.options.optionsKey=="undefined"?'options':this.options.optionsKey;
            },
            _total(){
                return array_get(this.data,'list.total',0);
            },
            _placeholder(){
                if(typeof this.options.keywordPlaceholder=="function"){
                    return this.options.keywordPlaceholder();
                }
                return this.$t(this.options.keywordPlaceholder) || this.$t('Please enter keywords');
            },
            //组件唯一标识
            id(){
                return this.options.id || 'data-table';
            },
            //数据是否为空
            is_empty(){
                return !array_get(this.data,'list.data',[]).length;
            },
            //table展示字段
            show_fields(){
                //排序情况
                let orders = array_get(this.affirm_options,'order',{});
                let fields = collect(copyObj(this.options.fields)).filter((item)=>{
                    return item['show'] || typeof item['show']=="undefined";
                }).map((item,key1)=>{
                    let key = item.orderField || key1;
                    //字段需要排序
                    if(item.order){
                        if(!item.class){
                            item.class = '';
                        }
                        if(orders[key]){
                            item.class += ' sorting_'+orders[key];
                        }else {
                            item.class += ' sorting';
                        }
                    }
                    return item;
                }).all();
                return fields;
            },
            //列个数
            col_num(){
                let count = collect(this.show_fields).count();
                if(this.operation){
                    count++;
                }
                if(this.checkbox){
                    count++;
                }
                return count;
            },
            operation(){
                return (this.options.operation || typeof this.options.operation=="undefined");
            },
            checkbox(){
                return (this.options.checkbox || typeof this.options.checkbox=="undefined" );
            },
            btnSizerMore(){
                return (this.options.btnSizerMore || typeof this.options.btnSizerMore=="undefined" );
            },
            btnRefresh(){
                return (this.options.btnRefresh || typeof this.options.btnRefresh=="undefined" );
            },
            perPageOptions(){
                if(this.options.per_page_options){
                    return this.options.per_page_options;
                }
                return this.per_page_options;
            },
            //翻译后的显示数据项
            _maps(){
                let maps = copyObj(this.data.maps);
                return this.mapEach(maps);
            },


        },
        created() {
            //动态加载js文件
            if(!document.getElementById('xlsx-js')){
                let $script = document.createElement('script');
                $script.id = 'xlsx-js';
                $script.type = 'text/javascript';
                $script.src = 'https://cdn.bootcss.com/xlsx/0.15.1/xlsx.full.min.js';
                document.body.appendChild($script);
            }
            //获取数据
            let options = this.options.defOptions || JSON.parse(this.$router.currentRoute.query[this.options_key] || '{}');
            if(this.options.keywordKey){
                if(!options.where){
                    options.where = {};
                }
                options.where._key = this.options.keywordKey;
            }
            if(options['page']>1){
                options['get_count'] = 1;
            }else if(options['page']==1){
                delete options['page'];
            }
            this.getData(options);
        },

    }
</script>

<style scoped>
    .table{
        overflow: hidden;
        position: relative;
    }
    .sizer .sizer-item{
        margin-top: 10px;
    }
    .pager-tool .count{
        display: inline-block;
        height: 30px;
        line-height: 30px;
    }
    .dataTable .operate{
        width: 55px;
    }
    .table tbody{
        position: relative;
    }
    .box-body .table-striped .loading{
        background-color: unset;
        background: #FFFFFF7F;
    }
    .skin-dark .box-body .table-striped .loading{
        background-color: unset;
        background: rgba(255,255,255,0.1);
    }
    .skin-dark .box .overlay > .fa,
    .skin-dark .overlay-wrapper .overlay > .fa{
        color: unset;
    }
    .table .loading{
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }
    .table .loading .explain{
        font-size: 16px;
        margin-top: 10px;
        font-weight: bold;
    }
    .box-body .table > tbody > tr > td,
    .box-body .table > tbody > tr > th,
    .box-body .table > tfoot > tr > td,
    .box-body .table > tfoot > tr > th,
    .box-body .table > thead > tr > td,
    .box-body .table > thead > tr > th{
        vertical-align: middle;
    }
    .box-body .table > tfoot > tr > .overlay{
        padding: 0px;
        margin: 0px;
    }
    .dataTable .id{
        width: 20px;
    }
    .sizer .sizer-item .small-box{
        margin-bottom: 0px;
    }
    .sizer .sizer-item .inner{
        height: 50px;
    }
    .topage{
        width: 50px;
        padding: 5px 5px;
    }
    .topage1{
        width: 80px;
    }
    .sizer .sizer-item .btn{
        margin-bottom: 5px;
    }
    .data-table .box-body{
        padding-top: 0px;
    }
    .dialog {
        display: block
    }

    .dialog .modal-dialog {
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        margin: auto;
    }
    .export_excel{
        /*margin-top: 10px;*/
    }
    .sizer-row{
        margin-bottom: 10px;
    }

    .sizer{
        padding-top: 0px;
    }
    .pager-input{
        display: inline-block;
        height: 30px;
        line-height: 30px;
    }
    .pager-input input{
        padding-top: 0px;
        padding-bottom: 0px;
        height: 24px;
    }
    .sizer-tool-btn{
        margin-top: 10px;
    }
    .text-left{
        text-align: left;
    }
    .labels-m{
        margin-left: 5px;
    }
    .input-group-addon1 i {
        display: inline-block;
        cursor: pointer;
        vertical-align: text-top;
        height: 16px;
        width: 16px;
        position: relative;
    }
    .per_page{
        width: 55px;
    }
    .box-footer{
        padding-top: 0px;
    }
    .m-top{
        margin-top: 10px !important;
    }
    .box-footer-top{
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    .table-responsive{
        border: none;
    }
    @media screen and (max-width: 767px){
        .table-responsive>.table-bordered {
            border: 1px solid #f4f4f4;
        }
        .skin-dark .table-responsive>.table-bordered {
            border: 1px solid #444;
        }
    }

</style>
