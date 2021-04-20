<template>
    <div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <textarea
                    v-model="value_str"
                    class="form-control"
                    rows="14"
                    :disabled="disabled"
                    @blur="$emit('blur')"
                    :placeholder="$t(placeholder)">
                </textarea>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <json-view :deep="3" style="height: 295px;overflow: scroll" :closed="false" :theme="'one-dark'"  :data="value"/>
            </div>

        </div>
    </div>

</template>

<script>
    export default {
        name: "jsonEdit",
        components:{
            "json-view":()=>import(/* webpackChunkName: "vue-json-views/build/index.js" */ 'vue-json-views/build/index.js')
        },
        props:{
            placeholder:{
                type:[String],
                default: function () {
                    return 'Please enter';
                }
            },
            value:{
                default:function () {
                    return {};
                }
            },
            disabled:{
                default: function () {
                    return false;
                }
            },
        },
        data(){
            return {
                value_str:this.value?JSON.stringify(this.value):'{}'
            };
        },
        watch:{
            value(val){
                let str = this.value?JSON.stringify(this.value):'{}';
                if(str!=this.value_str){
                    this.value_str = str;
                }
            },
            value_str(val){
                let obj = {};
                if(this.isJSON(val)){
                    obj = JSON.parse(val);
                    this.$emit('input', obj); //修改值
                    this.$emit('change',obj); //修改值
                }
            }
        },
        methods:{
            isJSON(str) {
                if (typeof str == 'string') {
                    try {
                        JSON.parse(str);
                        return true;
                    } catch(e) {
                        return false;
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>
