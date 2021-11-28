<template>
    <div :id="id" :class="{'active-move':is_local}">
       <!-- <component-demos ref="demos" v-if="is_local"></component-demos>-->
        <form onsubmit="return false;">
            <validation-observer :ref="id" v-slot="{invalid,validate}">
                <div class="row">
                    <slot name="content" :data="data" :url="url" :maps="_maps" :error="error" :trans-field="transField">
                    </slot>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                       <!-- <button type="button" class="btn btn-info pull-left" v-if="is_local" @click="$refs['demos'].open()">组件示例</button>-->
                        <button type="button" class="btn pull-right" :class="'btn-'+theme" :disabled="!url"  @click="submitForm(invalid,validate)">{{$t('Submit')}}</button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <button type="button" class="btn btn-default pull-left" @click="resetForm">{{$t('Reset')}}</button>
                        <button type="button" class="btn pull-right" :class="'btn-'+theme" v-if="is_local" @click="saveLayout">{{$t('Save the layout')}}</button>
                    </div>
                </div>
            </validation-observer>
        </form>
    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations, mapGetters} from 'vuex';
    import {ValidationObserver} from 'vee-validate';
    import sortable from 'sortablejs';
    export default {
        name: "edit",
        components: {
            ValidationObserver,
            "component-demos":()=>import(/* webpackChunkName: "common_components/componentDemos.vue" */ 'common_components/componentDemos.vue'),
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
        computed:{
            ...mapState([
                '_token',
                'use_url',
                'env',
                'theme'
            ]),
            //组件唯一标识ID
            id(){
                return this.options.id || 'edit';
            },
            //提交请求地址
            url(){
                return this.primary_key_id?(this.data.configUrl['updateUrl'] || '').replace('{id}',this.primary_key_id):this.data.configUrl['createUrl'];
            },
            primary_key(){
              return this.options.primaryKey||'id';
            },
            primary_key_id(){
                return this.data.row[this.primary_key] || '';
            },
            //请求方式
            method(){
                return this.primary_key_id?'put':'post';
            },
            validation(){
                return this.$refs[this.id];
            },
            is_local(){
                return this.env=='local' && (typeof this.options.fixed=="undefined" || !this.options.fixed);
            },
            //翻译后的显示数据项
            _maps(){
                let maps = copyObj(this.data.maps);
                return this.mapEach(maps);
            },
        },
        data(){
            return {
                data: {
                    row:{},
                    maps:{},
                    configUrl:{},
                    mapsRelations:{}
                },
                back_data: {
                    row:{},
                    maps:{},
                    configUrl:{},
                    mapsRelations:{}
                },
                error: {},
                submiting:false,
                loading:false,
                query_str:''
            };
        },

        methods: {
            ...mapActions({
                refreshToken: 'refreshToken',
                pushMessage: 'pushMessage',
            }),
            ...mapMutations({
                menuSet:'menu/set',  //设置当前路由,用于菜单选中
            }),
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
            transMap(name,field,table){
                let sheet = array_get(this.data,'excel.sheet');
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
            transField(name,key,table){
                let sheet = array_get(this.data,'excel.sheet');
                if(!this.options.lang_table && !sheet){
                    return name;
                }
                if(!table){
                    if(!key || key.indexOf('.')==-1){
                        table = this.options.lang_table || sheet;
                    }else {
                        let arr = key.split('.');
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
            //提交表单
            submitForm(invalid,validate) {
                //防止重复提交
                let url = this.url;
                if(this.submiting || !url){
                    return ;
                }
                let callback = ()=>{
                    this.submiting = true;
                    let data = copyObj(this.data.row);
                    data['_token'] = this._token;
                    this.error = {};
                    axios[this.options.method || this.method](this.use_url+url, data).then( (response)=>{
                        if(typeof this.options.callback=="function"){
                            this.options.callback(response,this.data.row);
                        }
                        this.refreshToken();
                        if(!this.options.no_back){
                            this.$router.go(-1);
                        }else {
                            this.submiting = false;
                        }
                    }).catch((error) =>{
                        //this.error = catchError(error);
                        this.submiting = false;
                        if(error.response && error.response.status==422){
                            this.validation.setErrors(catchError(error));
                            this.pushMessage({
                                'showClose':true,
                                'title':this.$t('{action} failed!',{action:this.$t('Submission')}),
                                'message':'',
                                'type':'danger',
                                'position':'top',
                                'iconClass':'fa-warning',
                                'customClass':'',
                                'duration':3000,
                                'show':true
                            });
                        }
                    });
                };
                if(invalid){
                    validate().then(success => {
                        success && callback();
                    });
                }else {
                    callback();
                }

            },
            //重置表单
            resetForm() {
                this.error = {};
                this.data = copyObj(this.back_data);
                this.validation.reset();
                if(typeof this.options.resetCallback=="function"){
                    this.options.resetCallback();
                }
            },
            //获取数据
            getData(params){
                if(this.loading){
                    return false;
                }
                this.loading = true;
                let url = this.options.url || this.$router.currentRoute.path;
                this.query_str = JSON.stringify(params);
                axios.get(this.use_url+url,{params:params}).then( (response)=> {
                    for (let i in response.data ) {
                        Vue.set(this.data,i,response.data[i]);
                    }
                    this.back_data = copyObj(response.data);
                    this.loading = false;
                    let id = array_get(this.data,'row.'+this.primary_key,0);
                    this.setLastMenuShow(id);
                }).catch((error) => {
                    this.loading = false;
                });
            },
            setLastMenuShow(id){
                let key = (id?'edit':'new')+'_title.';
                this.menuSet({
                    key:'last_menu_show',
                    last_menu_show:{
                        name:array_get(this.options,key+'name',''),
                        description:array_get(this.options,key+'description','')
                    }
                });
            },
            //开发环境布局保存
            saveLayout(){
                let url = this.options.url || this.$router.currentRoute.path;
                let path_arr = url.split('/');
                path_arr[path_arr.length-1] = 'edit.vue';
                let items = [];
                $(this.$el).find('.move-items').each(function () {
                    let items_group = [];
                    $(this).find('.move-item').map(function () {
                        items_group[items_group.length] = $(this).attr('data-id');
                    });
                    items[items.length] = items_group;
                });
                let data = {
                    path: (this.options.componentPath || '/pages'+path_arr.join('/')).replace(/-/g,'_'), //修改的布局页面组件
                    items:items
                };
                axios.post(this.use_url+'/admin/developments/layout', data).then( (response)=>{
                }).catch((error) =>{
                });
            }
        },
        created() {
            let url = this.options.url || this.$router.currentRoute.path;
            let id = collect(url.split('/')).last();
            if(id && !isNaN(id)){
                id = id-0;
            }
            this.setLastMenuShow(id);
            //获取数据
            let params = this.options.params || this.$router.currentRoute.query;
            this.getData(params);
        },
        watch:{
            '$route.fullPath'(route){
                let value = route.query;
                let options = copyObj(value);
                this.getData(options);
            },
            'options.url'(){
                //获取数据
                let params = this.options.params || this.$router.currentRoute.query;
                this.getData(params);
            }
        },
        mounted() {
            if(this.is_local){
                $(this.$el).find('.move-items').each(function () {
                    sortable.create(this,  {
                        animation: 1000,
                        draggable: ".move-item",
                        filter: ".ignore-move-item-content",  // 过滤器，不需要进行拖动的元素
                        preventOnFilter: false, //  在触发过滤器`filter`的时候调用`event.preventDefault()`
                        group: { name: "edit", pull: true, put: true },
                    });
                });
            }
        },
        destroyed() {
            this.menuSet({
                key:'last_menu_show',
                last_menu_show:{
                    name:'',
                    description:''
                }
            });
        }
    }
</script>

<style scoped>

</style>
