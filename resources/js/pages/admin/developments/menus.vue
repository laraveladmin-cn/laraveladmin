<template>
    <div>
        <menus-index :url="index_ur"></menus-index>
    </div>
</template>

<script>
    export default {
        components:{
            'menus-index':()=>import(/* webpackChunkName: "pages/admin/menus/index" */ 'pages/admin/menus/index.vue'),
        },
        data() {
            return {
                index_ur:'/admin/menus'
            }
        },
        methods:{
            callback(){
            }
        }

    }
</script>

<style scoped>

</style>
