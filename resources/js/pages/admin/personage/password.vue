<template>
    <div class="admin_personage_password">
        <div class="box" :class="'box-'+theme">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}</h3>
            </div>
            <div class="box-body">
                <edit :options="options">
                    <template slot="content" slot-scope="props">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="old_password" :options="{name: props.transField('Old password'),rules:'required|min:6|max:18'}"  :datas="props">
                                <template slot="input-item">
                                    <password-edit v-model="props.data.row['old_password']"
                                                   :disabled="!props.url">
                                    </password-edit>
                                </template>
                            </edit-item>
                            <edit-item key-name="password" :options="{name: props.transField('New password'),rules:'min:6|max:18'}"  :datas="props">
                                <template slot="input-item">
                                    <password-edit v-model="props.data.row['password']"
                                                   :disabled="!props.url">
                                    </password-edit>
                                </template>
                            </edit-item>
                            <edit-item key-name="password_confirmation" :options="{name: props.transField('Confirm the new password'),rules:props.data.row['password']?'required|confirmed:password':''}"  :datas="props">
                                <template slot="input-item">
                                    <password-edit v-model="props.data.row['password_confirmation']"
                                                   :disabled="!props.url">
                                    </password-edit>
                                </template>
                            </edit-item>
                            <edit-item key-name="email" :options="{name: props.transField('Email'),rules:props.data.row.mobile_phone?'':'required|email'}"  :datas="props">
                                <template slot="input-item">
                                    <lock-edit v-model="props.data.row['email']"
                                               :disabled="!props.url">
                                    </lock-edit>
                                </template>
                            </edit-item>
                            <edit-item key-name="mobile_phone" :options="{name: props.transField('Phone number'),rules:props.data.row.email?'':'required|mobile'}"  :datas="props">
                                <template slot="input-item">
                                    <lock-edit v-model="props.data.row['mobile_phone']"
                                               :disabled="!props.url">
                                    </lock-edit>
                                </template>
                            </edit-item>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                            <edit-item v-if="array_get(props,'data.row.ousers',[]).length" key-name="unbind_ids" :options="{name:  props.transField('Tripartite login')}"  :datas="props">
                                <template slot="input-item">
                                    <div class="social-auth-links text-center other-login">
                                        <div class="row">
                                            <div class="col-xs-3" v-for="item in array_get(props,'data.row.ousers',[])" style="margin-bottom: 10px">
                                                <div v-if="!array_get(item,'data.avatar')"
                                                     class="img-circle icon login-icon center-block"
                                                     :class="'ouser-'+array_get(getOuser(item,props.maps),'class','')">
                                                    <i class="fa" :class="'fa-'+array_get(getOuser(item,props.maps),'icon','')"></i>
                                                </div>
                                                <img v-else class="img-circle icon login-icon center-block" :src="array_get(item,'data.avatar','')">
                                                <div class="center-block">
                                                    <i class="fa" :class="'fa-'+array_get(getOuser(item,props.maps),'icon','')+' ouser-span-'+array_get(getOuser(item,props.maps),'class','')"></i>
                                                    {{array_get(getOuser(item,props.maps),'name','')}}<br>
                                                    ({{item | array_get('data.nickname','--') | str_limit(10)}})<br>
                                                    <button type="button" class="btn btn-block btn-primary btn-xs" @click="unbind(item['id'],array_get(props,'data.row',{}))">
                                                        {{$t('Unbundling')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
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
            'lock-edit':()=>import(/* webpackChunkName: "common_components/lockEdit" */ 'common_components/lockEdit'),
            'edit':()=>import(/* webpackChunkName: "common_components/edit.vue" */ 'common_components/edit.vue'),
            "edit-item": ()=>import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
            "password-edit": ()=>import(/* webpackChunkName: "common_components/passwordEdit.vue" */ 'common_components/passwordEdit.vue'),
        },
        props: {
        },
        data(){
            return {
                options:{
                    lang_table:'users',
                    id:'edit', //多个组件同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    params:this.$router.currentRoute.query || {}
                }
            };
        },
        methods:{
            getOuser(item,maps){
                let map = collect(array_get(maps,'ousers.type_show',[])).keyBy('type').all();
                return array_get(map,item['type'],{});
            },
            unbind(id,row){
                row.unbind_ids[row.unbind_ids.length] = id;
                row.ousers = collect(row.ousers).filter(function (item) {
                    return item['id']!=id;
                }).all();
            }
        },
        computed:{
            ...mapState([
                'theme'
            ]),
        }
    };
</script>
