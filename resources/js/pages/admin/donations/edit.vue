<template>
        <div class="app\_models\_donation_edit">
        <div class="box" :class="'box-'+theme">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options" ref="edit">
                    <template slot="content" slot-scope="props">
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="member_id" :options="{name: '捐赠会员',type:'select2', rules:'required|integer',title:''}" :datas="props">
                                <template slot="input-item">
                                        <select2 v-model="props.data.row['member_id']"
                                                 :default-options="props.maps['member_id']"
                                                 :url="use_url+'/admin/members/list'"
                                                 :keyword-key="'user.name'"
                                                 :show="['user.name']"
                                                 :disabled="!props.url"
                                                 :placeholder-show="$t('Please select')"
                                                 :placeholder-value="0"
                                                 :is-ajax="true">
                                        </select2>
                                </template>
                            </edit-item>
                            <edit-item key-name="sponsor_id" :options="{name: '赞助商',type:'select2', rules:'required|integer',title:''}" :datas="props">
                                <template slot="input-item">
                                        <select2 v-model="props.data.row['sponsor_id']"
                                                 :default-options="props.maps['sponsor_id']"
                                                 :url="use_url+'/admin/sponsors/list'"
                                                 :keyword-key="'name'"
                                                 :show="['name']"
                                                 :disabled="!props.url"
                                                 :placeholder-show="$t('Please select')"
                                                 :placeholder-value="0"
                                                 :is-ajax="true">
                                        </select2>
                                </template>
                            </edit-item>
                            <edit-item key-name="from" :options="{name: props.transField('Source'),type:'radio', rules:'',title:''}" :datas="props">
                                <template slot="input-item">
                                    <div class="row">
                                        <div v-for="(item,index) in props.maps['from']"
                                             class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <icheck v-model="props.data.row['from']"
                                                    :title="item"
                                                    :option="index"
                                                    type="radio"
                                                    :disabled="!props.url">
                                                {{item}}
                                            </icheck>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="amount" :options="{name: props.transField('Donation amount'),type:'num', rules:'required|min:0.02',title:''}" :datas="props">
                                <template slot="input-item">
                                    <div>
                                        <el-input-number v-model="props.data.row['amount']"
                                                         class="w-100"
                                                         size="medium"
                                                         :min="0.02"
                                                         :disabled="!props.url"
                                                         :precision="2"
                                                         :step="1">
                                        </el-input-number>
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
            edit: ()=>import(/* webpackChunkName: "common_components/edit.vue" */ 'common_components/edit.vue'),
            editItem: ()=>import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
            select2:()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'), //选择框异步组件
            elInputNumber:()=>import(/* webpackChunkName: "element-ui/lib/input-number" */ 'element-ui/lib/input-number'), //数字框异步组件
            icheck: () => import(/* webpackChunkName: "common_components/icheck.vue" */ 'common_components/icheck.vue'),

        },
        props: {
            url:{
                type: [String],
                default: function () {
                    return '';
                }
            },
            noBack:{
                type: [Boolean],
                default: function () {
                    return false;
                }
            },
            callback:{
                type: [Function],
                default: function () {
                    return function () {};
                }
            },
        },
        data() {
            return {
                options: {
                    lang_table:'donations', //字段翻译
                    id: 'edit', //多个组件同时使用时唯一标识
                    params: null, //默认筛选条件
                    url:this.url || '', //数据表请求数据地址
                    no_back:this.noBack,
                    callback: (response, row) => { //修改成功
                        this.callback();
                    }
                }
            };
        },
        methods: {},
        computed: {
            ...mapState([
                'use_url',
                'theme'
            ])
        },
        watch:{
            url(val){
                this.options.url = val;
            }
        }
    };
</script>
