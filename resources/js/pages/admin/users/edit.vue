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
                            <edit-item key-name="uname" :options="{name: props.transField('User name'), required: true, rules:'required|alpha_dash|min:5|max:18',title:$tp('Must be {min}-{max} non-Chinese characters',{min:5,max:18})}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="password" :options="{name: props.transField('Password'), required: !props.data.row['id'],rules:!props.data.row['id']?'required|min:6|max:18':'min:6|max:18',title:$tp('Must be {min}-{max} characters long',{min:6,max:18})}"  :datas="props">
                                <template slot="input-item">
                                    <password-edit v-model="props.data.row['password']"
                                                   :disabled="!props.url">
                                    </password-edit>
                                </template>
                            </edit-item>
                            <edit-item key-name="name" :options="{name: props.transField('Name'), required: true,rules:'required'}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="description" :options="{name: props.transField('Remarks'), required: false,type:'textarea'}"  :datas="props">
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="email" :options="{name: props.transField('E-mail'), required: !props.data.row.mobile_phone,rules:props.data.row.mobile_phone?'':'required|email'}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="mobile_phone" :options="{name: props.transField('Phone number'), required: !props.data.row.email,rules:props.data.row.email?'':'required|mobile'}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="status" :options="{name: props.transField('State'), required: true}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['status']"
                                                 :disabled="!props.url || props.data.row['id']==1"
                                                 :default-options="props.maps['status']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="avatar" :options="{name: props.transField('Head portrait'), required: false}"  :datas="props">
                                <template slot="input-item">
                                    <upload v-model="props.data.row['avatar']"
                                            :placeholder-value="'/dist/img/user_default_180.gif'"
                                            :disabled="!props.url">
                                    </upload>
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
        },
        props: {
        },
        data(){
            return {
                "{lang_path}":'admin.users',
                options:{
                    lang_table:'users',
                    id:'edit', //多个组件同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    params:this.$router.currentRoute.query || {},
                    callback:(response,row)=>{ //修改成功
                        if(row.id==this.user.id){
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
        },
        computed:{
            ...mapState('user',{
                user:state => state.user
            }),
            ...mapState([
                'theme'
            ]),
        }
    };
</script>
