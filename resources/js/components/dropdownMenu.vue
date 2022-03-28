<template>
    <div class="btn-group" @click="onClick">
        <button type="button"
                class="btn btn-primary dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
            {{showStr}}
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li v-for="(item, index) in maps"
                :key="index"
                @click="onChange(item.value)"
                :class="{active:active(item.value)}">
                <a>{{ showName(item) }}</a>
            </li>
        </ul>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    export default {
        name: "dropdownMenu",
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
            },
            placeholderShow:{
                type:[String,Function],
                default: function () {
                    return 'Please select';
                }
            },

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
                this.data = value;
            },
            active(value){
                return value==this.data;
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
            },
            ...mapState([
                'theme'
            ]),
            showStr(){
                let maps = this.maps;
                for (let i in maps){
                   let item = this.maps[i];
                   if(this.active(item.value)){
                       return this.showName(item);
                   }
                }
                if(typeof this.placeholderShow=="function"){
                    return this.placeholderShow();
                }
                return this.$t(this.placeholderShow);

            }
        }
    }
</script>

<style scoped>

</style>
