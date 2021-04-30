<template>
    <div class="admin_user_edit">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options">
                    <template slot="content" slot-scope="props">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="menu_id" :options="{name: '操作菜单', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['menu_id']"
                                                 :default-options="array_get(props,'data.row.menu.id',0)?[array_get(props,'data.row.menu')]:[]"
                                                 :url="use_url+'/admin/menus/list'"
                                                 :keyword-key="'name|url'"
                                                 :disabled="!props.url"
                                                 :placeholder-show="'请选择操作菜单'"
                                                 :placeholder-value="'0'"
                                                 :is-ajax="true" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="menu_id" :options="{name: '操作者', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['user_id']"
                                                 :default-options="array_get(props,'data.row.user.id',0)?[array_get(props,'data.row.user')]:[]"
                                                 :url="use_url+'/admin/users/list'"
                                                 :keyword-key="'name'"
                                                 :disabled="!props.url"
                                                 :placeholder-show="'请选择操作者'"
                                                 :placeholder-value="'0'"
                                                 :is-ajax="true" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="location" :options="{name: props.transField('Position'), required: true}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="ip" :options="{name: props.transField('IP address'), required: true}"  :datas="props">
                            </edit-item>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="parameters" :options="{name: props.transField('Request parameters'), required: true}"  :datas="props">
                                <template slot="input-item">
                                    <json-view :deep="3" style="height: 295px;overflow: scroll" :closed="false" :theme="'one-dark'"  :data="JSON.parse(array_get(props,'data.row.parameters','{}'))"/>
                                </template>
                            </edit-item>

                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <edit-item key-name="return" :options="{name: props.transField('Return data'), required: true}"  :datas="props">
                                <template slot="input-item">
                                    <json-view :deep="3" style="height: 500px;overflow: scroll"  :closed="false" :theme="'one-dark'"  :data="JSON.parse(array_get(props,'data.row.return','{}'))"/>
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
        components:{
            'edit':()=>import(/* webpackChunkName: "common_components/edit.vue" */ 'common_components/edit.vue'),
            "edit-item": ()=>import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
            "select2":()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),
            "json-view":()=>import(/* webpackChunkName: "vue-json-views/build/index.js" */ 'vue-json-views/build/index.js')
        },
        props: {
        },
        data(){
            return {
                options:{
                    lang_table:'logs',
                    id:'edit', //多个组件同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    params:this.$router.currentRoute.query || {}
                }
            };
        },computed:{
            ...mapState([
                'use_url'
            ])
        }
    };
</script>
