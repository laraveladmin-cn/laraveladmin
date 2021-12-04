<template>
    <div class="file_log_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box" :class="'box-'+theme" :options="options">
                    <template slot="col-operation" slot-scope="props">
                        <a :title="$t('Download')"
                           :href="props.row.url"
                           :disabled="!props.data.configUrl['downloadUrl']"
                           target="_blank"
                           class="btn btn-default btn-xs">
                            <i class="fa fa-cloud-download"></i>
                        </a>
                    </template>
                    <template slot="add_btn" slot-scope="props">
                        <div class="btn-group">
                            <button class="btn btn-default" :class="{active:type==0}" @click="type=0">
                                <i class="fa fa-list"></i>
                            </button>
                            <button class="btn btn-default" :class="{active:type==1}"  @click="type=1">
                                <i class="fa fa-th"></i>
                            </button>
                        </div>
                    </template>
                    <template slot="table" slot-scope="props" v-if="type!=0">
                        <ul class="row files-container">
                            <li v-for="file in props.data.list.data" class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <file-preview :file="file" :download-disabled="!props.data.configUrl['downloadUrl']"></file-preview>
                            </li>
                        </ul>
                    </template>
                </data-table>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from "vuex";

    export default {
        components: {
            'data-table': () => import(/* webpackChunkName: "common_components/datatable.vue" */ 'common_components/datatable.vue'),
            'file-preview': () => import(/* webpackChunkName: "pages/admin/file_log/filePreview.vue" */ 'pages/admin/file_log/filePreview.vue')
        },
        props: {},
        data() {
            return {
                type:0,
                options: {
                    lang_table: '_file_logs',
                    id: 'data-table', //多个data-table同时使用时唯一标识
                    url: '', //数据表请求数据地址
                    operation: true, //操作列
                    checkbox: true, //选择列
                    btnSizerMore: false, //更多筛选条件按钮
                    keywordKey: 'file', //关键字查询key
                    keywordGroup: false, //是否为选项组
                    primaryKey: 'id', //数据唯一性主键
                    defOptions: {}, //默认筛选条件
                    hideTopPagerTool: true,
                    hideBottomPagerTool: true,
                    fields: {
                        "file": {"name": "File", "order": true, class: 'text-left'},
                        "size_format": {"name": "Size", "order": true,orderField:'size'},
                        "updated_at": {"name": "Updated At", "order": true}
                    },
                }
            }
        },
        methods: {},
        computed: {
            ...mapState([
                'use_url',
                'theme'
            ])
        }
    };
</script>
<style scoped>
    .box {
        border-top: 0px;
    }

    .files-container {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .files-container li {
        margin-bottom: 10px;
    }

</style>
