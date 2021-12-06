<template>
    <div class="admin_user_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box" :class="'box-'+theme" :options="options">
                    <template slot="col" slot-scope="props">
                        <span v-if="props.field.type =='label'">
                            <span class="label" :class="'label-'+statusClass[props.row[props.k]%statusClass.length]">
                                {{ props.maps[props.k] | array_get(props.row[props.k]) }}
                            </span>
                        </span>
                        <span v-else-if="props.k =='name' && props.row['url']">
                            <a :href="props.row['url']" target="_blank">
                                {{props.row | array_get(props.k)}}
                            </a>
                        </span>
                        <span v-else-if="props.k =='products_count'">
                              <router-link :to="'/admin/products?options='+getOptions({where:{firm_id:props.row['id']}})">
                                {{props.row | array_get(props.k)}}
                              </router-link>
                        </span>
                        <span v-else-if="props.k =='banks_count'">
                             <router-link :to="'/admin/banks?options='+getOptions({where:{'firms.firm_id':props.row['id']}})">
                                {{props.row | array_get(props.k)}}
                             </router-link>
                        </span>
                        <span v-else-if="props.k =='logo'">
                            <el-image
                                v-if="props.row['logo']"
                                class="attachment-img"
                                :src="props.row['logo']"
                                :alt="$tp('Attachment Image')"
                                :preview-src-list="props.row['logo']?[props.row['logo']]:[]">
                            </el-image>
                            <div v-else class="img-rounded no-img" :alt="$tp('The LOGO has not been set')">
                            </div>
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
        components: {
            'data-table':()=>import(/* webpackChunkName: "common_components/datatable.vue" */ 'common_components/datatable.vue'),
            'el-image':()=>import(/* webpackChunkName: "element-ui/lib/image" */ 'element-ui/lib/image'),

        },
        props: {},
        methods:{

        },
        data() {
            let def_options = JSON.parse(this.$router.currentRoute.query.options || '{}');
            return {
                "{lang_path}":'admin.firms',
                options:{
                    lang_table:'firms',
                    id: 'data-table', //多个data-table同时使用时唯一标识
                    url: '', //数据表请求数据地址
                    operation: true, //操作列
                    checkbox: true, //选择列
                    btnSizerMore: false, //更多筛选条件按钮
                    keywordKey: 'name', //关键字查询key
                    keywordGroup: false, //是否为选项组
                    keywordPlaceholder:()=>{
                        return this.$t('enter',{name:this.$t('name')});
                    },//'请输入Name',
                    primaryKey: 'id', //数据唯一性主键
                    defOptions: def_options, //默认筛选条件
                    defaultExportNotAll:true,//导出字段默认不全选
                    //hideTopPagerTool:true,//去掉顶部分页工具栏
                    fields: {
                        "id": {"name": "ID", "order": true},
                        "name": {"name": "Name", "order": true},
                        "logo": {"name": "Brand logo", "order": true},
                        "description": {"name": "Describe", "order": true},
                        "products_count": {"name": "Number of insurance types", "order": true},
                        "banks_count": {"name": "Withholding Bank", "order": true},
                        "products_count_is_long_time":{"name": "Number of long-term insurance types", "order": true},
                        "products_count_status.value0":{"name": "Stop selling insurance plant number", "order": false},
                        "products_count_status.value1":{"name": "Number of types of insurance on sale", "order": false},
                        "products_count_status.value2":{"name": "Number of discontinued insurance types", "order": false},
                        "updated_at": {"name": "Updated At", "order": true},
                    },
                    "mapsRelations": {
                        "products_count_status": "products"
                    }
                }
            };
        },
        computed: {
            ...mapState([
                'use_url',
                'theme'
            ])
        },
    };
</script>
<style lang="scss" scoped>
    .attachment-img{
        max-width: 100px;
        max-height: 100px;
        border-radius: 6px;
    }
    .no-img{
        width: 100px;
        height: 73px;
        background: gainsboro;
        display: inline-block;
        vertical-align: middle;
    }

</style>
