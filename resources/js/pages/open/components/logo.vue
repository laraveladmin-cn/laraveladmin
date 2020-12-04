<template>
    <div class="login-logo">
        <router-link to="/"><b>{{name_short}}</b>后台系统</router-link>
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    export default {
        name: "logo",
        data(){
            return {};
        },
        computed:mapState([
           'name_short'
        ])
    }
</script>

<style scoped>

</style>
