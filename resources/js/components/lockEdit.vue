<template>
    <div class="input-group">
        <input :type="type"
               v-model="val"
               :disabled="disabled_status"
               @blur="$emit('blur')"
               @keydown.enter="$emit('keydown-enter')"
               class="form-control"
               :placeholder="_placeholder">
        <div class="input-group-addon">
            <i class="fa fa-lock" v-show="disabled_status" @click="toggle"></i>
            <i class="fa fa-unlock" v-show="!disabled_status" @click="toggle"></i>
        </div>
    </div>
</template>

<script>
    export default {
        name: "lockEdit",
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
            return {
                val:this.value,
                type:'text',
                disabled_val:true
            };
        },
        watch:{
            value(val){
                if(this.val!=val){
                    this.val = val;
                }
            },
            val(val){
                this.$emit('input', val); //修改值
                this.$emit('change',val); //修改值
            }
        },
        methods:{
            toggle(){
                this.disabled_val = !this.disabled_val;
            }
        },
        computed:{
            disabled_status(){
                return this.disabled || this.disabled_val;
            },
            _placeholder(){
                if(typeof this.placeholder){
                    return this.placeholder();
                }
                return this.$t(this.placeholder);
            }
        }
    }
</script>

<style scoped>

</style>
