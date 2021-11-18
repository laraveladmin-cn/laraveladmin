<template>
    <div class="admin_sponsor_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box" :class="'box-'+theme" :options="options" ref="table">
                    <template slot="col" slot-scope="props">
                       <span v-if="props.field.type =='url'">
                           <a :href="array_get(props.row,props.k)" target="_blank">
                               {{props.row | array_get(props.k)}}
                           </a>
                        </span>
                        <span v-else-if="props.field.type =='upload'">
                           <el-image
                               v-if="array_get(props.row,props.k)"
                               class="attachment-img"
                               :src="array_get(props.row,props.k)"
                               :alt="$tp('Attachment Image')"
                               :preview-src-list="array_get(props.row,props.k)?[array_get(props.row,props.k)]:[]">
                            </el-image>
                            <div v-else class="img-rounded no-img" :alt="$tp('The image has not been set')">
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
            'data-table': () => import(/* webpackChunkName: "common_components/datatable.vue" */ 'common_components/datatable.vue'),
            'el-image':()=>import(/* webpackChunkName: "element-ui/lib/image" */ 'element-ui/lib/image'),
        },
        props: {},
        data() {
            return {
                options:{
                    lang_table:'sponsors',
                    lang_table: 'sponsors', //字段翻译
                    id: 'data-table', //多个data-table同时使用时唯一标识
                    url: '', //数据表请求数据地址
                    operation: true, //操作列
                    checkbox: true, //选择列
                    btnSizerMore: false, //更多筛选条件按钮
                    keywordKey: 'name', //关键字查询key
                    keywordGroup: false, //是否为选项组
                    keywordPlaceholder: () => {
                        return this.$t('Please enter keywords');
                    },
                    primaryKey: 'id', //数据唯一性主键
                    defOptions: null, //默认筛选条件
                    fields: {
                        id: {name: "ID", order: true},
                        name: {name: "Sponsor", order: true},
                        url: {name: "Link", order: true, type: "url"},
                        logo: {name: "Logo Icon", order: true, type: "upload"},
                        created_at: {name: "Created At", order: true, type: "time"},
                        updated_at: {name: "Updated At", order: true, type: "time"}
                    },
                }
            };
        },
        computed: {
            ...mapState([
                'use_url',
                'theme'
            ])
        },
        methods: {},
    };
</script>
<style lang="scss" scoped>


</style>
