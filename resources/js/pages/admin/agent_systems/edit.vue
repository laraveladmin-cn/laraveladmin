<template>
    <div class="admin_user_edit">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">快速填写</h3>
            </div>
            <div class="box-body">
                <edit :options="options">
                    <template slot="content" slot-scope="props">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="name" :options="{name: props.transField('Name'), required: true}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="full_name" :options="{name: props.transField('Full name'), required: true}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="url" :options='{"name": props.transField("Website address"), "required": false,title:"http://或https://开头"}' :datas="props">
                                <template slot="input-item">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            v-model="props.data.row['url']"
                                            class="form-control"
                                            :disabled="!props.url"
                                            :placeholder="'请输入网站地址'">
                                        <div class="input-group-addon">
                                            <a v-if="props.data.row['url']" :href="props.data.row['url']" target="_blank">
                                                <i class="fa fa-link"></i>
                                            </a>
                                            <i v-else class="fa fa-link"></i>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="ip" :options="{name: 'IP地址', required: true}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="mac" :options="{name: '唯一标识', required: true}"  :datas="props">
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
            'edit':function(resolve){require(['common_components/edit.vue'], resolve);},
            "el-input-number": function (resolve) {
                require(['element-ui/lib/input-number'], resolve);
            },
            "edit-item": function (resolve) {
                require(['common_components/editItem.vue'], resolve);
            },
        },
        props: {
        },
        data(){
            return {
                options:{
                    lang_table:'agent_systems',
                    id:'edit', //多个组件同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    params:this.$router.currentRoute.query || {}
                }
            };
        }
    };
</script>
