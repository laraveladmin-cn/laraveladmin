<template>
    <div class="admin_ai_prompt_template_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table class="box" :class="'box-'+theme" :options="options" ref="table">
                    <template slot="col" slot-scope="props">
                        <span v-if="props.k =='options'">
                            <div v-for="(option,index) in props.row['options']" class="text-left">
                                <i class="fa" :class="option.icon" v-if="option.icon"></i>
                                {{option.name}}:{{collect(option.items).pluck('name').implode(',')}}
                            </div>
                        </span>
                        <span v-else-if="props.field.type =='code'">
                            <code v-if="props.field.limit">
                                {{props.row | array_get(props.k) | str_limit(props.field.limit)}}
                            </code>
                            <code v-else>
                                  {{props.row | array_get(props.k)}}
                            </code>
                        </span>
                        <span v-else-if="props.field.type =='pre'">
                            <pre v-if="props.field.limit">{{props.row | array_get(props.k) | str_limit(props.field.limit)}}</pre>
                            <pre v-else>{{props.row | array_get(props.k)}}</pre>
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
            'data-table':()=>import(/* webpackChunkName: "common_components/datatable.vue" */ 'common_components/datatable.vue')
        },
        props: {
        },
        data(){
            return {
                options: {
                    lang_table: 'ai_prompt_templates', //字段翻译
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
                        name: {name: "模板名称", order: true},
                        cue_word: {name: "提示词内容", order: true,type: "code",str_limit:30},
                        content: {name: "模板内容", order: true, type: "pre"},
                        options: {name: "可选项", order: true},
                        created_at: {name: "Created At", order: true, type: "time"},
                        updated_at: {name: "Updated At", order: true, type: "time"}
                    }
                }
            };
        },
        computed:{
            ...mapState([
                'use_url',
                'theme'
            ])
        },
        methods:{
            collect(items){
                return collect(items);
            }

        }
    };
</script>
<style lang="scss" scoped>


</style>
