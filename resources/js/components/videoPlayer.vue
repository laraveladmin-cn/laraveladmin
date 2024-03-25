<template>
    <div ref="player" class="video-player">
        <video playsinline controls="controls" autoplay>
            <source :src="value"
                    type="video/mp4">
            您的浏览器暂不支持该视频播放
        </video>
    </div>
</template>
<script>
export default {
    name:'videoPlayer',
    props:{
        value:{
            default:function () {
                return '';
            }
        },
    },
    mounted(){
    },
    methods:{
    }
}

</script>

<style scoped>
.video-player{
    width: 100%;
}
</style>
