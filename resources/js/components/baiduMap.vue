<template>
    <div class="map-container"
         @mouseup="onMouseup"
         @touchend="onMouseup"
         @mouseout="$emit('blur')">
    </div>
</template>

<script>
    //高德地图
    import { mapState } from 'vuex';
    export default {
        name: "baiduMap",
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
                    return [104.07221517047,30.665531299497];
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
        /*    isGooglePoint:{
              type:[Boolean],
              default: function () {
                return false;
              }
            },*/
        },
        data(){
            return {
                intervalTime:null,
                marker:null,
                map:null,
                searching:false,
                timer:null
            };
        },
        methods:{
            init(){
                this.intervalTime = setInterval(()=>{
                    if(typeof window.BMapGL!="undefined"){
                        clearInterval(this.intervalTime);
                        window.BMap = window.BMapGL;
                        //中心点位置
                        let center = this.value || this.defaultCenter;
                        if(!(center instanceof Array)){
                            center = [center.lng,center.lat];
                        }
                        /*if(this.isGooglePoint){
                            let convertor = new BMapGL.Convertor();
                            let pointArr = [];
                            let ggPoint = new BMap.Point(center[0], center[1]);
                            pointArr.push(ggPoint);
                            convertor.translate(pointArr, COORDINATES_GCJ02, COORDINATES_BD09,(data)=>{
                              let point = data.points[0];
                              this.initMap([point.lng,point.lat]);
                            });
                        }else {*/
                          this.initMap(center);
                        //}
                    }
                },500);
            },
            initMap(center){
              //地图显示
              let map = this.map = new BMap.Map(this.$el);
              let point = new BMap.Point(center[0], center[1]);
              map.centerAndZoom(point, 15);
              map.enableScrollWheelZoom(true);
              // 创建定位控件
              let locationControl = new BMapGL.LocationControl({
                // 控件的停靠位置（可选，默认左上角）
                anchor: BMAP_ANCHOR_BOTTOM_RIGHT,
                // 控件基于停靠位置的偏移量（可选）
                offset: new BMapGL.Size(20, 20)
              });
              // 将控件添加到地图上
              map.addControl(locationControl);
              locationControl.addEventListener("locationSuccess", (e)=>{
                this.updateMarker({lng:e.point.longitude,lat:e.point.latitude});
                this.onMouseup();
              });
              locationControl.addEventListener("locationError",(e)=>{
                dd(e);
              });
              this.updateMarker(center);
            },
            onMouseup(){
                if(this.disabled || !this.marker){ //禁用模式
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
                    this.map.removeOverlay(this.marker);
                }
                let point = new BMap.Point(lng, lat);
                let marker = this.marker = new BMap.Marker(point, {
                  enableDragging: !this.disabled
                });
                marker.addEventListener('mouseup',(e)=>{
                  this.updateMarker(e.latLng);
                });
                this.map.addOverlay(marker);
                this.map.setCenter(point); //设置地图中心点
            }
        },
        mounted() {
            this.init();
        },
        created() {
            //动态加载js文件
            if(!document.getElementById('baidu-map')){
                let jsApiKey;
                if(this.baidu_map_config){
                    jsApiKey = this.jsApiKey || this.baidu_map_config.key;
                }else {
                    jsApiKey = this.jsApiKey;
                }
                window.BMAP_PROTOCOL = "https";
                window.BMapGL_loadScriptTime = (new Date).getTime();
                let baiduMapJs = document.createElement('script');
                baiduMapJs.id = 'baidu-map-js';
                baiduMapJs.type = 'text/javascript';
                baiduMapJs.src = '//api.map.baidu.com/getscript?type=webgl&v=1.0&ak='+jsApiKey+'&services=&t='+(new Date).getTime();
                document.body.appendChild(baiduMapJs);
            }
        },
        watch:{
            keywords(val){
                this.timer = new Date().getTime();
                setTimeout(()=>{
                    if(new Date().getTime() - this.timer >= 200){
                        if(val && !this.disabled){
                            if(this.searching || typeof BMapGL=="undefined"){
                                return;
                            }
                            this.searching = true;
                          //创建地址解析器实例
                          let myGeo = new BMapGL.Geocoder();
                          // 将地址解析结果显示在地图上，并调整地图视野
                          myGeo.getPoint(val, (point)=>{
                            if(point){
                              this.updateMarker(point);
                              this.onMouseup();
                            }
                            this.searching = false;
                          });
                        }
                    }
                },210);
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
  @import url('https://api.map.baidu.com/res/webgl/10/bmap.css');
  .map-container{
      min-height: 250px;
      overflow: hidden;
      width: 100%;
  }

</style>
