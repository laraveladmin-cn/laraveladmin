<template>
    <div class="admin_technology_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box box-primary" :options="options">
                    <template slot="col" slot-scope="props">
                        <ul class="products-list product-list-in-box" v-if="props.k=='name'">
                            <li class="item">
                                <div class="product-img">
                                    <img :src="props.row.logo" alt="Logo图片">
                                </div>
                                <div class="product-info">
                                    <a :href="props.row.url" class="product-title" target="_blank">
                                        {{props.row.name}}
                                    </a>
                                    <span class="text-gray pull-right">
                                            {{props.row.updated_at}}
                                     </span>
                                    <span class="product-description">
                                      {{props.row.description}}
                                    </span>
                                </div>
                            </li>
                        </ul>
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
            'data-table': ()=>import(/* webpackChunkName: "common_components/datatable.vue" */ 'common_components/datatable.vue')
        },
        props: {},
        data() {
            return {
                options:{
                    lang_table:'technologys',
                    id: 'data-table', //多个data-table同时使用时唯一标识
                    url: '', //数据表请求数据地址
                    operation: true, //操作列
                    checkbox: true, //选择列
                    btnSizerMore: false, //更多筛选条件按钮
                    keywordKey: 'name', //关键字查询key
                    keywordGroup: false, //是否为选项组
                    keywordPlaceholder: 'Please enter keywords',
                    primaryKey: 'id', //数据唯一性主键
                    defOptions: null, //默认筛选条件
                    fields: {
                        id: {name: "ID", order: true},
                        name: {name: "Name", order: true},
                 /*       url: {name: "Link address", order: true, type: "url"},
                        logo: {name: "Logo image", order: true, type: "upload"},
                        description: {name: "Describe", order: true, type: "textarea"},*/
                  /*      created_at: {name: "Created At", order: true, type: "time"},
                        updated_at: {name: "Updated At", order: true, type: "time"}*/
                    },
                }
            };
        },
        computed: {},
        methods: {},
    };
</script>
<style lang="scss" scoped>
.products-list {
    .item{
        background: unset;
        .product-info{
            height: 100px;
            text-align: left;
            padding-left: 210px;
        }
        .product-description{
            white-space:unset;
        }
    }
    .product-info{
        margin-left: 0px;
    }
    .product-img {
        img{
            width: 200px;
            height: 100px;
        }
    }
}


</style>
