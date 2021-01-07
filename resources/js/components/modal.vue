<template>
    <div class="modal fade in" v-show="!closed" @click="clickModal">
        <transition
            name="fade"
            enter-active-class="bounceInDown animated"
            leave-active-class="zoomOut animated">
            <div class="row modal-dialog" v-if="value">
                <div :class="className" @click="clickContent($event)">
                    <div class="modal-content">
                        <button type="button" class="btn btn-sm close" @click="close">
                            <i class="fa fa-times"></i>
                        </button>
                        <div>
                            <slot></slot>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        name: "customModal",
        props: {
            value: {
                type: [Boolean],
                default: function () {
                    return false;
                }
            },
            className: {
                type: [String, Object],
                default: function () {
                    return '';
                }
            }
        },
        data() {
            return {
                closed:!this.value
            };
        },
        methods: {
            close() {
                this.$emit('input', false);
                this.$emit('change', false);
            },
            clickModal(){
                this.close();
            },
            clickContent(event){
                if(event) {
                    event.stopPropagation ? event.stopPropagation(): event.cancelBubble = true;
                }
            }
        },
        watch:{
            value(val){
                if(val){
                    this.closed = false;
                }else {
                    setTimeout( () =>{
                        this.closed = true;
                    },500);
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    .modal-dialog {
        width: unset;
    }
    .close {
        position: absolute;
        right: 0px;
        z-index: 1;
        padding: 5px;
    }

    .modal-content {
        position: relative;
    }

    .modal {
        display: inline-block;
        overflow-y: scroll;
    }

    .modal:before {
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
        margin-right: -0.25em;
    }

    .modal-dialog {
        display: inline-block;
        vertical-align: middle;
    }
</style>
