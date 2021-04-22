<template>
    <div class="login-logo">
        <router-link to="/"><b>{{name_short}}</b>{{$tp('Backend systems')}}</router-link>
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
           'name_short'
        ])
    }
</script>

<style scoped>

</style>
