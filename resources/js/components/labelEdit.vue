<template>
    <div class="btn-group btn-group-justified" role="group" aria-label="Justified button group" @click="onClick">
        <a class="btn"
           role="button"
           v-for="(item, index) in maps"
           :key="index"
           :class="active(item.value)?'btn-primary':'btn-default'"
           @click="onChange(item.value)">
            {{ showName(item) }}
        </a>
    </div>
</template>

<script>
    export default {
        name: "labelEdit",
        props: {
            map:{
                default() {
                    return {};
                }
            },
            value:{
                default() {
                    return '';
                }
            },
            multi:{
                type: [Boolean],
                default() {
                    return false;
                }
            },
            disabled:{
                default() {
                    return false;
                }
            },
            valueIsKey:{
                type: [Boolean],
                default() {
                    return false;
                }
            },
            clickPlaceholder:{
                type: [Function],
                default() {
                    return ()=>{};
                }
            },
            pluck:{
                type: [Object,Boolean],
                default() {
                    return false;
                }
            },
            title:{
                default() {
                    return '';
                }
            },
            show:{
                default() {
                    return 'name';
                }
            }

        },
        data(){
            return {
                data:this.value
            };
        },
        watch:{
            data(val,old) {
                if(val!=this.value){
                    this.$emit('input', val); //修改值
                    this.$emit('change',val); //修改值
                }
            },
            value(val,old){
                if(val!=this.data){
                    this.data = val;
                }
            },
            map(){

            }
        },
        methods:{
            onClick(){
                this.clickPlaceholder();
                this.$emit('click');
            },
            onChange(value){
                //禁用
                if(this.disabled){
                    return ;
                }
                if(this.multi){
                    if(this.active(value)){ //已选中,取消选中
                        this.data = this.data.filter(value => this.data!=value);
                    }else { //未选中,选中
                        this.data.push(value);
                    }
                }else {
                    this.data = value;
                }
            },
            active(value){
                if(this.multi){ //多选
                    return this.data.indexOf(value)!=-1;
                }else {
                    return value==this.data;
                }
            },
            showName(item){
                return array_get(item,this.show,'');
            }
        },
        computed:{
            maps(){
                let map;
                let pluck = this.pluck;
                if(pluck){
                    if(pluck===true){
                        pluck = {value:'id',name:'name'};
                    }
                    map = collect(this.map).map((value,key)=>{
                        return {value:value[pluck.value],name:value[pluck.name]};
                    }).values().all();
                }else {
                    if(this.valueIsKey){
                        map = collect(this.map).map((value)=>{
                            return {value:value,name:value};
                        }).values().all();
                    }else {
                        map = collect(this.map).map((value,key)=>{
                            return {value:key,name:value};
                        }).values().all();
                    }
                }
                return map;
            },
            has_map(){
                return collect(this.maps).count();
            }
        }
    }
</script>

<style scoped>


</style>
