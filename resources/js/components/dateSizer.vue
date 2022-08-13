<template>
    <div class="dateSizer row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <el-date-picker v-model="start"
                            class="w-100 sizer-item"
                            :picker-options="{disabledDate:disabledDateStart}"
                            :placeholder="placeholders[0] || $t('Start date')"
                            type="date"
                            :editable="false">
            </el-date-picker>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <el-date-picker v-model="end"
                            class="w-100 sizer-item"
                            :picker-options="{disabledDate:disabledDateEnd}"
                            :placeholder="placeholders[1] || $t('End date')"
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
            placeholders:{
                type:[Array],
                default: function () {
                    return ['',''];
                }
            },
            disabledFuture:{
                type:[Boolean],
                default: function () {
                    return true;
                }
            }
        },
        data(){
            let start = this.value[0];
            if(start && typeof start=="string"){
                start = new Date(start);
            }
            let end = this.value[1];
            if(end && typeof end=="string"){
                end = new Date(start);
            }
            return {
                start:start || '',
                end:end || ''
            };
        },
        watch:{
            start(value){
                this.emitValue();
            },
            end(value){
                this.emitValue();
            },
            value(value){
                if(value[0]!=this.start){
                    let start = value[0];
                    if(start && typeof start=="string"){
                        start = new Date(start);
                    }
                    this.start = start || '';
                }
                if(value[1]!=this.end){
                    let end = value[1];
                    if(end && typeof end=="string"){
                        end = new Date(end);
                    }
                    this.end = end || '';
                }
            }
        },
        methods:{
            emitValue(){
                let start = '';
                if(this.start && typeof this.start=="object"){
                    start = date_format(this.start,'yyyy-MM-dd 00:00:00',true);
                }
                let end = '';
                if(this.end && typeof this.end=="object"){
                    end = date_format(this.end,'yyyy-MM-dd 23:59:59',true);
                }
                if(start!=this.value[0] || end!=this.value[1]){
                    let val = [
                        start,
                        end
                    ];
                    this.$emit('input', val); //修改值
                    this.$emit('change',val); //修改值
                }
            },
            disabledDateStart(time){
                if(this.end){
                    let date = this.end && typeof this.end=="object"?new Date(this.end):this.end;
                    return time.getTime() > date.getTime();
                }
                return this.disabledFuture?time.getTime() > Date.now():false; //小于今天
            },
            disabledDateEnd(time){
                if(this.start){
                    let date = this.start && typeof this.start=="object"? new Date(this.start):this.start;
                    let time1 = time.getTime();
                    return time1 < date.getTime() || (this.disabledFuture?time1 > Date.now():false);
                }
                return this.disabledFuture?time.getTime() > Date.now():false;
            }
        }
    };
</script>
<style scoped>
    .sizer-item{
        margin-top: 10px;
    }
</style>
