<template>
    <div class="admin_user_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box box-primary" :options="options">
                    <template slot="sizer-more" slot-scope="props">
                        <div class="row" >
                            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 sizer-item">
                                <date-sizer v-model="props.where['created_at']"></date-sizer>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 sizer-item">
                                <select2 v-model="props.where['menu_id']"
                                         :default-options="array_get(props,'maps.menu_id',[])"
                                         :url="use_url+'/admin/menus/list'"
                                         :keyword-key="'name|url'"
                                         :show="['name','url']"
                                         :placeholder-show="'操作名称'"
                                         :placeholder-value="''"
                                         :is-ajax="true" >
                                </select2>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 sizer-item">
                                <select2 v-model="props.where['user_id']"
                                         :default-options="array_get(props,'maps.user_id',[])"
                                         :url="use_url+'/admin/admins/list'"
                                         :keyword-key="'name|uname'"
                                         :placeholder-show="'操作者'"
                                         :placeholder-value="''"
                                         :primary-key="'user_id'"
                                         :show="['user.name']"
                                         :is-ajax="true" >
                                </select2>
                            </div>
                        </div>
                    </template>
                    <template slot="col" slot-scope="props">
                       <span v-if="props.field.type =='code'">
                            <code v-if="props.field.limit">
                                {{props.row | array_get(props.k) | str_limit(props.field.limit)}}
                            </code>
                            <code v-else>
                                  {{props.row | array_get(props.k)}}
                            </code>
                        </span>
                        <span v-else-if="props.k =='menu.name'">
                            {{translation(props.row ,props.k)}}
                        </span>
                        <span v-else>
                            {{props.row | array_get(props.k)}}
                        </span>
                    </template>
                </data-table>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations, mapGetters} from 'vuex';
    export default {
        components:{
            'data-table':()=>import(/* webpackChunkName: "common_components/datatable.vue" */ 'common_components/datatable.vue'),
            "select2":()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),
            "dateSizer":()=>import(/* webpackChunkName: "common_components/dateSizer.vue" */ 'common_components/dateSizer.vue'),
        },
        props: {
        },
        data(){
            let def_options = JSON.parse(this.$router.currentRoute.query.options || '{}');
            return {
                "{lang_path}":'admin.logs',
                shared:{
                    "{lang_path}":'_shared.menus',
                    '{lang_root}':''
                },
                options:{
                    id:'data-table', //多个data-table同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    operation:true, //操作列
                    checkbox:true, //选择列
                    btnSizerMore:true, //更多筛选条件按钮
                    keywordKey:'parameters', //关键字查询key
                    keywordGroup:false, //是否为选项组
                    keywordPlaceholder:()=>{
                        return this.$t('Please enter keywords')+this.$tp('(Request parameters)');
                    },//'请输入名称',
                    primaryKey:'id', //数据唯一性主键
                    defOptions:def_options, //默认筛选条件
                    fields: {
                        "id": {"name": "ID", "order": true},
                        "menu.name": {"name": "操作菜单", "order": true},
                        "user.name": {"name": "操作者", "order": true},
                        "location": {"name": "位置", "order": true},
                        "ip": {"name": "IP地址", "order": true},
                        "parameters": {"name": "请求参数", "order": true,type:"code",limit:30},
                        "created_at": {"name": "创建时间", "order": true},
                        //"updated_at": {"name": "修改时间", "order": true},
                    },
                },
                pickerOptions: {
                    disabledDate(time) {
                        return time.getTime() > Date.now();
                    }
                }
            }
        },
        computed:{
            ...mapState([
                'use_url'
            ])
        },
        methods:{
            translation(item,key){
                let value = array_get(item,key,'');
                let resource_id = array_get(item,'menu.resource_id',0);
                let res = this.$tp(value , this.shared);
                if(resource_id && res==value && (this._i18n.locale!='en' || value.indexOf('{')!=-1)){ //没有翻译成功
                    let parent_name = array_get(item,'menu.parent.item_name','') || array_get(item,'menu.parent.name','') || '';
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
            }
        }

    };
</script>
<style lang="scss">

</style>
