<template>
    <div class="admin_user_edit">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options" ref="edit">
                    <template slot="content" slot-scope="props">
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="bind_user" :options="{name:props.transField('Bind an existing account'), required: false}" :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <el-switch v-model="props.data.row['bind_user']"
                                                   :disabled="!props.url"
                                                   @change="changeBindUser"
                                                   :active-text="$t('Yes')"
                                                   :inactive-text="$t('No')"
                                                   :active-value="1"
                                                   :inactive-value="0">
                                        </el-switch>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="user.uname" :options="{name: props.transField('Username','user.uname'), required: true,rules:'required:number'}" :datas="props" v-if="props.data.row['bind_user']">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['user_id']"
                                                 :default-options="array_get(props,'data.row.user.id',0)?[array_get(props,'data.row.user')]:[]"
                                                 @change="changeUser"
                                                 :url="use_url+'/admin/users/list'"
                                                 :keyword-key="'name|uname'"
                                                 :disabled="!props.url"
                                                 :placeholder-value="'0'"
                                                 :params="{where:{admin:0,id:props.data.row['user_id_back']}}"
                                                 :show="['name','uname']"
                                                 :is-ajax="true" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="user.uname" :options="{name: props.transField('Username','user.uname'), required: true, rules:'required|alpha_dash|min:5|max:18',title:$tp('Must be {min}-{max} non-Chinese characters',{min:5,max:18})}" :datas="props" v-else>
                            </edit-item>
                            <edit-item key-name="user.password" :options="{name: props.transField('Password','user.password'), required: (!props.data.row['id'] && !props.data.row['user_id']),rules:(!props.data.row['id'] && !props.data.row['user_id'])?'required|min:6|max:18':'min:6|max:18',title:$tp('Must be {min}-{max} characters long',{min:6,max:18})}" :datas="props">
                                <template slot="input-item">
                                    <password-edit v-model="row_user()['password']"
                                                   :disabled="!props.url">
                                    </password-edit>
                                </template>
                            </edit-item>
                            <edit-item key-name="user.name" :options="{name: props.transField('Name','user.name'), required: true,rules:'required'}" :datas="props">
                            </edit-item>
                            <edit-item key-name="user.email" :options="{name: props.transField('Email','user.email'), required: false,rules:'email'}" :datas="props">
                            </edit-item>
                            <edit-item key-name="user.mobile_phone" :options="{name: props.transField('Mobile phone number','user.mobile_phone'), required: false ,rules:'mobile'}" :datas="props">
                            </edit-item>
                            <edit-item key-name="user.status" :options="{name: props.transField('Status','user.status'), required: true,rules:'required'}" :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="row_user()['status']"
                                                 :disabled="!props.url || props.data.row['id']==1"
                                                 :default-options="array_get(props,'maps.user.status',[])"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="user.description" :options="{name: props.transField('Note','user.description'), required: false,type:'textarea'}" :datas="props">
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12 ">
                            <edit-item key-name="user.avatar" :options="{name: props.transField('Avatars','user.avatar'), required: false}" :datas="props">
                                <template slot="input-item">
                                    <upload v-model="row_user()['avatar']"
                                            :placeholder-value="'/dist/img/user_default_180.gif'"
                                            :disabled="!props.url">
                                    </upload>
                                </template>
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="role_ids" :options="{name: props.transField('User role selection'), required: true,rules:'required'}" :datas="props">
                                <template slot="input-item">
                                    <div>
                                        <ztree v-model="props.data.row['role_ids']"
                                               :disabled="!props.url || props.data.row['id']==1"
                                               :id="'roles'"
                                               :chkbox-type='{"Y": "", "N": "s"}'
                                               :data="map_roles()">
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
                "{lang_path}":'admin.users',
                shared_rule_name: {
                    "{lang_path}": '_shared.datas.roles.name',
                    '{lang_root}': ''
                },
                options:{
                    lang_table:'admins',
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
            map_roles(){
                let data = collect(array_get(this.$refs,'edit.data.maps.roles',[])).each((item)=>{
                    if(typeof item._back_name=="undefined"){
                        item._back_name = item.name;
                    }
                    if(item._language!=this._i18n.locale){
                        item._language = this._i18n.locale;
                        item.name = this.$tp(item['_back_name'],this.shared_rule_name);
                    }
                    return item;
                }).all();
                return data;
            },
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
