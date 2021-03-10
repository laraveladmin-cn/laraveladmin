<template>
    <div>
        <modal v-model="modal" class-name="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
            <icons-view v-model="val" :callback="closeModal"></icons-view>
        </modal>
        <div class="input-group">
            <input :type="type"
                   v-model="val"
                   :disabled="disabled_status"
                   @blur="$emit('blur')"
                   @keydown.enter="$emit('keydown-enter')"
                   class="form-control"
                   :placeholder="placeholder">
            <div class="input-group-addon" @click="openModal">
                <i class="fa" :class="val"></i>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "iconEdit",
        components:{
            "modal":()=>import(/* webpackChunkName: "common_components/modal.vue" */ 'common_components/modal.vue'),
            "icons-view":()=>import(/* webpackChunkName: "common_components/iconsView.vue" */ 'common_components/iconsView.vue'),
        },
        props:{
            placeholder:{
                type:[String],
                default: function () {
                    return '请输入';
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
                modal:false
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
            openModal(){
                if(this.disabled_status){
                    return;
                }
                this.modal = true;
            },
            closeModal(){
                this.modal = false;
            }
        },
        computed:{
            disabled_status(){
                return this.disabled;
            }
        }
    }
</script>

<style scoped>

</style>
