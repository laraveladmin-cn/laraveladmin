<template>
    <div class="admin_ousers_edit">
        <div class="box" :class="'box-'+theme">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options" ref="edit">
                    <template slot="content" slot-scope="props">
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="user_id" :options="{name: '用户',type:'text', rules:'',title:''}" :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['user_id']"
                                                 :default-options="props.maps['user_id']"
                                                 :url="use_url+'/admin/users/list'"
                                                 :keyword-key="'name|uname|mobile_phone|email'"
                                                 :disabled="!props.url"
                                                 :placeholder-value="0"
                                                 :params="{where:{},or_has_admin:1}"
                                                 :show="['name','uname']"
                                                 :is-ajax="true" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="type" :options="{name: props.transField('Type'),type:'select', rules:'',title:''}" :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['type']"
                                                 :disabled="!props.url"
                                                 :default-options="props.maps['type']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="open_id" :options="{name: props.transField('User unique ID'),type:'text', rules:'',title:''}" :datas="props">
                            </edit-item>

                        </div>
                        <div class="move-items col-lg-8 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="data" :options="{name: props.transField('User information'),type:'text', rules:'',title:''}" :datas="props">
                                <template slot="input-item">
                                    <json-edit
                                        v-model="props.data.row['data']"
                                        :disabled="!props.url"
                                        :placeholder="'请输入'">
                                    </json-edit>
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
        elDatePicker:()=>import(/* webpackChunkName: "element-ui/lib/date-picker" */ 'element-ui/lib/date-picker'), //日期组件
        jsonEdit:()=>import(/* webpackChunkName: "common_components/jsonEdit.vue" */ 'common_components/jsonEdit.vue'),
        select2:()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),

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
                lang_table:'ousers', //字段翻译
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
