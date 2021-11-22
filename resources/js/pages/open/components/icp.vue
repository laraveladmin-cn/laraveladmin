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
    .wangjing{
        height: 19px;
        width: 19px;
        background:url('/dist/img/wangjing.png') no-repeat
    }
    .icp{
        margin-top: 10px;
    }
</style>
