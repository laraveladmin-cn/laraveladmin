<template>
    <el-drawer
        :direction="'rtl'"
        title="组件选择"
        :with-header="false"
        :visible.sync="drawer">
        <div class="demos">
            <password-edit>
            </password-edit>
        </div>

    </el-drawer>
</template>

<script>
    export default {
        name: "componentDemos",
        components:{
            "el-drawer": ()=>import(/* webpackChunkName: "element-ui/lib/drawer" */ 'element-ui/lib/drawer'),
            "edit-item": ()=>import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
            "password-edit": ()=>import(/* webpackChunkName: "common_components/passwordEdit.vue" */ 'common_components/passwordEdit.vue'),

        },
        data(){
            return {
                drawer:false
            }
        },
        methods:{
            open(){
                this.drawer=true;
            }
        }
    }
</script>

<style scoped>
.demos{
    padding: 10px;
}
</style>
