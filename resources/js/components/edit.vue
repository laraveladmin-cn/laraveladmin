<template>
    <div :id="id">
        <validation-observer :ref="id" v-slot="{invalid,validate}">
            <div class="row">
                <slot name="content" :data="data" :url="url" :error="error">
                </slot>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <button type="button" class="btn btn-primary pull-right" :disabled="!url"  @click="submitForm(invalid,validate)">提交</button>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <button type="button" class="btn btn-default pull-left" @click="resetForm">重置</button>
                    <button type="button" class="btn btn-success pull-right" v-if="is_local" @click="saveLayout">保存布局</button>
                </div>
            </div>
        </validation-observer>
    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations, mapGetters} from 'vuex';
    import {ValidationObserver} from 'vee-validate';
    import sortable from 'sortablejs';
    export default {
        name: "edit",
        components: {
            ValidationObserver
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
                'env'
            ]),
            //组件唯一标识ID
            id(){
                return this.options.id || 'edit';
            },
            //提交请求地址
            url(){
                return this.primary_key_id?this.data.configUrl['updateUrl'].replace('{id}',this.primary_key_id):this.data.configUrl['createUrl'];
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
                return this.env=='local';
            }
        },
        data(){
            return {
                data: {
                    row:{},
                    maps:{},
                    configUrl:{}
                },
                back_data: {
                    row:{},
                    maps:{},
                    configUrl:{}
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
                        this.validation.setErrors(catchError(error));
                        this.submiting = false;
                        if(error.response && error.response.status==422){
                            this.pushMessage({
                                'showClose':true,
                                'title':'提交失败!',
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
                }).catch((error) => {
                    this.loading = false;
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
                    path: this.options.componentPath || path_arr.join('/'), //修改的布局页面组件
                    items:items
                };
                axios.post(this.use_url+'/admin/developments/layout', data).then( (response)=>{
                }).catch((error) =>{
                });
            }
        },
        created() {
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
                        group: { name: "edit", pull: true, put: true },
                    });
                });
            }
        }
    }
</script>

<style scoped>

</style>
