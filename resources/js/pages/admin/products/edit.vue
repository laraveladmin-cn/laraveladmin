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
                            <edit-item key-name="name" :options="{name: props.transField('Name'), required: true,rules:'required'}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="firm_id" :options="{name: props.transField('Insurance Company','','firms'), required: true,rules:'required'}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['firm_id']"
                                                 :default-options="array_get(props,'data.row.firm.id',0)?[array_get(props,'data.row.firm')]:[]"
                                                 :url="use_url+'/admin/firms/list'"
                                                 :keyword-key="'name'"
                                                 :disabled="!props.url"
                                                 :placeholder-value="0"
                                                 :is-ajax="true" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="uid" :options="{name: props.transField('Unique identification'), required: false}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="pclassify_ids" :options="{name: props.transField('Group of insurance types','','classifys'), required: false}"  :datas="props">
                                <template slot="input-item">
                                    <el-cascader
                                        class="w-100"
                                        v-model="props.data.row['pclassify_ids']"
                                        :disabled="!props.url"
                                        :props="{ expandTrigger: 'hover',value:'id',label:'name' }"
                                        :options="props.maps['pclassify_ids']"
                                        :placeholder="$t('Please select')"
                                        @change="props.data.row['pclassify_id'] = array_get(props,'data.row.pclassify_ids',[]).length?props.data.row['pclassify_ids'][props.data.row['pclassify_ids'].length-1]:0"
                                    >
                                    </el-cascader>
                                </template>
                            </edit-item>
                            <edit-item key-name="classify_id" :options="{name: props.transField('First-level classification','','classifys'), required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['classify_id']"
                                                 :disabled="!props.url"
                                                 :default-options="props.maps['classify_id']"
                                                 :placeholder-value="0"
                                                 @change="props.data.row['classify2_id']=0"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="classify_id" :options="{name:  props.transField('Second classification','','classifys'), required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['classify2_id']"
                                                 :disabled="!props.url"
                                                 :default-options="array_get(props,'data.maps.classify_id.'+props.data.row['classify_id']+'.children',[])"
                                                 :placeholder-value="0"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="company_no" :options="{name: props.transField('Insurance company document number'), required: false}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="no" :options="{name: props.transField('Document number'), required: false}"  :datas="props">
                            </edit-item>
                            <edit-item key-name="is_long_time" :options="{name: props.transField('Long term insurance'), required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['is_long_time']"
                                                 :disabled="!props.url"
                                                 :default-options="props.maps['is_long_time']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item key-name="class" :options="{name: props.transField('Category'), required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['class']"
                                                 :disabled="!props.url"
                                                 :default-options="props.maps['class']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>

                            </edit-item>
                            <edit-item key-name="buy_type" :options="{name: props.transField('Purchase method'), required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['buy_type']"
                                                 :disabled="!props.url"
                                                 :default-options="props.maps['buy_type']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>

                            </edit-item>
                            <edit-item key-name="pay_type" :options="{name: props.transField('Payment method'), required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content-min">
                                        <div class="row">
                                            <div v-for="(item,index) in props.maps['pay_type']" class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                <icheck v-model="props.data.row['pay_type']" :option="index" :disabled="!props.url"> {{item}}</icheck>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="attr" :options="{name: props.transField('Product attributes'), required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['attr']"
                                                 :disabled="!props.url"
                                                 :default-options="props.maps['attr']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>

                            </edit-item>
                            <edit-item key-name="pdf_url" :options="{name: props.transField('Document address'), required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            v-model="props.data.row['pdf_url']"
                                            class="form-control"
                                            :disabled="!props.url"
                                            :placeholder="$t('Please enter')"
                                        >
                                        <div class="input-group-addon">
                                            <a v-if="props.data.row['pdf_url']" :href="props.data.row['pdf_url']" target="_blank">
                                                <i class="fa fa-link"></i>
                                            </a>
                                            <i v-else class="fa fa-link"></i>
                                        </div>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="status" :options="{name: props.transField('State'), required: false}"  :datas="props">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <select2 v-model="props.data.row['status']"
                                                 :disabled="!props.url"
                                                 :default-options="props.maps['status']"
                                                 :placeholder="false"
                                                 :is-ajax="false" >
                                        </select2>
                                    </div>
                                </template>
                            </edit-item>
                            <edit-item key-name="issue_at" :options="{name: props.transField('Release time'), required: false}"  :datas="props">
                                <template slot="input-item">
                                    <el-date-picker
                                        class="w-100"
                                        v-model="props.data.row['issue_at']"
                                        type="datetime"
                                        value-format="yyyy-MM-dd HH:mm:ss"
                                        :disabled="!props.url"
                                        :placeholder="$t('Please select')"
                                    >
                                    </el-date-picker>
                                </template>
                            </edit-item>
                            <edit-item key-name="stop_at" :options="{name: props.transField('Closing date'), required: false}"  :datas="props">
                                <template slot="input-item">
                                    <el-date-picker class="w-100"
                                                    v-model="props.data.row['stop_at']"
                                                    type="date"
                                                    value-format="yyyy-MM-dd"
                                                    :disabled="!props.url"
                                                    :placeholder="$t('Please select')"
                                    >
                                    </el-date-picker>
                                </template>
                            </edit-item>
                            <edit-item key-name="images" :options="{name: props.transField('Preview Poster'), required: false,title:$t('Only picture files can be uploaded and no more than {size}',{size:'2MB'})}"  :datas="props">
                                <template slot="input-item">
                                    <upload  v-model="props.data.row['images'] || images"
                                            :disabled="!props.url"
                                            :value-key="'url'">
                                    </upload>
                                </template>
                            </edit-item>
                        </div>
                        <div class="move-items col-lg-4 col-md-6 col-sm-12 col-xs-12">
                          <edit-item key-name="year_ids" :options='{"name": props.transField("Optional years","","years"), "required": false,type:"checkbox"}'  :datas="props">
                                <template slot="input-item">
                                    <hide-more :tool="count(array_get(props,'data.maps.year_ids',[]))>33">
                                        <template>
                                            <div v-for="(item,index) in props.maps['year_ids']" class="col-lg-4 col-md-4 col-sm-4 col-xs-4" v-if="index<=33">
                                                <icheck v-model="props.data.row['year_ids']" :option="index" :disabled="!props.url"> {{item}}</icheck>
                                            </div>
                                        </template>
                                        <template slot="hide">
                                            <div v-for="(item,index) in props.maps['year_ids']" class="col-lg-4 col-md-4 col-sm-4 col-xs-4" v-if="index>33">
                                                <icheck v-model="props.data.row['year_ids']" :option="index" :disabled="!props.url"> {{item}}</icheck>
                                            </div>
                                        </template>
                                    </hide-more>
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
            'el-input-number':()=>import(/* webpackChunkName: "element-ui/lib/input-number" */ 'element-ui/lib/input-number'),
            'edit-item':()=>import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
            'el-switch':()=>import(/* webpackChunkName: "element-ui/lib/switch" */ 'element-ui/lib/switch'),
            'editor-md':()=>import(/* webpackChunkName: "common_components/editorMd.vue" */ 'common_components/editorMd.vue'),
            'upload':()=>import(/* webpackChunkName: "common_components/upload.vue" */ 'common_components/upload.vue'),
            'icheck':()=>import(/* webpackChunkName: "common_components/icheck.vue" */ 'common_components/icheck.vue'),
            'select2':()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),
            'hide-more':()=>import(/* webpackChunkName: "common_components/hideMore" */ 'common_components/hideMore'),
            'el-date-picker':()=>import(/* webpackChunkName: "element-ui/lib/date-picker" */ 'element-ui/lib/date-picker'),
            "el-cascader":()=>import(/* webpackChunkName: "element-ui/lib/cascader" */ 'element-ui/lib/cascader'),
        },
        props: {
        },
        data(){
            return {
                options:{
                    lang_table:'products',
                    id:'edit', //多个组件同时使用时唯一标识
                    url:'', //数据表请求数据地址
                    params:this.$router.currentRoute.query || {}
                },
                images:[]
            };
        },
        methods: {
        },
        computed:{
            ...mapState([
                'api_url',
                'use_url',
                'theme'
            ]),
        }
    };
</script>
<style scoped>
    .edit-item-content-min{
        min-height: 36px
    }
</style>
