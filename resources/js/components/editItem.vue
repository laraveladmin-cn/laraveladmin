<template>
    <div :data-id="keyName" class="move-item">
        <validation-provider :vid="keyName" :name="options.name" :rules="options.rules || ''" v-slot="{ errors }">
            <div class="form-group edit-item" :class="{'has-error':errors.length>0}">
                <label><span class="required" v-show="options.required || (options.rules || '').indexOf('required')!=-1">*</span>{{options.name}}</label>
                <span class="help-block title pull-right" v-show="options.title && !errors.length">
                <i class="fa fa-info-circle"></i>
                <span>{{options.title || '提示信息'}}</span>
            </span>
                <label class="control-label pull-right" v-show="errors.length>0">
                    <i class="fa fa-warning"></i>
                    <span v-for="error in errors">{{error.replace('is not valid','不是有效的')}}</span>
                </label>
                <div>
                    <slot name="input-item">
                        <input
                            v-if="!options.type || options.type=='input' || options.type=='text'"
                            type="text"
                            v-model="itemObj[_key]"
                            @change="$emit('change',itemObj[_key])"
                            class="form-control"
                            :disabled="!datas.url || options.disabled"
                            :placeholder="'请输入'+options.name">
                        <input
                            v-else-if="options.type=='email'"
                            type="email"
                            v-model="itemObj[_key]"
                            @change="$emit('change',itemObj[_key])"
                            class="form-control"
                            :disabled="!datas.url || options.disabled"
                            :placeholder="'请输入'+options.name">
                        <textarea
                            v-else-if="options.type=='textarea'"
                            v-model="itemObj[_key]"
                            @change="$emit('change',itemObj[_key])"
                            class="form-control"
                            rows="6"
                            :disabled="!datas.url || options.disabled"
                            :placeholder="'请输入'+options.name">
                    </textarea>
                        <select v-else-if="options.type=='select'"
                                class="form-control"
                                v-model="itemObj[_key]"
                                @change="$emit('change',itemObj[_key])"
                                :disabled="!datas.url || options.disabled">
                            <option v-if="typeof options['placeholderValue']!='undefined'" :value="options['placeholderValue']">请选择</option>
                            <option v-for="(val,index) in array_get(datas.data.maps,_map_key)" :value="index">{{val}}</option>
                        </select>
                        <div class="row" v-else-if="options.type=='checkbox'">
                            <div v-for="(item,index) in array_get(datas.data.maps,_map_key)" class="col-sm-4">
                                <label>
                                    <input v-model="itemObj[_key]" @change="$emit('change',itemObj[_key])" :value="index" :disabled="!datas.url || options.disabled" type="checkbox" />
                                    {{item}}
                                </label>
                            </div>
                        </div>
                        <div class="row" v-else-if="options.type=='radio'">
                            <div v-for="(item,index) in array_get(datas.data.maps,_map_key)" class="col-sm-4">
                                <label>
                                    <input v-model="itemObj[_key]" @change="$emit('change',itemObj[_key])" :value="index" :disabled="!datas.url || options.disabled" type="radio"  />
                                    {{item}}
                                </label>
                            </div>
                        </div>
                        <div class="input-group" v-else-if="options.type=='icon'">
                            <input
                                type="text"
                                v-model="itemObj[_key]"
                                @change="$emit('change',itemObj[_key])"
                                class="form-control"
                                :disabled="!datas.url || options.disabled"
                                :placeholder="'请输入'+options.name">
                            <div class="input-group-addon">
                                <i class="fa" :class="itemObj[_key]"></i>
                            </div>
                        </div>
                        <div class="input-group" v-else-if="options.type=='url'">
                            <input
                                type="text"
                                v-model="itemObj[_key]"
                                @change="$emit('change',itemObj[_key])"
                                class="form-control"
                                :disabled="!datas.url || options.disabled"
                                :placeholder="'请输入'+options.name">
                            <div class="input-group-addon">
                                <a v-if="itemObj[_key]" :href="itemObj[_key]" target="_blank">
                                    <i class="fa fa-link"></i>
                                </a>
                                <i v-else class="fa fa-link"></i>
                            </div>
                        </div>
                    </slot>
                </div>
            </div>
        </validation-provider>
    </div>
</template>

<script>
    import {ValidationProvider} from 'vee-validate';
    //表单项目
    export default {
        name: "editItem",
        components: {
            ValidationProvider
        },
        props: {
            //配置选项
            options:{
                type: [Object],
                default: function () {
                    return {};
                }
            },
            datas:{
                type: [Object],
                default: function () {
                    return {
                        error:{},
                        data:{
                            row:{},
                            configUrl:{}
                        }
                    };
                }
            },
            keyName:{
                type: [String],
                default: function () {
                    return '';
                }
            }
        },
        computed:{
            _key(){
                let keys = this.keyName.split('.');
                return keys[keys.length-1];
            },
            itemObj(){
                let keys = this.keyName.split('.');
                keys.pop();
                let _key = keys.join('.');
                if(!_key){
                    return this.datas.data.row;
                }
                return array_get(this.datas,'data.row.'+_key);
            },
            _map_key(){
                return this.options.map_key || this.keyName;
            }
        },
        watch:{
            options(){

            }
        }
    }
</script>

<style scoped>
    .title{
        display: inline-block;
        color: #a4aaae;
    }
    .required{
        color: #dd4b39;
    }
    .edit-item{
        overflow:hidden;
    }
    .edit-item .form-control{
        height: 36px;
    }
    .edit-item textarea.form-control {
        height: auto;
    }
    .edit-item .edit-item-content{
        height: 36px;
    }
    .edit-item textarea.edit-item-content{
        height: auto;
    }
    .edit-item .help-block{
        margin-top: 0px;
        margin-bottom: 5px;
    }
    .move-item{
        cursor: move;
    }

</style>
