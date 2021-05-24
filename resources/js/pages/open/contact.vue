<template>
    <div class="open_contact">
        <div class="container marketing">
            <div  id="contact">
                <h3>{{$tp('Contact us')}}<small>({{$tp('Open source is not easy thanks for your support')}})</small></h3>
                <hr class="featurette-divider">
                <div class="row featurette">
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                        <div class="media">
                            <div class="media-left">
                                <a href="#" class="thumbnail alipay">
                                    <img class="media-object" :src="app_url+'/dist/img/alipay.jpg'" :alt="$tp('Scan code for donation')" data-holder-rendered="true">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                        <div class="contact-info">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#" class="thumbnail pay-wx">
                                        <img class="media-object" :src="app_url+'/dist/img/wxpay.jpg'" :alt="$tp('Scan code for donation')" data-holder-rendered="true">
                                    </a>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <div class="media">
                            <div class="media-body">
                                <h4 class="media-heading">{{$tp('Demo environment')}}</h4>
                                {{$tp('User name')}}:<code>demo_admin</code>
                                <br>{{$tp('Password')}}:<code>admin123456</code>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <i class="fa fa-qq" style="color:#979797;font-size:20px"></i>
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">{{$tp('Official QQ Group')}}: 391528810</h4>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <i class="glyphicon glyphicon-list-alt" style="color:#979797;font-size:20px"></i>
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">{{$tp('Zip code')}}: 610000</h4>

                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a href="tel:13699411148">
                                    <i class="glyphicon glyphicon-earphone" style="color:#979797;font-size:20px"></i>
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">{{$tp('Telephone')}}: {{$tp('Mr Zhang')}} 13699411148({{$tp('WeChat Same number')}})</h4>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a href="mailto:214986304@qq.com">
                                    <i class="glyphicon glyphicon-envelope" style="color:#979797;font-size:20px"></i>
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">{{$tp('Email address')}}:214986304@qq.com</h4>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a>
                                    <i class="glyphicon glyphicon-map-marker" style="color:#979797;font-size:20px"></i>
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">{{$tp('Address')}}:{{$tp('Jiaozi No1, Jinjiang District, Chengdu City, Sichuan Province')}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState, mapActions, mapMutations, mapGetters } from 'vuex';
    export default {
        props: {
        },
        computed:{
            ...mapState([
                'app_url'
            ]),
        },
        mounted() {
        },
        created() {
        },
        methods:{

        },
        data(){
            return {
                "{lang_path}":'open.contact'
            };
        }

    };
</script>
<style scoped>
    .page-header{
        border-bottom:1px solid #a4aaae;
        font-size: 14px;
    }
    .featurette-divider{
        border-top: 1px solid #a4aaae;
    }
    .thumbnail1{
        height: 150px;
    }
    .caption h3{
        color: white;
    }
</style>
