<template>
    <div class="admin_index">
        <div class="row">
            <div class="col-lg-3 col-xs-6" v-for="(item,index) in (data.count||[])">
                <div class="small-box" :class="item['class']">
                    <div class="inner">
                        <h3>{{item['value']}}</h3>
                        <p>{{$tp(item['name'])}}</p>
                    </div>
                    <div class="icon">
                        <i class="fa" :class="item['icon']"></i>
                    </div>
                    <router-link :to="item['url']" class="small-box-footer">
                        {{$t('More')}} <i class="fa fa-arrow-circle-right"></i>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from "vuex";

    export default {
        props: {
        },
        data(){
            return {
                data:{},
                loading:false,
                "{lang_path}":'admin'
            }
        },
        created() {
            this.getData({},'','data');
        },
        methods:{

        }
    };
</script>
