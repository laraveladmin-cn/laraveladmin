<template>
    <div class="admin_user_index">
        <div class="row">
            <div class="col-xs-12">
                <data-table :options="options" ref="table">
                    <template slot="sizer" slot-scope="props">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <h4><strong>{{$tp('Log in to access the statistics chart')}}</strong></h4>
                            </div>
                            <div class="col-lg-6 col-md-4 col-sm-2 col-xs-12">
                                <dropdown-menu class="row-item" :map="props.maps.group" v-model="props.options.group" @change="changeGroup(props)"></dropdown-menu>
                            </div>
                            <div class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
                                <div :class="'label-date-'+_map_date_count">
                                    <label-edit v-model="props.where['created_at'][0]"
                                                v-if="props.where && props.where['created_at']"
                                                @change="props.search"
                                                :map="_map_date"
                                                :class="'language-'+language"
                                                class="row-item">
                                    </label-edit>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template slot="sizer-min" slot-scope="props">
                        <span></span>
                    </template>
                    <template slot="table" slot-scope="props">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <echart :options="optionLine(props.data.list.data)" style="height:400px;"></echart>
                            </div>
                        </div>
                    </template>
                </data-table>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    export default {
        components:{
            dataTable:()=>import(/* webpackChunkName: "common_components/datatable.vue" */ 'common_components/datatable.vue'),
            echart:()=>import(/* webpackChunkName: "common_components/echart.vue" */ 'common_components/echart.vue'),
            labelEdit: () => import(/* webpackChunkName: "common_components/labelEdit.vue" */ 'common_components/labelEdit.vue'),
            dropdownMenu: () => import(/* webpackChunkName: "common_components/dropdownMenu.vue" */ 'common_components/dropdownMenu.vue'),
        },
        props: {
        },
        data(){
            let timestamp = Date.parse(new Date())/1000;
            let map_date = [
                {day:7,show:'Last Week'},
                {day:30,show:'Last month'},
                {day:90,show:'Last three months'},
                {day:365,show:'Last Year'},
                {day:0,show:'All'},
            ];
            let def_options = JSON.parse(this.$router.currentRoute.query.options || '{}');
            let data = {
                "{lang_path}":'admin',
                options:{
                    lang_table:'logs',
                    id:'data-table', //多个data-table同时使用时唯一标识
                    url:'/admin/log-counts', //数据表请求数据地址
                    operation:false, //操作列
                    checkbox:false, //选择列
                    btnSizerMore:false, //更多筛选条件按钮
                    keywordKey:'parameters', //关键字查询key
                    keywordGroup:false, //是否为选项组
                    hideBottomPagerTool:true,
                    hideTopPagerTool:true,
                    primaryKey:'id', //数据唯一性主键
                    defOptions:def_options, //默认筛选条件
                    fields: {},
                },
                mapDate:{

                },
                access:[],
                group:0
            };
            for (let i in map_date){
                if(map_date[i].day){
                    data.mapDate[date_format(timestamp-3600*24*map_date[i].day,'yyyy-MM-dd 00:00:00')]=map_date[i].show;
                }else {
                    data.mapDate['']=map_date[i].show;
                }
            }
            return data;
        },
        computed:{
            ...mapState([
                'use_url',
                'theme',
                'language'
            ]),
            option4(){
                let access = this.access;
                return {
                    title: {
                        text: ''//this.$tp('Log in to access the statistics chart') //登录访问统计图
                    },
                    tooltip: {},
                    legend: {
                        data:[
                            this.$tp('Number of successful login'),//'成功登录次数'
                            this.$tp('IP row of heavy'), //IP去重
                        ]
                    },
                    xAxis: {
                        type: 'category',
                        data: collect(access).pluck('date').all()//['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [{
                        name: this.$tp('Number of successful login'),
                        data: collect(access).pluck('value').all(),//[820, 932, 901, 934, 1290, 1330, 1320],
                        type: 'line',
                        smooth: true
                    },{
                        name: this.$tp('IP row of heavy'),
                        data: collect(access).pluck('distinct_value').all(),//[820, 932, 901, 934, 1290, 1330, 1320],
                        type: 'line',
                        smooth: true
                    }]
                }
            },
            _map_date(){
                let map={};
                let index = 0;
                for (let i in this.mapDate){
                    let value = this.mapDate[i];
                    if(this.group<=index){
                        map[i] = this.$tp(value);
                    }
                    index++;
                }
                return map;
            },
            _map_date_count(){
                return collect(this._map_date).count();
            }
        },
        methods:{
            optionLine(data){
                this.access = data;
                return this.option4;
            },
            changeGroup(props){
                this.group = props.options.group;
                let created_at = props.where['created_at'][0];
                if(typeof this._map_date[created_at]=="undefined"){
                    props.where['created_at'][0] = collect(this._map_date).keys().first() || '';
                }
                props.search();
            }

        }

    };
</script>
<style lang="scss" scoped>
.row-item{
    margin-bottom: 5px;
}

@media screen and (max-width: 768px) {
    .label-date-5{
        overflow-x: scroll;
        .row-item{
            min-width: 700px;
        }
    }
    .label-date-4{
        overflow-x: scroll;
        .language-fr,.language-ru,.language-es,.language-pt{
            min-width: 600px;
        }
    }
    .label-date-3{
        overflow-x: scroll;
        .language-fr,.language-ru,.language-es,.language-pt{
            min-width: 500px;
        }
    }
}

</style>
