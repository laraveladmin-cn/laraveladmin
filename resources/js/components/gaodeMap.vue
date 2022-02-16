<template>
    <div class="map-container"
         @mouseup="onMouseup"
         @mouseout="$emit('blur')">
    </div>
</template>

<script>
    //高德地图
    import { mapState } from 'vuex';
    export default {
        name: "gaodeMap",
        props:{
            //值
            value: {
                type:[Array,Object],
                default: function () {
                    return null;
                }
            },
            //是否禁用
            disabled:{
                default: function () {
                    return false;
                }
            },
            //认证key
            jsApiKey:{
                type:[String],
                default: function () {
                    return '';
                }
            },
            //默认中心点
            defaultCenter:{
                type:[Array,Object],
                default: function () {
                    return [104.065735,30.659462];
                }
            },
            //关键字
            keywords:{
                type:[String],
                default: function () {
                    return '';
                }
            },
            searchUrl:{
                type:[String],
                default: function () {
                    return '';
                }
            },
        },
        data(){
            return {
                intervalTime:null,
                marker:null,
                map:null,
                searching:false
            };
        },
        methods:{
            init(){
                this.intervalTime = setInterval(()=>{
                    if(typeof window.AMap!="undefined"){
                        clearInterval(this.intervalTime);
                        //中心点位置
                        let center = this.value || this.defaultCenter;
                        if(!(center instanceof Array)){
                            center = [center.lng,center.lat];
                        }
                        //地图显示
                        this.map = new window.AMap.Map(this.$el, {
                            resizeEnable: true,
                            center: center,
                            zoom: 13
                        });
                        window.AMap.plugin('AMap.Geolocation', ()=> {
                            let geolocation = new window.AMap.Geolocation({
                                enableHighAccuracy: true,//是否使用高精度定位，默认:true
                                timeout: 10000,          //超过10秒后停止定位，默认：5s
                                position:'RB',    //定位按钮的停靠位置
                                offset: [10, 20], //定位按钮与设置的停靠位置的偏移量，默认：[10, 20]
                                zoomToAccuracy: false,   //定位成功后是否自动调整地图视野到定位点
                            });
                            this.map.addControl(geolocation);
                            geolocation.getCurrentPosition((status,result)=>{
                                if(status=='complete'){ //定位成功
                                    if(!this.value){
                                        this.updateMarker([result.position.lng,result.position.lat]);
                                    }else {
                                        this.map.setCenter(center); //设置地图中心点
                                    }
                                    //dd('定位信息:',result)
                                }else{ //定位失败
                                    //dd(result)
                                }
                            });
                        });
                        this.updateMarker(this.map.getCenter());
                    }
                },500);
            },
            onMouseup(){
                if(this.disabled){ //禁用模式
                    return;
                }
                let location = this.marker.getPosition();
                let value;
                if(this.value && !(this.value instanceof Array)){
                    value = {
                        lng:location.lng,
                        lat:location.lat
                    };
                }else {
                    value=[
                        location.lng,
                        location.lat
                    ];
                }
                if(JSON.stringify(this.value||[])!=JSON.stringify(value)){
                    this.$emit('input', value); //修改值
                    this.$emit('change',value); //修改值
                }
            },
            destroy(){
                if(this.map){
                    this.map.destroy();
                }
            },
            updateMarker(val){
                let lng,lat;
                if(!(val instanceof Array)){
                    lng = val.lng;
                    lat = val.lat;
                }else {
                    lng = val[0];
                    lat = val[1];
                }
                if(this.marker){
                    this.map.remove(this.marker);
                }
                this.marker = new window.AMap.Marker({
                    position: new window.AMap.LngLat(lng, lat),
                    draggable: !this.disabled,
                    cursor: 'move',
                    raiseOnDrag: true
                });
                this.map.add(this.marker);
                this.map.setCenter([lng, lat]); //设置地图中心点
            }
        },
        mounted() {
            this.init();
        },
        created() {
            //动态加载js文件
            if(!document.getElementById('gaode-map')){
                //认证配置项
                if(this.amap_config && (typeof window._AMapSecurityConfig=="undefined")){
                    window._AMapSecurityConfig = this.amap_config;
                }
                let jsApiKey;
                if(this.amap_config){
                    jsApiKey = this.jsApiKey || this.amap_config.key;
                }else {
                    jsApiKey = this.jsApiKey;
                }

                let gaodeMapJs = document.createElement('script');
                gaodeMapJs.id = 'gaode-map-js';
                gaodeMapJs.type = 'text/javascript';
                gaodeMapJs.src = 'https://webapi.amap.com/maps?v=2.0&key='+jsApiKey;
                document.body.appendChild(gaodeMapJs);
            }
        },
        watch:{
            keywords(val){
                if(val && !this.disabled){
                    let url;
                    if(this.amap_config){
                        url = this.searchUrl || this.amap_config.searchUrl;
                    }else {
                        url = this.searchUrl;
                    }
                    if(!url || this.searching){
                        return;
                    }
                    this.searching = true;
                    axios.get(this.use_url+url,{params:{
                            keywords:val
                        }}).then( (response)=> {
                            if(response.status==200 && response.data && response.data.pois && response.data.pois.length){
                                let first = response.data.pois[0];
                                let location = first.location.split(',');
                                let value;
                                if(this.value && !(this.value instanceof Array)){
                                    value = {
                                        lng:location[0],
                                        lat:location[1]
                                    };
                                }else {
                                    value=location;
                                }
                                this.updateMarker(location);
                                if(JSON.stringify(this.value||[])!=JSON.stringify(value)){
                                    this.$emit('input', value); //修改值
                                    this.$emit('change',value); //修改值
                                }
                            }
                        this.searching = false;
                    }).catch((error) => {
                        this.searching = false;
                    });
                }
            },
            value(val){
                if(this.map && this.marker && val){
                   this.updateMarker(val);
                }
            },
            disabled(val){
                if(this.map && this.marker && this.value){
                    this.updateMarker(this.value);
                }
            }
        },
        computed:{
            ...mapState([
                'amap_config',
                'use_url',
            ])
        },
        beforeDestroy() {
            this.destroy();
        },

    }
</script>

<style scoped lang="scss">
    .map-container{
        min-height: 250px;
    }
</style>
