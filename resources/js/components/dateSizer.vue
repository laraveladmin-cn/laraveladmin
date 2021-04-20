<template>
    <div class="dateSizer row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 sizer-item">
            <el-date-picker v-model="val[0]"
                            class="w-100"
                            :picker-options="{disabledDate:disabledDateStart}"
                            value-format="yyyy-MM-dd 00:00:00"
                            :placeholder="$t('Start date')"
                            type="date"
                            :editable="false">
            </el-date-picker>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 sizer-item">
            <el-date-picker v-model="val[1]"
                            class="w-100"
                            :picker-options="{disabledDate:disabledDateEnd}"
                            value-format="yyyy-MM-dd 23:59:59"
                            :placeholder="$t('End date')"
                            type="date"
                            :editable="false">
            </el-date-picker>
        </div>
    </div>
</template>

<script>
    export default {
        components:{
            "el-date-picker": ()=>import(/* webpackChunkName: "element-ui/lib/date-picker" */ 'element-ui/lib/date-picker'),
        },
        props: {
            //绑定值
            value: {
                type:[Array],
                default: function () {
                    return ['',''];
                }
            },
        },
        data(){
            return {
                val:this.value
            };
        },
        watch:{
            val(value){
                this.$emit('input', value); //修改值
                this.$emit('change',value); //修改值
            },
            value(value){
                this.val = value;
            }
        },
        methods:{
            disabledDateStart(time){
                if(this.val[1]){
                    let date = new Date(this.val[1]);
                    return time.getTime() > date.getTime();
                }
                return time.getTime() > Date.now(); //小于今天
            },
            disabledDateEnd(time){
                if(this.val[0]){
                    let date = new Date(this.val[0]);
                    let time1 = time.getTime();
                    return time1 < date.getTime() || time1 > Date.now();
                }
                return time.getTime() > Date.now();
            }
        }
    };
</script>
