<template>
    <div class="row">
        <div class="col-xs-6 col-sm-6">
            <input type="text"
                   name="verify"
                   v-model="captcha"
                   @blur="$emit('blur')"
                   class="form-control"
                   :placeholder="$t('enter',{name:$t('captcha')})">
        </div>
        <div class="col-xs-6 col-sm-6 captcha-img">
            <img :src="url+'&time='+time" @click="switchImg">
        </div>
    </div>
</template>
<script>
    export default {
        components: {
        },
        props:{
            //请求数据地址
            url:{
                type:[String],
                default: function () {
                    return '';
                }
            },
            //绑定值
            value: {
                type:[String],
                default: function () {
                    return '';
                }
            }, //默认选项
            data:{
                type: [Object,Array],
                default: function () {
                    return {
                    };
                }
            }
        },
        data(){
            return {
                time:Date.parse(new Date()),
                captcha:this.value
            }
        },
        methods:{
            switchImg(){
                this.time = Date.parse(new Date());
                this.captcha = '';
            }
        },
        watch:{
            value(value,oldValue){
                if(this.captcha!=value){
                    this.captcha = value;
                    this.time = Date.parse(new Date());
                }
            },
            captcha(value,oldValue){
                this.$emit('input', value); //修改值
                this.$emit('change',value); //修改值
            }
        },
        mounted() {

        }
    }
</script>
<style scoped>
    .form-control{
        padding-right: 12px;
    }
    .captcha-img{
        padding-left: 0px;
    }
</style>
