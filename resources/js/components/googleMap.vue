<template>
    <div class="map-container"
         @mouseup="onMouseup"
         @touchend="onMouseup"
         @mouseout="$emit('blur')">
    </div>
</template>

<script>
    //谷歌地图
    import { mapState } from 'vuex';
    export default {
        name: "googleMap",
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
                searching:false,
                timer:null
            };
        },
        methods:{
            geolocation(center){
                if (window.navigator.geolocation) {
                    window.navigator.geolocation.getCurrentPosition(
                        (position) => {
                            if(!this.value){
                                this.updateMarker([position.coords.longitude,position.coords.latitude]);
                            }else {
                                this.map.setCenter({lng:center[0],lat:center[1]}); //设置地图中心点
                            }
                            dd('定位信息:',position)
                        },
                        () => {
                            dd('定位失败');
                        }
                    );
                }else {
                    dd('定位失败');
                }
            },
            init(){
                this.intervalTime = setInterval(()=>{
                    if(typeof window.google!="undefined" && window.google.maps && window.google.maps.Map){
                        clearInterval(this.intervalTime);
                        //中心点位置
                        let center = this.value || this.defaultCenter;
                        if(!(center instanceof Array)){
                            center = [center.lng,center.lat];
                        }
                        //地图显示
                        this.map = new window.google.maps.Map(this.$el, {
                            center: {lng:center[0]-0,lat:center[1]-0},
                            zoom: 13
                        });
                        this.geolocation(center);
                        //定位按钮
                        const locationButton = document.createElement("button");

                        locationButton.textContent = "定位";
                        locationButton.classList.add("custom-map-control-button");
                        locationButton.style=' background-color: #fff;\n' +
                            '  border: 0;\n' +
                            '  border-radius: 2px;\n' +
                            '  box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);\n' +
                            '  margin: 10px;\n' +
                            '  padding: 0 0.5em;\n' +
                            '  font: 400 18px Roboto, Arial, sans-serif;\n' +
                            '  overflow: hidden;\n' +
                            '  height: 40px;\n' +
                            '  cursor: pointer;' +
                            ':hover:background: #ebebeb;';
                        this.map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
                        locationButton.addEventListener("click",()=>{
                            if (window.navigator.geolocation) {
                                window.navigator.geolocation.getCurrentPosition(
                                    (position) => {
                                        this.map.setCenter({lng:position.coords.longitude-0,lat:position.coords.latitude-0}); //设置地图中心点
                                        dd('定位信息:',position)
                                    },
                                    () => {
                                        dd('定位失败');
                                    }
                                );
                            }else {
                                dd('定位失败');
                            }
                        });
                        this.updateMarker(center);
                    }
                },500);
            },
            onMouseup(){
                if(this.disabled){ //禁用模式
                    return;
                }
                let position = this.marker.getPosition();
                let location = {lng:position.lng(),lat:position.lat()};
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
                    //this.map.destroy();
                }
            },
            updateMarker(val){
                let lng,lat;
                if(!(val instanceof Array)){
                    lng = val.lng-0;
                    lat = val.lat-0;
                }else {
                    lng = val[0]-0;
                    lat = val[1]-0;
                }
                if(this.marker){
                    this.marker.setMap(null);
                }
                this.marker = new window.google.maps.Marker({
                    position: {lng:lng, lat:lat},
                    map:this.map,
                    draggable: !this.disabled,
                });
                this.map.setCenter({lng:lng,lat:lat}); //设置地图中心点
            }
        },
        mounted() {
            this.init();
        },
        created() {
            //动态加载js文件
            if(!document.getElementById('google-map')){
                //认证配置项
                let jsApiKey;
                if(this.google_config){
                    jsApiKey = this.jsApiKey || this.google_config.key;
                }else {
                    jsApiKey = this.jsApiKey;
                }

                let googleMapJs = document.createElement('script');
                googleMapJs.id = 'google-map-js';
                googleMapJs.type = 'text/javascript';
                googleMapJs.src = 'https://maps.googleapis.com/maps/api/js?key='+jsApiKey;
                document.body.appendChild(googleMapJs);
            }
        },
        watch:{
            keywords(val){
                this.timer = new Date().getTime();
                setTimeout(()=>{
                    if(new Date().getTime() - this.timer >= 200){
                        if(val && !this.disabled){
                            let url;
                            if(this.google_config){
                                url = this.searchUrl || this.google_config.searchUrl;
                            }else {
                                url = this.searchUrl;
                            }
                            if(!url || this.searching){
                                return;
                            }
                            this.searching = true;
                            axios.get(this.use_url+url,{params:{
                                    address:val
                                }}).then( (response)=> {
                                if(response.status==200 && response.data && response.data.results && response.data.results.length){
                                    let first = response.data.results[0];
                                    let location = first.geometry.location;
                                    let value;
                                    if(this.value && !(this.value instanceof Array)){
                                        value = {
                                            lng:location.lng,
                                            lat:location.lat
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
                'google_config',
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
