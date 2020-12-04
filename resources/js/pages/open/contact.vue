<template>
    <div class="open_contact">
        <div class="container marketing">
            <div  id="contact">
                <h3>联系我们<small>(开源不易谢谢支持)</small></h3>
                <hr class="featurette-divider">
                <div class="row featurette">
                    <div class="col-md-4">
                        <div class="media">
                            <div class="media-left">
                                <a href="#" class="thumbnail alipay">
                                    <img class="media-object" :src="app_url+'/dist/img/alipay.jpg'" alt="扫码捐赠" data-holder-rendered="true">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-info">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#" class="thumbnail pay-wx">
                                        <img class="media-object" :src="app_url+'/dist/img/wxpay.jpg'" alt="扫码捐赠" data-holder-rendered="true">
                                    </a>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="media">
                            <div class="media-body">
                                <h4 class="media-heading">演示环境</h4>
                                用户名:<code>demo_admin</code>
                                <br>密码:<code>admin123456</code>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <i class="glyphicon glyphicon-list-alt" style="color:#979797;font-size:20px"></i>
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">邮编: 610000</h4>

                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a href="tel:13699411148">
                                    <i class="glyphicon glyphicon-earphone" style="color:#979797;font-size:20px"></i>
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">电话: 张先生 13699411148(微信同号)</h4>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a href="mailto:214986304@qq.com">
                                    <i class="glyphicon glyphicon-envelope" style="color:#979797;font-size:20px"></i>
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">电子邮箱:214986304@qq.com</h4>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a>
                                    <i class="glyphicon glyphicon-map-marker" style="color:#979797;font-size:20px"></i>
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">地址:四川省成都市锦江区娇子一号</h4>
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

        }

    };
</script>
<style scoped>

    .media .pay-wx{
        height: 480px;


    }
    .media .alipay{
        height: 520px;
    }
    .page-header{
        border-bottom:1px solid #a4aaae;
        font-size: 14px;
    }
    .thumbnail{
        height: 300px;
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
