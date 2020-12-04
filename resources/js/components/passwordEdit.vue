<template>
    <div class="input-group">
        <input :type="type"
               v-model="password"
               :disabled="disabled"
               @blur="$emit('blur')"
               @keydown.enter="$emit('keydown-enter')"
               class="form-control"
               :placeholder="placeholder">
        <div class="input-group-addon">
            <i class="fa fa-eye" v-show="type=='password'" @click="toggle"></i>
            <i class="fa fa-eye-slash" v-show="type!='password'" @click="toggle"></i>
        </div>
    </div>
</template>

<script>
    export default {
        name: "passwordEdit",
        props:{
            placeholder:{
                type:[String],
                default: function () {
                    return '请输入密码';
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
                password:this.value,
                type:'password'
            };
        },
        watch:{
            value(val){
                if(this.password!=val){
                    this.password = val;
                }
            },
            password(val){
                this.$emit('input', val); //修改值
                this.$emit('change',val); //修改值
            }
        },
        methods:{
            toggle(){
                this.type = this.type=='password'?'text':'password';
            }
        }
    }
</script>

<style scoped>

</style>
