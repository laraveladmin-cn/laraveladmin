<template>
    <div>
        <div ref="input" :contenteditable="!disabled" class="inline edit-input" @blur="onBlur" @focus="onFocus">
            {{show}}
        </div>
         <span v-if="unit">
            {{unit}}
        </span>
    </div>
</template>

<script>
    export default {
        name: "divInput",
        props:{
            placeholder:{
                type:[String,Function],
                default: function () {
                    return '';
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
            },
            //放大还是缩小
            zoomType:{
                default: function () {
                    return true; //放大
                }
            },
            zoom:{
                default: function () {
                    return 1;
                }
            },
            unit:{
                default: function () {
                    return '%';
                }
            }
        },
        data(){
            let val = this.value;
            return {
                val:val,
            };
        },
        watch:{
            value(val){
                if(this.val!=val){
                    this.val = val;
                }
            },
            val(val){
                if(val!=this.value){
                    this.$emit('input', val); //修改值
                    this.$emit('change',val); //修改值
                }
            },
            disabled(){

            }
        },
        methods:{
            onBlur(){
                let value = this.$refs['input'].textContent.trim();
                if(value==this.placeholder || value===''){
                    this.val = '';
                }else if(this.zoom==1){
                    this.val = value;
                }else if(this.zoomType){
                    this.val = value/this.zoom;
                }else {
                    this.val = value*this.zoom;
                }
            },
            onFocus(){
                if(this.$refs['input'].textContent.trim()==this.placeholder){
                    this.$refs['input'].innerHTML = '';
                }
            }
        },
        computed:{
            show(){
                if(this.val===''){
                    return this.placeholder;
                }
                if(this.zoom==1){
                    return this.val;
                }else if(this.zoomType){ //放大
                    return this.val*this.zoom;
                }else { //缩小
                    return this.val/this.zoom;
                }
            }

        }
    }
</script>

<style scoped>
    .edit-input{
        outline: none;
        min-width: 20px;
    }

</style>