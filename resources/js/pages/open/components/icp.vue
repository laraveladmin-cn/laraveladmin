<template>
    <p class="text-center icp">

        <span class="wangjing">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        备案号:{{icp}}
    </p>
</template>

<script>
    import { mapState } from 'vuex';
    export default {
        data(){
            return {};
        },
        computed:mapState({
            icp: state => state.icp
        })
    }
</script>

<style scoped>

</style>