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
                            <edit-item key-name="name" :options="{name: '名称', required: true}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="full_name" :options="{name: '全称', required: true}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="order" :options='{"name": "排序", "required": false}' :datas="props">
                                <template slot="input-item">
                                    <div>
                                        <el-input-number class="w-100"  :min="0" size="medium" v-model="props.data.row['order']"
                                                         :disabled="!props.url" :step="1">
                                        </el-input-number>
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
                    id:'edit', //多个组件同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    params:this.$router.currentRoute.query || {}
                }
            };
        }
    };
</script>
