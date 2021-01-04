<template>
    <div class="open_index">
        官网首页
        <router-link to="/admin">后台</router-link>
        <router-link to="/home">前台</router-link>
        <h3 style="color: red">请勿在本演示环境注册用户,本演示环境的注册,登录仅用于演示使用</h3>
        <h1>
            <a href="https://www.laraveladmin.cn">正式环境官网:https://www.laraveladmin.cn</a>
        </h1>
    </div>
</template>

<script>
    export default {
        props: {},
    };
</script>
