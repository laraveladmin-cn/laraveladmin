<template>
    <transition-group
            name="fade"
            tag="div"
            enter-active-class="swing animated"
            leave-active-class="slideOutUp animated" class="message">
        <div v-bind:key="'message'+index" class="fade-transition alert fade-leave"
             :class="['alert-'+alert['type'], alert['position'],alert['customClass']]" v-if="alert['show']"
             v-for="(alert, index) in alerts">
            <button type="button" v-show="alert['showClose']" @click="close(index)" class="close">
                <span>×</span>
            </button>
            <p>
                <span class="icon fa" :class="alert['iconClass']"></span>
                {{alert['message'] || alert['title']}}
            </p>
        </div>
    </transition-group>
</template>

<script>
    import {mapState, mapActions, mapMutations, mapGetters} from 'vuex';

    export default {
        name: "message",
        data() {
            return {};
        },
        computed: {
            ...mapState([
                'alerts'
            ])
        },
        methods: {
            ...mapMutations({
                closeMessage: 'closeMessage'
            }),
            close(index) {
                this.closeMessage({
                    key: index
                });
            }
        },

    }
</script>

<style scoped lang="scss">
    .message {
        width: 30%;
        min-width: 250px;
        opacity: 0.8;
        position: fixed;
        top: 52px;
        margin: 0 auto;
        left: 0;
        right: 0;
        z-index: 1050;
    }
</style>
