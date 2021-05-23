<template>
    <validation-provider :vid="options.key" :custom-messages="options.messages || null"  :name="options.name" :rules="options.rules || ''" v-slot="{ errors }">
        <div class="form-group has-feedback"  :class="{'has-error':errors.length>0}">
            <label class="control-label" v-if="options.label!==false || (errors.length && options.messages!==false)">
                {{options.label!==false?options.name+'：':''}}
            </label>
            <label class="control-label pull-right text-light-blue title-label" v-show="options.title && (!errors.length || options.messages===false)">
                <i class="fa fa-info-circle"></i>
                <span>{{options.title}}</span>
            </label>
            <label class="control-label pull-right" v-if="options.messages!==false">
                <i class="fa fa-times-circle-o" v-show="errors.length>0" ></i>
                <span v-for="value in errors">
                    {{value}}
                </span>
            </label>
            <div class="clearfix"></div>
            <div class="form-input">
                <slot>
                    <input :type="options.type || 'text'" :name="options.key" v-model="data" class="form-control" :placeholder="_placeholder">
                </slot>
                <span class="form-control-feedback" :class="icon" v-if="icon"></span>
            </div>
        </div>
    </validation-provider>
</template>

<script>
    import {ValidationProvider} from 'vee-validate';
    //表单项目
    export default {
        name: "formItem",
        components: {
            ValidationProvider
        },
        props: {
            //配置选项
            options:{
                type: [Object],
                default() {
                    return {};
                }
            },
            value:{
                default() {
                    return '';
                }
            }
        },
        computed:{
            icon(){
                if(!this.options.icon){
                    return '';
                }
                if(this.options.icon.indexOf('glyphicon')!=-1){
                    return 'glyphicon '+this.options.icon;
                }
                return 'fa '+this.options.icon;
            },
            _placeholder(){
                if(typeof this.options.placeholder=="function"){
                    return this.options.placeholder();
                }
                return this.options.placeholder || this.$t('enter',{name:this.options.name});
            },
        },
        data(){
            return {
                data:this.value
            };
        },
        watch:{
            data(val,old) {
                if(val!=this.value){
                    this.$emit('input', val); //修改值
                    this.$emit('change',val); //修改值
                }
            },
            value(val,old){
                if(val!=this.data){
                    this.data = val;
                }
            },
            options(){

            }
        }
    }
</script>

<style scoped>
    .has-feedback label~.form-control-feedback{
        top: 0px;
    }
    .control-label{
        margin-bottom:0px;
    }
    .title-label{
        font-weight: 500;
        font-size: 12px;
    }
    .form-input{
        position: relative;
    }

</style>
