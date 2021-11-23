<template>
    <div class="input-group colorpicker-component">
        <input type="text" :disabled="disabled" @blur="$emit('blur')" class="form-control" />
        <span class="input-group-addon"><i></i></span>
    </div>
</template>
<script>
    export default {
        name: "colorpicker",
        data(){
            return {
                changeing:false,
                old_color:'',
                colorpicker:null
            };
        },
        props:{
            value: {
                type:[String, Number],
                default: function () {
                    return '';
                }
            },
            disabled:{
                default: function () {
                    return false;
                }
            }
        },
        methods:{
            init(){
                let $this = this;
                this.intervalTime = setInterval(()=>{
                    if(typeof $.fn.colorpicker=="function"){
                        clearInterval(this.intervalTime);
                        $this.colorpicker = $($this.$el).colorpicker({
                            allowEmpty:true,
                            color: $this.value||null,
                            format: "hex",
                            disable:$this.disabled
                        });
                        $this.colorpicker.on('colorpickerChange', (e,a,b)=> {
                            let value = e.color.toString('hex') || '';
                            value = value=='false'?'':value;
                            if(value==$this.old_color){
                                return ;
                            }
                            $this.old_color = value;
                            $this.changeing = true;
                            if(value!=$this.value){
                                $this.$emit('input', value); //修改值
                                $this.$emit('change',value); //修改值
                            }
                        });
                    }
                },500);
            }
        },
        computed:{

        },
        watch:{
            value(value,oldValue){
                if(!this.changeing && this.colorpicker){
                    $(this.$el).find('i').css('background',value?value:null);
                }
                this.changeing = false;
            },
            disabled(value,oldValue){
                if(this.colorpicker && typeof this.colorpicker.colorpicker=="function"){
                    this.colorpicker.colorpicker(value?'disable':'enable');
                }
            }
        },
        mounted() {
            this.init();
       },
        updated(){

        },
        created() {
            //动态加载js文件
            if(!document.getElementById('colorpicker-js')){
                let editormdJs = document.createElement('script');
                editormdJs.id = 'colorpicker-js';
                editormdJs.type = 'text/javascript';
                editormdJs.src = '/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js';
                document.body.appendChild(editormdJs);
            }
        },
    }
</script>
<style lang="scss">
    @import url('/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css');
</style>
