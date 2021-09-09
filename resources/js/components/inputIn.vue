<template>
    <input type="text"
           v-model="val"
           @blur="$emit('blur')"
           :disabled="disabled"
           class="form-control"
           :placeholder="_placeholder">
</template>

<script>
    export default {
        name: "inputIn",
        props:{
            placeholder:{
                type:[String,Function],
                default: function () {
                    return 'Please enter';
                }
            },
            value:{
                default:function () {
                    return '';
                }
            },
            disabled:{
                default: function () {
                    return false;
                }
            }
        },
        data(){
            let val = this.value;
            if(typeof val=="object"){
                val = collect(val).implode(',');
            }
            return {
                val:val,
            };
        },
        watch:{
            value(val){
                if(typeof val=="object"){
                    val = collect(val).implode(',');
                }
                if(this.val!=val){
                    this.val = val;
                }
            },
            val(val){
                if(val){
                    val = val.split(',');
                    if(!val.length){
                        val = '';
                    }
                }
                this.$emit('input', val); //修改值
                this.$emit('change',val); //修改值
            },
            disabled(){

            }
        },
        methods:{
        },
        computed:{
            _placeholder(){
                if(typeof this.placeholder=="function"){
                    return this.placeholder();
                }
                return this.$t(this.placeholder);
            }
        }
    }
</script>

<style scoped>

</style>
