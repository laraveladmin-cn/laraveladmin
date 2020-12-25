<template>
    <div class="admin_user_edit">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">快速填写</h3>
            </div>
            <div class="box-body">
                <edit :options="options" ref="edit">
                    <template slot="content" slot-scope="props">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="bind_user" :options="{name: '绑定已有账户', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <el-switch v-model="props.data.row['bind_user']"
                                                   :disabled="!props.url"
                                                   @change="changeBindUser"
                                                   active-text="是"
                                                   inactive-text="否"
                                                   :active-value="1"
                                                   :inactive-value="0">
                                        </el-switch>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="user.uname" :options="{name: '用户名', required: true,rules:'required:number'}"  :datas="props" v-if="props.data.row['bind_user']">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['user_id']"
                                                 :default-options="array_get(props,'data.row.user.id',0)?[array_get(props,'data.row.user')]:[]"
                                                 @change="changeUser"
                                                 :url="use_url+'/admin/users/list'"
                                                 :keyword-key="'name|uname'"
                                                 :disabled="!props.url"
                                                 :placeholder-show="'请选择用户'"
                                                 :placeholder-value="'0'"
                                                 :params="{where:{admin:0,id:props.data.row['user_id_back']}}"
                                                 :show="['name','uname']"
                                                 :is-ajax="true" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="user.uname" :options="{name: '用户名', required: true, rules:'required|alpha_dash|min:5|max:18',title:'必须是5-18位的非中文字符'}"  :datas="props" v-else>
                            </edit-item>
                            <edit-item key-name="user.password" :options="{name: '密码', required: (!props.data.row['id'] && !props.data.row['user_id']),rules:(!props.data.row['id'] && !props.data.row['user_id'])?'required|min:6|max:18':'min:6|max:18',title:'必须是6-18位的字符'}"  :datas="props">
                                <template slot="input-item">
                                    <password-edit v-model="row_user()['password']"
                                                   :disabled="!props.url">
                                    </password-edit>
                                </template>
                            </edit-item>
                            <edit-item key-name="user.name" :options="{name: '姓名', required: true,rules:'required'}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="user.email" :options="{name: '电子邮箱', required: false,rules:'email'}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="user.mobile_phone" :options="{name: '手机号码', required: false ,rules:'mobile'}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="user.status" :options="{name: '状态', required: true,rules:'required'}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="row_user()['status']"
                                                 :disabled="!props.url || props.data.row['id']==1"
                                                 :default-options="array_get(props,'data.maps.user.status',[])"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="user.description" :options="{name: '备注', required: false,type:'textarea'}"  :datas="props">
                            </edit-item>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="user.avatar" :options="{name: '头像', required: false}"  :datas="props">
                                <template slot="input-item">
                                    <upload v-model="row_user()['avatar']"
                                            :placeholder-value="'/dist/img/user_default_180.gif'"
                                            :disabled="!props.url">
                                    </upload>
                                </template>
                            </edit-item>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="role_ids" :options="{name: '用户角色选择', required: true,rules:'required'}"  :datas="props">
                                <template slot="input-item">
                                    <div>
                                        <ztree v-model="props.data.row['role_ids']"
                                               :disabled="!props.url || props.data.row['id']==1"
                                               :id="'roles'"
                                               :chkbox-type='{"Y": "", "N": "s"}'
                                               :data="props.data.maps['roles']">
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
            'edit':()=>import(/* webpackChunkName: "common_components/edit.vue" */ 'common_components/edit.vue'),
            "edit-item": ()=>import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
            "password-edit": ()=>import(/* webpackChunkName: "common_components/passwordEdit.vue" */ 'common_components/passwordEdit.vue'),
            "select2":()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),
            "upload":()=>import(/* webpackChunkName: "common_components/upload.vue" */ 'common_components/upload.vue'),
            "ztree":()=>import(/* webpackChunkName: "common_components/ztree.vue" */ 'common_components/ztree.vue'),
            "el-switch": ()=>import(/* webpackChunkName: "element-ui/lib/switch" */ 'element-ui/lib/switch'),
        },
        props: {
        },
        data(){
            return {
                options:{
                    id:'edit', //多个组件同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    params:this.$router.currentRoute.query || {},
                    callback:(response,row)=>{ //修改成功
                        if(row.user_id==this.user.id){
                            this.getUser(1);
                        }
                    }
                }
            };
        },
        methods:{
            ...mapActions({
                getUser:'user/getUser', //获取用户数据
            }),
            changeBindUser(val){
                if(!val){
                    this.$refs.edit.data.row.user_id = 0;
                }
            },
            changeUser(user_id){
                axios.get(this.use_url+'/admin/users/'+user_id).then((response)=>{
                    this.$refs.edit.data.row.user = response.data.row;
                }).catch((error)=>{

                });
            },
            row_user(){
                return array_get(this.$refs.edit,'data.row.user',{});
            }
        },
        computed:{
            ...mapState('user',{
                user:state => state.user
            }),
            ...mapState([
                'use_url'
            ])

        }
    };
</script>
