<template>
    <div class="admin_index">
        <div class="row">
            <div class="col-lg-3 col-xs-6" v-for="(item,index) in (data.count||defCount)">
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
                "{lang_path}":'_shared.pages.admin',
                '{lang_root}':'',
                defCount: [
                    {
                        'name': 'Total number of back-end administrators',
                        'value': '--',
                        'class': 'bg-aqua',
                        'icon': 'fa-hand-pointer-o',
                        'url': '/admin/admins'
                    },
                    {
                        'name': 'Total number of roles',
                        'value': '--',
                        'class': 'bg-green',
                        'icon': 'fa-cubes',
                        'url': '/admin/roles'
                    },
                    {
                        'name': 'Total number of users',
                        'value': '--',
                        'class': 'bg-yellow',
                        'icon': 'fa-users',
                        'url': '/admin/users'
                    },
                    {
                        'name': 'Total number of menus',
                        'value': '--',
                        'class': 'bg-red',
                        'icon': 'fa-sitemap',
                        'url': '/admin/menus'
                    }
                ]

            }
        },
        created() {
            this.getData({},'','data');
        },
        methods:{

        }
    };
</script>
