<template>
    <label class="label-text" :title="label">
        <input ref="icheck" v-model="val" :type="type" :value="option" :disabled="disabled">
        <slot v-if="!disabledLabel">
            {{label}}
        </slot>
    </label>
</template>

<script>
    require('icheck/icheck.min');
    require('icheck/skins/all.css');
    export default {
        name: "icheck",
        props:{
            type:{
                type:[String],
                default:function () {
                    return 'checkbox';
                }
            },
            value:{
                default:function () {
                    return [];
                }
            },
            option:{
                default:function () {
                    return '';
                }
            },
            label:{
                type:[String,Number],
                default:function () {
                    return '';
                }
            },
            disabledLabel:{
                type:[Boolean],
                default:function () {
                    return false;
                }
            },
            disabled:{
                default:function () {
                    return false;
                }
            },

        },
        data(){
          return {
              val:this.value,
              icheck:null,
              changeing:false
          }
        },
        watch:{
          val(value){
              this.$emit('input', value); //修改值
              this.$emit('change',value); //修改值
              if((typeof value=="object" && collect(value).filter((val)=>{
                  return val==this.option;
              }).count()) || value==this.option){
                  this.icheck.iCheck('check'); //选中
              }else {
                  this.icheck.iCheck('uncheck'); //不选中
              }
          },
            value(value){
              this.val = value;
            },
            disabled(value){
              if(value){
                  this.icheck.iCheck('disable'); //禁用
              }else {
                  this.icheck.iCheck('enable'); //启用
              }
            },
            disabledLabel(val){
            }
        },
        mounted() {
            let $this = this;
            this.icheck = $(this.$refs.icheck).iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_flat-red',
                increaseArea: '20%'
            }).on('ifChecked', function(event){ //选中
                if(!collect($this.val).filter((val)=>{
                    return val==$this.option;
                }).count()){
                    if(typeof $this.val=="object" && $this.type=='checkbox'){
                        $this.val.push($this.option);
                    }else{
                        $this.val = $this.option;
                    }
                    //$this.clickFun();
                }
            }).on('ifUnchecked', function(event){ //取消选中
                if(collect($this.val).filter((val)=>{
                    return val==$this.option;
                }).count()){
                    if(typeof $this.val=="object"){
                        $this.val = collect($this.val).filter((val)=>{
                            return val!=$this.option;
                        }).all();
                    }else{
                        $this.val = '';
                    }
                    //$this.clickFun();
                }
            });
        },
        methods:{
            clickFun(){
                this.$emit('click');
            }
        },
        beforeDestroy(){
            if(this.icheck){
                this.icheck.iCheck('destroy');
                this.icheck = null;
            }
        }
    }
</script>

<style scoped>
    .label-text{
        display: inline-block;
        height: 24px;
        line-height: 22px;
        vertical-align: bottom;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:nowrap;
    }

</style>
