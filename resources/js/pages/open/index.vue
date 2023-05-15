<template>
    <div class="open_index">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <ai-chats @chatActive="chatActive"></ai-chats>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                <ai-messages ref="ai_message"></ai-messages>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        components:{
            "ai-chats": ()=>import(/* webpackChunkName: "pages/open/ai_chats/index.vue" */ 'pages/open/ai_chats/index.vue'),
            "ai-messages": ()=>import(/* webpackChunkName: "pages/open/ai_messages/index.vue" */ 'pages/open/ai_messages/index.vue')

        },
        props: {
        },
        data(){
            return {
                "{lang_path}":'open.index',
            };
        },
        methods: {
            chatActive(val){
                dd(val);
                let $table = this.$refs.ai_message.$refs.table;
                $table.data.options.where.ai_chat_id = val;
                this.$refs.ai_message.row.ai_chat_id = val;
                $table.loading = false;
                $table.search();
            }
        },
    };
</script>
<style scoped>
.open_index{
    padding: 10px;
}
</style>
