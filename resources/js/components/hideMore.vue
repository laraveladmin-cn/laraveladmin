<template>
    <div class="box" style="border-top:0px">
        <div class="box-body no-padding">
            <div class="row">
                <slot></slot>
                <slot name="hide" v-if="show_more"> </slot>
            </div>
        </div>
        <div class="box-footer text-center" v-show="tool">
            <a href="javascript:void(0)" @click="showMore" class="uppercase" v-show="!show_more">显示全部</a>
            <a href="javascript:void(0)" @click="showMore" class="uppercase" v-show="show_more">隐藏更多</a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "hideMore",
        props: {
            tool:{
                default:function () {
                    return true;
                }
            },
        },
        data(){
            return {
                show_more:false
            };
        },
        methods:{
            showMore(){
                this.show_more = !this.show_more;
            }
        }
    }
</script>

<style scoped>

</style>
