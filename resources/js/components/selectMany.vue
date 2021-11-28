<template>
    <div class="select-many">
        <div class="input-group">
            <select2 v-model="val_id"
                     :disabled="disabled"
                     class="form-control no-border"
                     :default-options="[]"
                     :url="use_url+url"
                     :keyword-key="keywordKey"
                     :primary-key="primaryKey"
                     :show="show"
                     :is-ajax="true">
            </select2>
            <span class="input-group-addon btn btn-block btn-default"
                  :disabled="disabled"
                  :class="{disabled:disabled}"
                  :title="$t('Confirm to add')"
                  @click="add">
                <i class="fa fa-plus"></i>
            </span>
        </div>
        <div class="box box-default">
            <div class="box-footer no-padding">
                <ul class="nav nav-pills nav-stacked">
                    <li v-for="(option,index) in options" v-if="options.length>0">
                        <a href="javascript:void(0)">
                            <span class="label" :class="'label-'+theme">
                                {{showName(option)}}
                            </span>
                            <span class="pull-right text-red"
                                  :class="{disabled:disabled}"
                                  :title="$t('Delete')"
                                  @click="remove(option)">
                                <i class="fa fa-trash-o"></i>
                            </span>
                        </a>
                    </li>
                    <li v-if="!options.length && !loading">
                        <a href="javascript:void(0)" class="text-center active">
                          {{$t('Temporarily no data')}}
                        </a>
                    </li>
                </ul>
            </div>
            <div v-show="loading" class="loading text-center">
                {{$t('Loading')}}...
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    export default {
        name: "selectMany",
        components: {
            'select2': () => import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),
        },
        props:{
            value: {
                type:[Array,Object],
                default: function () {
                    return [];
                }
            },
            options:{
                type:[Array,Object],
                default: function () {
                    return [];
                }
            },
            disabled:{
                default: function () {
                    return false;
                }
            },
            //请求数据地址
            url:{
                type:[String],
                default: function () {
                    return '';
                }
            },
            itemUrl:{
                type:[String],
                default: function () {
                    return '';
                }
            },
            //搜索关键字KEY
            keywordKey:{
                type:[String],
                default: function () {
                    return 'keyword';
                }
            },
            primaryKey:{
                type:[String],
                default: function () {
                    return 'id';
                }
            },
            show:{
                type:[Array],
                default: function () {
                    return ['name'];
                }
            },
        },
        data(){
            return {
                val:this.value,
                val_id:'',
                active_id:collect(this.value).first()||0,
                loading:false
            }
        },
        watch:{
            value(val){
                if(this.val!=val){
                    this.val = val;
                }
            },
            val(val){
                this.$emit('input', val); //修改值
                this.$emit('change',val); //修改值
            }
        },
        methods:{
            remove(item){
                if(this.disabled){
                    return ;
                }
                let id = array_get(item,this.primaryKey);
                let index=-1;
                collect(this.options).eachSpread((i) => {
                    let item = this.options[i];
                    if(array_get(item,this.primaryKey) == id){
                        index = i;
                        return false;
                    }
                });
                if(index!=-1){
                    this.options.splice(index, 1);
                }
                this.val = collect(this.options).pluck(this.primaryKey).all();
                if(id==this.active_id){
                    this.active_id = collect(this.val).first() || 0;
                }
            },
            showName(item){
                let text = '';
                for (let j in this.show){
                    if(j==0){
                        text = array_get(item,this.show[j]);
                    }else {
                        text += array_get(item,this.show[j]) ? '（'+array_get(item,this.show[j])+'）':'';
                    }
                }
                return text;
            },
            add(){
                if (this.loading || this.disabled) {
                    return;
                }
                let id = this.val_id - 0;
                if (!id) {
                    return;
                }
                let has = collect(this.val).contains(id);
                if (has) {
                    return;
                }
                this.loading = true;
                //查询险种信息
                axios.get(this.use_url+this.itemUrl + id, {params: {}}).then((response) => {
                    this.options.push(response.data.row);
                    let id = array_get(response.data.row,this.primaryKey);
                    this.active_id=id;
                    this.val = collect(this.val).push(id).all();
                    this.loading = false;
                }).catch( (error) =>{
                    this.loading = false;
                });
            }
        },
        computed:{
            ...mapState([
                'use_url',
                'theme'
            ])
        }
    }
</script>

<style scoped>
    .select2-container--default .select2-selection--single, .select2-selection .select2-selection--single {
        border: 0px solid #d2d6de;
    }

    div .main-select2 .select2-container {
        border-bottom: #d2d6de 0px solid;
        border-top: #d2d6de 0px solid;
    }

    .main-select2 {
        padding: 0px 0px;
        margin: 0px 0px;
    }

    .select2 {
        border: 0px;
    }
    .box{
        border: 1px solid #f4f4f4;;
    }
    .nav-pills li a{
        cursor:default;
        border-left: none;
        padding: 5px;
    }
    .nav-pills li a i{
        cursor:pointer;
    }
    .active{
        color: #444;
        background: #f7f7f7;
    }
    .loading{
        padding: 5px;
    }
    .disabled{
        cursor: not-allowed;
    }
</style>
