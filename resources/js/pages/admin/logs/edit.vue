<template>
    <div class="admin_user_edit">
        <div class="box" :class="'box-'+theme">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options" ref="edit">
                    <template slot="content" slot-scope="props">
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="menu_id" :options="{name: props.transField('Operation menu'), required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['menu_id']"
                                                 :default-options="mapMenuId(props)"
                                                 :url="use_url+'/admin/menus/list'"
                                                 :keyword-key="'name|url'"
                                                 :disabled="!props.url"
                                                 :placeholder-value="0"
                                                 :is-ajax="true" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="menu_id" :options="{name: props.transField('Operator'), required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['user_id']"
                                                 :default-options="array_get(props,'data.row.user.id',0)?[array_get(props,'data.row.user')]:[]"
                                                 :url="use_url+'/admin/users/list'"
                                                 :keyword-key="'name'"
                                                 :disabled="!props.url"
                                                 :placeholder-value="0"
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
                        <div class="move-items col-lg-8 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="parameters" :options="{name: props.transField('Request parameters'), required: true}"  :datas="props">
                                <template slot="input-item">
                                    <json-view :deep="3" style="height: 295px;overflow: scroll" :closed="false" :theme="'one-dark'"  :data="JSON.parse(array_get(props,'data.row.parameters','{}'))"/>
                                </template>
                            </edit-item>

                        </div>
                        <div class="move-items col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                shared: {
                    "{lang_path}": '_shared.menus',
                    '{lang_root}': ''
                },
                options:{
                    lang_table:'logs',
                    id:'edit', //多个组件同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    params:this.$router.currentRoute.query || {}
                }
            };
        },
        methods:{
            mapMenuId(props){
                let map = array_get(props,'data.row.menu.id',0)?[array_get(props,'data.row.menu')]:[];
                return collect(copyObj(map))
                    .map((item)=>{
                        item.name = this.$tp(item.name,this.shared);
                        return item;
                    })
                    .all();
            }
        },
        computed:{
            ...mapState([
                'use_url',
                'theme'
            ]),

        }
    };
</script>
