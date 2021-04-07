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
                            <edit-item key-name="full_name" :options='{"name": "全称", "required": true}' :datas="props">
                            </edit-item>
                            <edit-item key-name="url" :options='{"name": "公司官网网址", "required": false,title:"http://或https://开头"}' :datas="props">
                                <template slot="input-item">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            v-model="props.data.row['url']"
                                            class="form-control"
                                            :disabled="!props.url"
                                            :placeholder="'请输入公司官网网址'">
                                        <div class="input-group-addon">
                                            <a v-if="props.data.row['url']" :href="props.data.row['url']" target="_blank">
                                                <i class="fa fa-link"></i>
                                            </a>
                                            <i v-else class="fa fa-link"></i>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="service_api" :options='{"name": "线上投保服务商", "required": false,"type":"select","placeholderValue":""}' :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['service_api']"
                                                 :disabled="!props.url"
                                                 :default-options="props.data.maps['service_api']"
                                                 :placeholder-value="''"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="uname_rule" :options='{"name": "代理账号规则", "required": false,"type":"select"}' :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['uname_rule']"
                                                 :disabled="!props.url"
                                                 :default-options="props.data.maps['uname_rule']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="password_rule" :options='{"name": "代理账号密码规则", "required": false,"type":"select"}' :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['password_rule']"
                                                 :disabled="!props.url"
                                                 :default-options="props.data.maps['password_rule']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item v-show="props.data.row['password_rule']==2" key-name="default_password" :options='{"name": "固定默认密码", "required": true}' :datas="props">
                            </edit-item>
                            <edit-item key-name="url_rule" :options='{"name": "链接地址规则", "required": false,"type":"select"}' :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['url_rule']"
                                                 :disabled="!props.url"
                                                 :default-options="props.data.maps['url_rule']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item v-show="props.data.row['url_rule']==1" key-name="url_rule_tpl" :options='{"name": "链接地址规则模板", "required": true}' :datas="props">
                            </edit-item>

                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="logo" :options='{"name": "品牌LOGO", "required": false}' :datas="props">
                                <template slot="input-item">
                                    <upload :width="370" :height="201"  v-model="props.data.row['logo']"
                                            :disabled="!props.url"
                                            :value-key="'url'">
                                    </upload>
                                </template>
                            </edit-item>


                            <edit-item key-name="account_day_by_sign_at" :options='{"name": "签单日期计算业务月份", "required": false}' :datas="props">
                                <template slot="input-item">
                                    <div>
                                        <el-input-number   class="w-100" :min="0" :max="28" size="medium" v-model="props.data.row['account_day_by_sign_at']" :disabled="!props.url" :step="1">
                                        </el-input-number>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="account_day_by_end_at" :options='{"name": "回执录入日期计算业务月份", "required": false}' :datas="props">
                                <template slot="input-item">
                                    <div>
                                        <el-input-number   class="w-100" :min="0" size="medium" :max="28" v-model="props.data.row['account_day_by_end_at']" :disabled="!props.url" :step="1">
                                        </el-input-number>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="order" :options='{"name": "排序", "required": false}' :datas="props">
                                <template slot="input-item">
                                    <div>
                                        <el-input-number class="w-100" :min="0" size="medium" v-model="props.data.row['order']"
                                                         :disabled="!props.url" :step="1">
                                        </el-input-number>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="account_at_merge" :options='{"name": "合并预计结算月份开关", "required": false}'
                                       :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <el-switch v-model="props.data.row['account_at_merge']"
                                                   :disabled="!props.url"
                                                   active-text="开"
                                                   inactive-text="关"
                                                   :active-value="1"
                                                   :inactive-value="0">
                                        </el-switch>
                                    </div>
                                </template>
                            </edit-item>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="bank_ids" :options='{"name": "支持银行选择", "required": false,type:"checkbox"}'  :datas="props">
                                <template slot="input-item">
                                    <hide-more :tool="count(array_get(props,'data.maps.bank_ids',[]))>33">
                                        <template>
                                            <div v-for="(item,index) in props.data.maps['bank_ids']" class="col-lg-4 col-md-4 col-sm-4 col-xs-4" v-if="index<=33">
                                                <icheck v-model="props.data.row['bank_ids']" :option="index" :disabled="!props.url" :label="item"> {{item}}</icheck>
                                            </div>
                                        </template>
                                        <template slot="hide">
                                            <div v-for="(item,index) in props.data.maps['bank_ids']" class="col-lg-4 col-md-4 col-sm-4 col-xs-4" v-if="index>33">
                                                <icheck v-model="props.data.row['bank_ids']" :option="index" :disabled="!props.url" :label="item"> {{item}}</icheck>
                                            </div>
                                        </template>
                                    </hide-more>
                                </template>
                            </edit-item>
                            <edit-item key-name="description" :options='{"name": "描述", "required": false,"type":"textarea","title":"提示信息"}' :datas="props">
                            </edit-item>
                        </div>
                        <edit-item :options='{"name": "投保须知", "required": false,"title":"提示信息"}' :key-name="'insure_notify'" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <template slot="input-item">
                                <div>
                                    <editor-md v-model="props.data.row['insure_notify']" :disabled="!props.url">
                                    </editor-md>
                                </div>
                            </template>
                        </edit-item>
                    </template>
                </edit>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations, mapGetters} from 'vuex';

    export default {
        components: {
            'edit': function (resolve) {
                require(['common_components/edit.vue'], resolve);
            },
            "el-input-number": function (resolve) {
                require(['element-ui/lib/input-number'], resolve);
            },
            "edit-item": function (resolve) {
                require(['common_components/editItem.vue'], resolve);
            },
            "el-switch": function (resolve) {
                require(['element-ui/lib/switch'], resolve);
            },
            "editor-md": function (resolve) {
                require(['common_components/editorMd.vue'], resolve);
            },
            "upload":function(resolve){
                require(['common_components/upload.vue'], resolve);
            },
            "icheck":function(resolve){
                require(['common_components/icheck.vue'], resolve);
             },
            "select2":function(resolve){
                require(['common_components/select2.vue'], resolve);
            },
            "hide-more": function (resolve) {
                require(['common_components/hideMore'], resolve);
            },
        },
        props: {},
        computed:{
            ...mapState([
                '_token',
                'use_url',
            ]),
        },
        data() {
            return {
                options: {
                    id: 'edit', //多个组件同时使用时唯一标识
                    url: '', //数据表请求数据地址
                    params: this.$router.currentRoute.query || {}
                },
            };
        },
        methods: {
        }
    };
</script>
