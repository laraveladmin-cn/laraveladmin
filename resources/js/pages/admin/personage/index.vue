<template>
    <div class="admin_personage_index">
        <div class="box" :class="'box-'+theme">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Data modification')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options">
                    <template slot="content" slot-scope="props">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="avatar" :options="{name: props.transField('Head portrait')}"  :datas="props">
                                <template slot="input-item">
                                    <upload v-model="props.data.row['avatar']"
                                            :placeholder-value="'/dist/img/user_default_180.gif'"
                                            :disabled="!props.url">
                                    </upload>
                                </template>
                            </edit-item>
                            <edit-item key-name="uname" :options="{name: props.transField('User name'),disabled:true, rules:'required|alpha_dash|min:5|max:18'}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="name" :options="{name:props.transField('Name') ,rules:'required|min:2'}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="description" :options="{name: props.transField('Personality signature'),type:'textarea'}"  :datas="props">
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
            "upload":()=>import(/* webpackChunkName: "common_components/upload.vue" */ 'common_components/upload.vue'),
        },
        props: {
        },
        data(){
            return {
                options:{
                    lang_table:'users',
                    id:'edit', //多个组件同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    params:this.$router.currentRoute.query || {},
                    callback:(response,row)=>{ //修改成功
                        if(row.id==this.user.id){
                            this.getUser(1);
                        }
                    },
                    no_back:true,
                    method:'post'
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
