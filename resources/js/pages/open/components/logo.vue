<template>
    <div class="login-logo">
        <router-link to="/"><b>{{name}}</b></router-link>
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    export default {
        name: "logo",
        data(){
            return {
                "{lang_path}":'admin.layout',
            };
        },
        computed:mapState([
           'name_short',
            'name'
        ])
    }
</script>

<style scoped>

</style>
