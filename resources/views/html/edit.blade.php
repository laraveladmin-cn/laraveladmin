<template>
    <?php
    use \Illuminate\Support\Str;
    use \Illuminate\Support\Arr;
    $table_fields_show = collect($table_fields)->filter(function ($item) {
        return !(in_array($item['showType'], ['hidden']) || in_array($item['Field'], ['id', 'created_at', 'updated_at']));
    });
    $components = [
        'markdown'=>[
            'name' => 'editorMd',
            'path' => 'common_components/editorMd.vue',
            'info' => 'markdown编辑器'
        ],
        'ztree' => [
            'name' => 'ztree',
            'path' => 'common_components/ztree.vue',
            'info' => '树状结构异步组件'
        ],
        'ueditor' => [
            'name' => 'ueditor',
            'path' => 'common_components/ueditor.vue',
            'info' => '百度编辑器异步组件'
        ],
        'select2' => [
            'name' => 'select2',
            'path' => 'common_components/select2.vue',
            'info' => '选择框异步组件'
        ],
        'color' => [
            'name' => 'colorpicker',
            'path' => 'common_components/colorpicker.vue',
            'info' => '颜色选择器异步组件'
        ],
        'timeSelect' => [
            'name' => 'el-time-select',
            'path' => 'element-ui/lib/time-select',
            'info' => '时间点选择器异步组件'
        ],
        'timePicker' => [
            'name' => 'el-time-picker',
            'path' => 'element-ui/lib/time-picker',
            'info' => '时间点选择器异步组件'
        ],
        'switch' => [
            'name' => 'el-switch',
            'path' => 'element-ui/lib/switch',
            'info' => '开关异步组件'
        ],
        'slider' => [
            'name' => 'el-slider',
            'path' => 'element-ui/lib/slider',
            'info' => '滑块异步组件'
        ],
        'rate' => [
            'name' => 'el-rate',
            'path' => 'element-ui/lib/rate',
            'info' => '评级异步组件'
        ],
        'num' => [
            'name' => 'el-input-number',
            'path' => 'element-ui/lib/input-number',
            'info' => '数字框异步组件'
        ],
        'upload' => [
            'name' => 'upload',
            'path' => 'common_components/upload.vue',
            'info' => '上传组件'
        ],
        'password' => [
            'name' => 'password-edit',
            'path' => 'common_components/passwordEdit.vue',
            'info' => '密码输入框组件'
        ]
    ];
    $components = collect($components)
        ->only(collect($table_fields)
            ->pluck('showType')
            ->unique()
            ->toArray())
        ->map(function ($item) {
            $item['name'] = Str::studly($item['name']);
            return '            ' . lcfirst($item['name']) . ':()=>import(/* webpackChunkName: "'.$item['path'].'" */ \'' . $item['path'] . '\'), //' . $item['info'];
        })->implode("\n");
        $chunk_count = $table_fields_show->count();
        $chunk_num = $chunk_count<=4?1:($chunk_count<=6?2:3);
    ?>
    <div class="{{$class}}_edit">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">快速填写</h3>
            </div>
            <div class="box-body">
                <edit :options="options">
                    <template slot="content" slot-scope="props">
@foreach ($table_fields_show->chunk(ceil($chunk_count/$chunk_num)) as $table_field_chunk)
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
@foreach ($table_field_chunk as $table_field)
                            <edit-item key-name="{{$table_field['Field']}}" :options="{name: '{{$table_field["info"]}}',type:'{{$table_field['showType']}}', rules:'{{Arr::get($validates,$table_field['Field'],'')}}',title:''}" :datas="props">
@if($table_field['showType']=='date')
                                <template slot="input-item">
                                    <el-date-picker v-model="props.data.row['{{$table_field['Field']}}']"
                                                    @change="props['row']['{{$table_field['Field']}}'] = arguments[0]"
                                                    placeholder="选择日期" type="date" :clearable="false"
                                                    :editable="false" :disabled="!props.url">
                                    </el-date-picker>
                                </template>
@elseif($table_field['showType']=='month')
                                <template slot="input-item">
                                    <el-date-picker v-model="props.data.row['{{$table_field['Field']}}']"
                                                    @change="props['row']['{{$table_field['Field']}}'] = arguments[0]"
                                                    format="yyyy-MM-01" placeholder="选择月份" type="month"
                                                    :clearable="false" :editable="false"
                                                    :disabled="!props.url">
                                    </el-date-picker>
                                </template>
@elseif($table_field['showType']=='ztree')
                                <template slot="input-item">
                                    <ztree v-model="props.data.row['{{$table_field['Field']}}']"
                                           :check-enable="false" :multiple="false" :id="'parent'"
                                           :chkbox-type='{ "Y" : "", "N" : "" }'
                                           :data="props.data.maps['optional_parents']" :disabled="!props.url"></ztree>
                                </template>
@elseif($table_field['showType']=='ueditor')
                                <template slot="input-item">
                                    <ueditor v-model="props.data.row['{{$table_field['Field']}}']"
                                             id="{{$table_field['Field']}}" :disabled="!props.url"
                                             :server-url="global['config']['upload_route']"></ueditor>
                                </template>
@elseif($table_field['showType']=='select2')
                                <template slot="input-item">
@if(str_contains('_id',$table_field['Field']))
                                        <select2 v-model="props.data.row['{{$table_field['Field']}}']"
                                                 :default-options="props.data.maps['{{$table_field['Field']}}']"
                                                 :url="'{{$prefix}}/{{str_replace('_','-',str_replace('_id','',$table_field['Field']))}}/list'"
                                                 :keyword-key="'name'"
                                                 :show="['name']"
                                                 :disabled="!props.url"
                                                 :placeholder="false"
                                                 :is-ajax="true">
                                        </select2>
@else
                                        <select2 v-model="props.data.row['{{$table_field['Field']}}']"
                                                 :default-options="props.data.maps['{{$table_field['Field']}}']"
                                                 :disabled="!props.url"
                                                 :placeholder="false"
                                                 :is-ajax="false">
                                        </select2>
@endif
                                </template>
@elseif($table_field['showType']=='color')
                                <template slot="input-item">
                                    <colorpicker v-model="props.data.row['{{$table_field['Field']}}']"
                                                 :disabled="!props.url">
                                    </colorpicker>
                                </template>
@elseif($table_field['showType']=='timeSelect')
                                <template slot="input-item">
                                    <el-time-select v-model="props.data.row['{{$table_field['Field']}}']"
                                                    :picker-options="{start: '00:00',step: '00:30',end: '23:30'}"
                                                    :disabled="!props.url" placeholder="选择时间">
                                    </el-time-select>
                                </template>
@elseif($table_field['showType']=='timePicker')
                                <template slot="input-item">
                                    <el-time-picker v-model="props.data.row['{{$table_field['Field']}}']"
                                                    :picker-options="{selectableRange: '00:00:00 - 23:59:59'}"
                                                    :disabled="!props.url" placeholder="选择时间点">
                                    </el-time-picker>
                                </template>
@elseif($table_field['showType']=='switch')
                                <template slot="input-item">
                                    <el-switch v-model="props.data.row['{{$table_field['Field']}}']"
                                               :disabled="!props.url" on-color="#13ce66" off-color="#ff4949"
                                               on-value="1" off-value="0">
                                    </el-switch>
                                </template>
@elseif($table_field['showType']=='slider')
                                <template slot="input-item">
                                    <el-slider v-model="props.data.row['{{$table_field['Field']}}']"
                                               :disabled="!props.url">
                                    </el-slider>
                                </template>
@elseif($table_field['showType']=='rate')
                                <template slot="input-item">
                                    <el-rate v-model="props.data.row['{{$table_field['Field']}}']"
                                             :disabled="!props.url" text-template="{value}" show-text
                                             text-color="#ff9900">
                                    </el-rate>
                                </template>
@elseif($table_field['showType']=='num')
                                <template slot="input-item">
                                    <el-input-number v-model="props.data.row['{{$table_field['Field']}}']"
                                                     :disabled="!props.url" :step="1">
                                    </el-input-number>
                                </template>
@elseif($table_field['showType']=='upload')
                                <template slot="input-item">
                                    <upload v-model="props.data.row['{{$table_field['Field']}}']"
                                            :disabled="!props.url">
                                    </upload>
                                </template>
@elseif($table_field['showType']=='password')
                                <template slot="input-item">
                                    <password-edit v-model="props.data.row['{{$table_field['Field']}}']"
                                                   placeholder="请输入{{$table_field['info']}}"
                                                   :disabled="!props.url">
                                    </password-edit>
                                </template>
@elseif($table_field['showType']=='markdown')
                                    <template slot="input-item">
                                        <editor-md v-model="props.data.row['{{$table_field['Field']}}']"
                                                   placeholder="请输入{{$table_field['info']}}"
                                                   :disabled="!props.url">
                                        </editor-md>
                                    </template>
@endif
                            </edit-item>
@endforeach
                        </div>
@endforeach
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
            edit: ()=>import(/* webpackChunkName: "common_components/edit.vue" */ 'common_components/edit.vue'),
            editItem: ()=>import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
{!! $components !!}
        },
        props: {
            url:{
                type: [String],
                default: function () {
                    return '';
                }
            },
            noBack:{
                type: [Boolean],
                default: function () {
                    return false;
                }
            },
            callback:{
                type: [Function],
                default: function () {
                    return function () {};
                }
            },
        },
        data() {
            return {
                options: {
                    id: 'edit', //多个组件同时使用时唯一标识
                    params: null, //默认筛选条件
                    url:this.url || '', //数据表请求数据地址
                    no_back:this.noBack,
                    callback: (response, row) => { //修改成功
                        this.callback();
                    }
                }
            };
        },
        methods: {},
        computed: {
            ...mapState([
                'use_url'
            ])
        },
        watch:{
            url(val){
                this.options.url = val;
            }
        }
    };
</script>
