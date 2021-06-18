<template>
    <div class="admin_user_edit">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options">
                    <template slot="content" slot-scope="props">
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="name" :options="{name: props.transField('Name'), required: true}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="value" :options="{name: props.transField('Value'), required: true}"  :datas="props">
                                <template slot="input-item">
                                    <div>
                                        <el-input-number
                                            class="w-100"
                                            :min="1"
                                            size="medium"
                                            v-model="props.data.row['value']"
                                            :max="105"
                                            :disabled="!props.url"
                                            :step="1">
                                        </el-input-number>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="description" :options='{"name": props.transField("Describe"), "required": false,"type":"textarea","title":$t("Prompt message")}' :datas="props">
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
        components:{
            'edit':()=>import(/* webpackChunkName: "common_components/edit.vue" */ 'common_components/edit.vue'),
            'edit-item':()=>import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
            'el-input-number':()=>import(/* webpackChunkName: "element-ui/lib/input-number" */ 'element-ui/lib/input-number'),
        },
        props: {
        },
        data(){
            return {
                options:{
                    lang_table:'years',
                    id:'edit', //多个组件同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    params:this.$router.currentRoute.query || {}
                }
            };
        }
    };
</script>
