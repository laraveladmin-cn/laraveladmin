<template>
    <div class="admin_user_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box box-primary" :options="options">
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
                            <img v-if="props.row['logo']" class="attachment-img" :src="props.row['logo']" alt="Attachment Image" />
                            <div v-else class="img-rounded no-img" alt="还没有设置LOGO">
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
            'data-table': function (resolve) {
                require(['common_components/datatable.vue'], resolve);
            }
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
                    //hideTopPagerTool:true,
                    fields: {
                        "id": {"name": "ID", "order": true},
                        "name": {"name": "Name", "order": true},
                        "logo": {"name": "Brand logo", "order": true},
                        "description": {"name": "Describe", "order": true},
                        "products_count": {"name": "Number of insurance types", "order": true},
                        "banks_count": {"name": "Withholding Bank", "order": true},
                        "updated_at": {"name": "Updated At", "order": true}
                    },
                }
            };
        }
    };
</script>
<style lang="scss">
    .attachment-img{
        max-width: 100px;
        max-height: 100px;
    }
    .no-img{
        width: 100px;
        height: 73px;
        background: gainsboro;
        display: inline-block;
        vertical-align: middle;
    }

</style>
