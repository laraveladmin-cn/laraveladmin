<template>
    <div class="admin_doc_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box box-primary" :options="options">
                </data-table>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations, mapGetters} from 'vuex';

    export default {
        components: {
            'data-table': ()=>import(/* webpackChunkName: "common_components/datatable.vue" */ 'common_components/datatable.vue'),
        },
        props: {},
        data() {
            return {
                options: {
                    id: 'data-table', //多个data-table同时使用时唯一标识
                    url: '', //数据表请求数据地址
                    operation: true, //操作列
                    checkbox: true, //选择列
                    btnSizerMore: true, //更多筛选条件按钮
                    keywordKey: 'name|description', //关键字查询key
                    keywordGroup: false, //是否为选项组
                    keywordPlaceholder: '请输入关键字',
                    primaryKey: 'id', //数据唯一性主键
                    defOptions: null, //默认筛选条件
                    fields: {
                        id: {name: "ID", order: true},
                        name: {name: "路径", order: true},
                        description: {name: "内容", order: true,limit:80},
                        created_at: {name: "创建时间", order: true, type: "time"},
                        updated_at: {name: "修改时间", order: true, type: "time"}
                    },
                }
            };
        },
        computed: {
            ...mapState([
                'use_url'
            ])
        },
        methods: {},
    };
</script>
<style lang="scss" scoped>


</style>
