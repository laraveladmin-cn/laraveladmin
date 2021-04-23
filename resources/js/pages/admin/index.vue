<template>
    <div class="admin_index">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" v-for="(item,index) in (data.count||[])">
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
        <div class="row">
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 over">
                <echart :options="option1" style="height:400px;"></echart>

            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 over">
                <div style="min-width: 710px">
                    <echart :options="option2" style="height:400px;"></echart>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 over">
                <div style="min-width: 710px">
                    <echart :options="option3" style="height:400px;"></echart>
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
        components:{
            "echart":function(resolve){
                require(['common_components/echart.vue'], resolve);
            }
        },
        data(){
            return {
                "{lang_path}":'admin',
                data:{},
                loading:false,
                option1:()=>{
                    return {
                        title: {
                            text: this.$tp('Bar charts') //柱状图
                        },
                        tooltip: {},
                        legend: {
                            data:[
                                this.$tp('Sales')//'销量'
                            ]
                        },
                        xAxis: {
                            data: collect([
                                //"衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"
                                "Shirt", "Cardigan", "Chiffon", "Trousers", "High heels", "Socks"
                            ]).map( (value)=> {
                                return this.$tp(value);
                            }).all()
                        },
                        yAxis: {},
                        series: [{
                            name: this.$tp('Sales'),//'销量',
                            type: 'bar',
                            data: [5, 20, 36, 10, 10, 20]
                        }]
                    };
                },
                option2:()=>{
                    return {
                        tooltip: {
                            trigger: 'item',
                                formatter: '{a} <br/>{b}: {c} ({d}%)'
                        },
                        legend: {
                            orient: 'vertical',
                                left: 10,
                                data: collect(["Direct", "Marketing Advertising", "Search engines", "Email Marketing", "Alliance advertising", "Video Ads", "Baidu", "Google", "Bing", "Other"])
                                    .map( (value)=> {
                                        return this.$tp(value);
                                    }).all()
                        },
                        series: [
                            {
                                name: this.$tp('Visit source'),//'访问来源',
                                type: 'pie',
                                selectedMode: 'single',
                                radius: [0, '30%'],

                                label: {
                                    position: 'inner'
                                },
                                labelLine: {
                                    show: false
                                },
                                data: [
                                    {value: 335, name: this.$tp('Direct'), selected: true},
                                    {value: 679, name: this.$tp('Marketing Advertising')},
                                    {value: 1548, name: this.$tp('Search engines')}
                                ]
                            },
                            {
                                name: this.$tp('Visit source'),//'访问来源',
                                type: 'pie',
                                radius: ['40%', '55%'],
                                label: {
                                    formatter: '{a|{a}}{abg|}\n{hr|}\n  {b|{b}：}{c}  {per|{d}%}  ',
                                    backgroundColor: '#eee',
                                    borderColor: '#aaa',
                                    borderWidth: 1,
                                    borderRadius: 4,
                                    // shadowBlur:3,
                                    // shadowOffsetX: 2,
                                    // shadowOffsetY: 2,
                                    // shadowColor: '#999',
                                    // padding: [0, 7],
                                    rich: {
                                        a: {
                                            color: '#999',
                                            lineHeight: 22,
                                            align: 'center'
                                        },
                                        // abg: {
                                        //     backgroundColor: '#333',
                                        //     width: '100%',
                                        //     align: 'right',
                                        //     height: 22,
                                        //     borderRadius: [4, 4, 0, 0]
                                        // },
                                        hr: {
                                            borderColor: '#aaa',
                                            width: '100%',
                                            borderWidth: 0.5,
                                            height: 0
                                        },
                                        b: {
                                            fontSize: 16,
                                            lineHeight: 33
                                        },
                                        per: {
                                            color: '#eee',
                                            backgroundColor: '#334455',
                                            padding: [2, 4],
                                            borderRadius: 2
                                        }
                                    }
                                },
                                data: [
                                    {value: 335, name: this.$tp('Direct')},
                                    {value: 310, name: this.$tp('Email Marketing')},
                                    {value: 234, name: this.$tp('Alliance advertising')},
                                    {value: 135, name: this.$tp('Video Ads')},
                                    {value: 1048, name: this.$tp('Baidu')},
                                    {value: 251, name: this.$tp('Google')},
                                    {value: 147, name: this.$tp('Bing')},
                                    {value: 102, name: this.$tp('Other')}
                                ]
                            }
                        ]
                    };
                },
                option3:()=>{
                    return {
                        title: {
                            text: this.$tp('Custom radar chart')//'自定义雷达图'
                        },
                        legend: {
                            data: collect(['Graph one','Figure 2', 'Zhang SAN', 'Li SI'])
                                .map( (value)=> {
                                    return this.$tp(value);
                                }).all()
                        },
                        radar: [
                            {
                                indicator: collect([
                                    { text: '指标一' },
                                    { text: '指标二' },
                                    { text: '指标三' },
                                    { text: '指标四' },
                                    { text: '指标五' }
                                ]).map( (item,index)=> {
                                    item.text = this.$tp('Measure '+(index+1));
                                    return item;
                                }).all(),
                                center: ['25%', '50%'],
                                radius: 120,
                                startAngle: 90,
                                splitNumber: 4,
                                shape: 'circle',
                                name: {
                                    formatter: '【{value}】',
                                    textStyle: {
                                        color: '#72ACD1'
                                    }
                                },
                                splitArea: {
                                    areaStyle: {
                                        color: ['rgba(114, 172, 209, 0.2)',
                                            'rgba(114, 172, 209, 0.4)', 'rgba(114, 172, 209, 0.6)',
                                            'rgba(114, 172, 209, 0.8)', 'rgba(114, 172, 209, 1)'],
                                        shadowColor: 'rgba(0, 0, 0, 0.3)',
                                        shadowBlur: 10
                                    }
                                },
                                axisLine: {
                                    lineStyle: {
                                        color: 'rgba(255, 255, 255, 0.5)'
                                    }
                                },
                                splitLine: {
                                    lineStyle: {
                                        color: 'rgba(255, 255, 255, 0.5)'
                                    }
                                }
                            },
                            {
                                indicator: collect([
                                    { text: 'Language', max: 150 },
                                    { text: 'Mathematics', max: 150 },
                                    { text: 'English', max: 150 },
                                    { text: 'Physical', max: 120 },
                                    { text: 'Chemistry', max: 108 },
                                    { text: 'Biology', max: 72 }
                                ]).map( (item,index)=> {
                                    item.text = this.$tp(item.text);
                                    return item;
                                }).all(),
                                center: ['75%', '50%'],
                                radius: 120
                            }
                        ],
                        series: [
                            {
                                name: this.$tp('Radar map'),//'雷达图',
                                type: 'radar',
                                emphasis: {
                                    lineStyle: {
                                        width: 4
                                    }
                                },
                                data: [
                                    {
                                        value: [100, 8, 0.40, -80, 2000],
                                        name: this.$tp('Figure 1'),//'图一',
                                        symbol: 'rect',
                                        symbolSize: 5,
                                        lineStyle: {
                                            type: 'dashed'
                                        }
                                    },
                                    {
                                        value: [60, 5, 0.30, -100, 1500],
                                        name: this.$tp('Figure 2'),
                                        areaStyle: {
                                            color: 'rgba(255, 255, 255, 0.5)'
                                        }
                                    }
                                ]
                            },
                            {
                                name: this.$tp('Transcript'),//'成绩单',
                                type: 'radar',
                                radarIndex: 1,
                                data: [
                                    {
                                        value: [120, 118, 130, 100, 99, 70],
                                        name: this.$tp('Zhang SAN'),//'张三',
                                        label: {
                                            show: true,
                                            formatter: function(params) {
                                                return params.value;
                                            }
                                        }
                                    },
                                    {
                                        value: [90, 113, 140, 30, 70, 60],
                                        name: this.$tp('Li Si'),//'李四',
                                        areaStyle: {
                                            opacity: 0.9
                                        }
                                    }
                                ]
                            }
                        ]
                    };
                }
            }
        },
        created() {
            this.getData({},'','data');
        },
        methods:{

        }
    };
</script>
<style>
    .over{
        overflow-x: scroll;
    }
</style>
