<template>
    <div class="admin_index">
        <div class="row">
            <div class="col-lg-3 col-xs-6" v-for="(item,index) in (data.count||[])">
                <div class="small-box" :class="item['class']">
                    <div class="inner">
                        <h3>{{item['value']}}</h3>
                        <p>{{item['name']}}</p>
                    </div>
                    <div class="icon">
                        <i class="fa" :class="item['icon']"></i>
                    </div>
                    <router-link :to="item['url']" class="small-box-footer">
                        更多<i class="fa fa-arrow-circle-right"></i>
                    </router-link>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-xs-6">
                <echart :options="option1" style="height:400px;"></echart>
            </div>
            <div class="col-lg-8 col-xs-6">
                <echart :options="option2" style="height:400px;"></echart>
            </div>
            <div class="col-lg-12 col-xs-12">
                <echart :options="option3" style="height:400px;"></echart>
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
                data:{},
                loading:false,
                option1:{
                    title: {
                        text: '柱状图'
                    },
                    tooltip: {},
                    legend: {
                        data:['销量']
                    },
                    xAxis: {
                        data: ["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"]
                    },
                    yAxis: {},
                    series: [{
                        name: '销量',
                        type: 'bar',
                        data: [5, 20, 36, 10, 10, 20]
                    }]
                },
                option2:{
                    tooltip: {
                        trigger: 'item',
                        formatter: '{a} <br/>{b}: {c} ({d}%)'
                    },
                    legend: {
                        orient: 'vertical',
                        left: 10,
                        data: ['直达', '营销广告', '搜索引擎', '邮件营销', '联盟广告', '视频广告', '百度', '谷歌', '必应', '其他']
                    },
                    series: [
                        {
                            name: '访问来源',
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
                                {value: 335, name: '直达', selected: true},
                                {value: 679, name: '营销广告'},
                                {value: 1548, name: '搜索引擎'}
                            ]
                        },
                        {
                            name: '访问来源',
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
                                {value: 335, name: '直达'},
                                {value: 310, name: '邮件营销'},
                                {value: 234, name: '联盟广告'},
                                {value: 135, name: '视频广告'},
                                {value: 1048, name: '百度'},
                                {value: 251, name: '谷歌'},
                                {value: 147, name: '必应'},
                                {value: 102, name: '其他'}
                            ]
                        }
                    ]
                },
                option3:{
                    title: {
                        text: '自定义雷达图'
                    },
                    legend: {
                        data: ['图一','图二', '张三', '李四']
                    },
                    radar: [
                        {
                            indicator: [
                                { text: '指标一' },
                                { text: '指标二' },
                                { text: '指标三' },
                                { text: '指标四' },
                                { text: '指标五' }
                            ],
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
                            indicator: [
                                { text: '语文', max: 150 },
                                { text: '数学', max: 150 },
                                { text: '英语', max: 150 },
                                { text: '物理', max: 120 },
                                { text: '化学', max: 108 },
                                { text: '生物', max: 72 }
                            ],
                            center: ['75%', '50%'],
                            radius: 120
                        }
                    ],
                    series: [
                        {
                            name: '雷达图',
                            type: 'radar',
                            emphasis: {
                                lineStyle: {
                                    width: 4
                                }
                            },
                            data: [
                                {
                                    value: [100, 8, 0.40, -80, 2000],
                                    name: '图一',
                                    symbol: 'rect',
                                    symbolSize: 5,
                                    lineStyle: {
                                        type: 'dashed'
                                    }
                                },
                                {
                                    value: [60, 5, 0.30, -100, 1500],
                                    name: '图二',
                                    areaStyle: {
                                        color: 'rgba(255, 255, 255, 0.5)'
                                    }
                                }
                            ]
                        },
                        {
                            name: '成绩单',
                            type: 'radar',
                            radarIndex: 1,
                            data: [
                                {
                                    value: [120, 118, 130, 100, 99, 70],
                                    name: '张三',
                                    label: {
                                        show: true,
                                        formatter: function(params) {
                                            return params.value;
                                        }
                                    }
                                },
                                {
                                    value: [90, 113, 140, 30, 70, 60],
                                    name: '李四',
                                    areaStyle: {
                                        opacity: 0.9
                                    }
                                }
                            ]
                        }
                    ]
                }
            }
        },
        created() {
            this.getData({},'','data');
        }
    };
</script>
