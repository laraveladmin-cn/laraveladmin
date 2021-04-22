<template>
    <p class="text-center icp" v-show="icp">
        <span class="wangjing">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        {{$t('The record number:')}}{{icp}}
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
