<template>
    <div class="admin_user_edit">
        <div class="box" :class="'box-'+theme">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options">
                    <template slot="content" slot-scope="props">
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="name" :options="{name: props.transField('Name'), required: true}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="full_name" :options="{name: props.transField('Full name'), required: true}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="url" :options='{"name": props.transField("Website address"), "required": false,title:$tp("http or https begins")}' :datas="props">
                                <template slot="input-item">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            v-model="props.data.row['url']"
                                            class="form-control"
                                            :disabled="!props.url"
                                            :placeholder="$t('Please enter')">
                                        <div class="input-group-addon">
                                            <a v-if="props.data.row['url']" :href="props.data.row['url']" target="_blank">
                                                <i class="fa fa-link"></i>
                                            </a>
                                            <i v-else class="fa fa-link"></i>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="ip" :options="{name: props.transField('Binding IP'), required: true}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="mac" :options="{name: props.transField('Server unique ID'), required: true}"  :datas="props">
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
            "el-input-number":()=>import(/* webpackChunkName: "element-ui/lib/input-number" */ 'element-ui/lib/input-number'),
            "edit-item":()=>import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
        },
        props: {
        },
        data(){
            return {
                "{lang_path}":'admin.agent_systems',
                options:{
                    lang_table:'agent_systems',
                    id:'edit', //多个组件同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    params:this.$router.currentRoute.query || {}
                }
            };
        },
        computed:{
            ...mapState([
                'theme'
            ])
        }
    };
</script>
