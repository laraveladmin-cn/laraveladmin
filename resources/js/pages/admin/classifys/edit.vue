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
                            <edit-item key-name="description" :options='{"name": "描述", "required": false,"type":"textarea","title":"提示信息"}' :datas="props">
                            </edit-item>
                            <edit-item key-name="parent_id" :options='{"name": "所属父级选择", "required": true}' :datas="props">
                                <template slot="input-item">
                                    <div>
                                        <ztree v-model="props.data.row['parent_id']"
                                               :check-enable="false"
                                               :multiple="false"
                                               :disabled="!props.url"
                                               :id="'parent'"
                                               :chkbox-type='{ "Y" : "", "N" : "" }'
                                               :data="props.maps['optional_parents']">
                                        </ztree>
                                    </div>
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
            'edit':function(resolve){require(['common_components/edit.vue'], resolve);},
            "edit-item": function (resolve) {
                require(['common_components/editItem.vue'], resolve);
            },
            "ztree":function(resolve){
                require(['common_components/ztree.vue'], resolve);
            }
        },
        props: {
        },
        data(){
            return {
                options:{
                    lang_table:'classifys',
                    id:'edit', //多个组件同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    params:this.$router.currentRoute.query || {}
                }
            };
        }
    };
</script>
