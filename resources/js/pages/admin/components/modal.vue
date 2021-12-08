<template>
    <div class="modal fade in dialog" :class="modal?(modal.type?'modal-'+modal.type:''):''" v-show="showShade">
        <transition
                name="fade"
                enter-active-class="bounceInDown animated"
                leave-active-class="zoomOut animated">
            <div class="modal-dialog" style="bottom: 184px;;height: 184px" v-if="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" @click="close">
                            <span>×</span></button>
                        <h4 class="modal-title">{{modal['title']}}</h4>
                    </div>
                    <div class="modal-body">
                        <p v-html="modal['content']"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" @click="close" v-if="!modal.hideCancel">{{modal['cancelText'] || $t('Close')}}</button>
                        <button type="button" class="btn" :class="'btn-'+theme" @click="affirm">{{modal['affirmText'] || $t('Confirm')}}</button>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations, mapGetters} from 'vuex';

    export default {
        name: "modal",
        data() {
            return {
                shade:false
            };
        },
        computed: {
            ...mapState([
                'modal',
                'theme'
            ]),
            showShade(){
                if(!!this.modal){
                    this.shade = true;
                    return true;
                }else {
                    if(this.shade){
                        setTimeout( () =>{
                            this.shade = false;
                        },500);
                        return true;
                    }else {
                        return false;
                    }
                }
            }
        },
        methods: {
            ...mapMutations({
                set: 'set'
            }),
            clear(){
                this.set({
                    key: 'modal',
                    modal: null
                });
            },
            close() {
                if(typeof this.modal.cancel=="function"){
                    this.modal.cancel();
                }
                this.clear();
            },
            affirm(){
                if(typeof this.modal.callback=="function"){
                    this.modal.callback();
                }
                this.clear();
            }
        },
    }
</script>

<style scoped lang="scss">
    .dialog {
        display: block
    }

    .dialog .modal-dialog {
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        margin: auto;
    }

</style>
