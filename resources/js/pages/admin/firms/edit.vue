<template>
    <div class="admin_user_edit">
        <div class="box" :class="'box-'+theme">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Quickly fill in')}}
                </h3>
            </div>
            <div class="box-body">
                <edit :options="options">
                    <template slot="content" slot-scope="props">
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="name" :options="{name: props.transField('Name'), required: true}"
                                :datas="props">
                            </edit-item>
                            <edit-item key-name="full_name" :options='{"name": props.transField("Full name"), "required": true}' :datas="props">
                            </edit-item>
                            <edit-item key-name="url" :options='{"name": props.transField("Company official website"), "required": false,title:$tp("http or https begins")}' :datas="props">
                                <template slot="input-item">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            v-model="props.data.row['url']"
                                            class="form-control"
                                            :placeholder="$t('Please enter')"
                                        :disabled="!props.url">
                                        <div class="input-group-addon">
                                            <a v-if="props.data.row['url']" :href="props.data.row['url']" target="_blank">
                                                <i class="fa fa-link">
                                                </i>
                                            </a>
                                            <i v-else class="fa fa-link">
                                            </i>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="service_api" :options='{"name": props.transField("Online Insurance Service Provider"), "required": false,"type":"select","placeholderValue":""}' :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['service_api']"
                                            :disabled="!props.url"
                                            :default-options="props.maps['service_api']"
                                            :placeholder-value="''"
                                            :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="uname_rule" :options='{"name": props.transField("Agent account rules"), "required": false,"type":"select"}' :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['uname_rule']"
                                            :disabled="!props.url"
                                            :default-options="props.maps['uname_rule']"
                                            :placeholder="false"
                                            :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="password_rule" :options='{"name": props.transField("Proxy account password rules"), "required": false,"type":"select"}' :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['password_rule']"
                                            :disabled="!props.url"
                                            :default-options="props.maps['password_rule']"
                                            :placeholder="false"
                                            :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item v-show="props.data.row['password_rule']==2" key-name="default_password" :options='{"name": props.transField("Fixed default password"), "required": true}' :datas="props">
                            </edit-item>
                            <edit-item key-name="url_rule" :options='{"name": props.transField("Link address rules", "required"), "required": false,"type":"select"}' :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['url_rule']"
                                            :disabled="!props.url"
                                            :default-options="props.maps['url_rule']"
                                            :placeholder="false"
                                            :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="description" :options='{"name": props.transField("Describe"), "required": false,"type":"textarea","title":$t("Prompt message")}' :datas="props">
                            </edit-item>
                            <edit-item v-show="props.data.row['url_rule']==1" key-name="url_rule_tpl" :options='{"name": props.transField("Link address rule template"), "required": true}' :datas="props">
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="logo" :options='{"name": props.transField("Brand logo"), "required": false}' :datas="props">
                                <template slot="input-item">
                                    <upload :width="355" :height="200"
                                        v-model="props.data.row['logo']"
                                        :disabled="!props.url"
                                        :value-key="'url'">
                                    </upload>
                                </template>
                            </edit-item>
                            <edit-item key-name="account_day_by_sign_at" :options='{"name": props.transField("Business month calculated by signing date"), "required": false}' :datas="props">
                                <template slot="input-item">
                                    <div>
                                        <el-input-number
                                            class="w-100" :min="0" :max="28" size="medium" v-model="props.data.row['account_day_by_sign_at']" :disabled="!props.url" :step="1">
                                        </el-input-number>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="account_day_by_end_at" :options='{"name": props.transField("Return receipt input date Calculation business month"), "required": false}' :datas="props">
                                <template slot="input-item">
                                    <div>
                                        <el-input-number
                                            class="w-100" :min="0" size="medium" :max="28" v-model="props.data.row['account_day_by_end_at']" :disabled="!props.url" :step="1">
                                        </el-input-number>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="order" :options='{"name": props.transField("Sort"), "required": false}' :datas="props">
                                <template slot="input-item">
                                    <div>
                                        <el-input-number class="w-100" :min="0" size="medium" v-model="props.data.row['order']"
                                            :disabled="!props.url" :step="1">
                                        </el-input-number>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="account_at_merge" :options='{"name": props.transField("Consolidated expected settlement month"), "required": false}'                                        :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <el-switch v-model="props.data.row['account_at_merge']"
                                            :disabled="!props.url"
                                            :active-text="$t('Open')"
                                            :inactive-text="$t('Closed')"
                                            :active-value="1"
                                            :inactive-value="0">
                                        </el-switch>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="receipt_type" :options='{"name": props.transField("Receipt template type"), "required": false,"type":"select"}' :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['receipt_type']"
                                                 :disabled="!props.url"
                                                 :default-options="props.maps['receipt_type']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="receipt_url" :options='{"name": props.transField("Pdf template")}' :datas="props" v-show="props.data.row['receipt_type']==0">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <qiniu-upload :token-url="'/open/qi-niu/token?disk=qiniu_public'"
                                                      :root-path="'uploads/pdfs/'"
                                                      :accept="'.pdf'"
                                                      :disabled="!props.url"
                                                      v-model="props.data.row['receipt_url']">
                                        </qiniu-upload>
                                    </div>
                                </template>
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="bank_ids" :options='{"name": props.transField("Support bank selection"), "required": false,type:"checkbox"}'  :datas="props">
                                <template slot="input-item">
                                    <select-many v-model="props.data.row['bank_ids']"
                                                 :options="props.data.row['banks']"
                                                 :url="'/admin/banks/list'"
                                                 :keyword-key="'name'"
                                                 :item-url="'/admin/banks/'"
                                                 :disabled="!props.url"
                                    >
                                    </select-many>
                                </template>
                            </edit-item>

                        </div>
                        <div class="move-items col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <edit-item :options='{"name": props.transField("Content template")}' :key-name="'receipt_tmp'" v-show="props.data.row['receipt_type']==1">
                                <template slot="input-item">
                                    <div>
                                        <tinymce v-model="props.data.row['receipt_tmp']" :disabled="!props.url">
                                        </tinymce>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item :options='{"name": props.transField("Insurance notice"), "required": false,"title":$t("Prompt message")}' :key-name="'insure_notify'">
                                <template slot="input-item">
                                    <div>
                                        <editor-md v-model="props.data.row['insure_notify']" :disabled="!props.url">
                                        </editor-md>
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
        components: {
            'edit':()=>import(/* webpackChunkName: "common_components/edit.vue" */ 'common_components/edit.vue'),
            'el-input-number':()=>import(/* webpackChunkName: "element-ui/lib/input-number" */ 'element-ui/lib/input-number'),
            'edit-item':()=>import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
            'el-switch':()=>import(/* webpackChunkName: "element-ui/lib/switch" */ 'element-ui/lib/switch'),
            'editor-md':()=>import(/* webpackChunkName: "common_components/editorMd.vue" */ 'common_components/editorMd.vue'),
            'upload':()=>import(/* webpackChunkName: "common_components/upload.vue" */ 'common_components/upload.vue'),
            'icheck':()=>import(/* webpackChunkName: "common_components/icheck.vue" */ 'common_components/icheck.vue'),
            'select2':()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),
            'hide-more':()=>import(/* webpackChunkName: "common_components/hideMore" */ 'common_components/hideMore'),
            'qiniu-upload':()=>import(/* webpackChunkName: "common_components/qiniuUpload.vue" */ 'common_components/qiniuUpload.vue'),
            'tinymce':()=>import(/* webpackChunkName: "common_components/tinymce.vue" */ 'common_components/tinymce.vue'),
            'select-many':()=>import(/* webpackChunkName: "common_components/selectMany" */ 'common_components/selectMany'),

        },
        props: {},
        computed:{
            ...mapState([
                '_token',
                'use_url',
                'theme'
            ]),
        },
        data() {
            return {
                "{lang_path}":'admin.firms',
                options:{
                    lang_table:'firms',
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
