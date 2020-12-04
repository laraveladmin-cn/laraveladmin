<template>
    <script :id="'ueditor_'+id" name="content" type="text/plain">
        {{value}}
    </script>
</template>
<script>
    window.UEDITOR_HOME_URL = '/vendor/ueditor/';
    require('./ueditor.config');
    require('ueditor/example/public/ueditor/ueditor.all.min');
    export default {
        data(){
            return {
                changeing:false,
                old_value:''
            };
        },
        props:{
            id:{
                type: [String]
            }, //绑定值
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
            },
            serverUrl:{
                default: function () {
                    return '/ueditor/server';
                }
            }
        },
        methods:{


        },
        computed:{

        },
        watch:{
            value(value,oldValue){
                if(!this.changeing){
                    this.editor.setContent(value || "");
                    this.editor.focus(true);
                    this.editor.blur();
                }
                this.changeing = false;
            },
            disabled(value,oldValue){
                if(value){
                    this.editor.setDisabled('fullscreen');
                }else {
                    this.editor.setEnabled();
                }
            }
        },
        mounted() {
            var $this = this;
            window.UEDITOR_CONFIG.serverUrl = this.serverUrl;
            this.editor = UE.getEditor('ueditor_'+this.id);
            if(this.disabled){
                this.editor.setDisabled('fullscreen');
            }
            let token = document.head.querySelector('meta[name="csrf-token"]');
            this.editor.execCommand('serverparam', '_token', token.content); // 设置 CSRF token.
            this.editor.addListener('contentChange', function(){
                var value = $this.editor.getContent();
                if(value==$this.old_value){
                    return ;
                }
                $this.old_value = value;
                $this.changeing = true;
                $this.$emit('input', value); //修改值
                $this.$emit('change',value); //修改值
            });
            this.editor.addListener('blur', function(){
                $this.$emit('blur');
            });
       },
        updated(){

        }
    }
</script>
