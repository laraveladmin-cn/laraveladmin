<template>
<div>
    <table class="table">
        <tbody class="tr-items">
        <tr>
            <th v-for="(field,i) in fields">
                {{field}}
            </th>
            <th class="controls">{{$t('Operation')}}</th>
        </tr>
        <tr v-for="(item,index) in items" class="tr-item" :data-id="index">
            <td v-for="(field,i) in fields">
                <slot name="col" :vid="keyValue+'.'+index+'.'+i" :field-key="i" :field-name="field" :item="item">
                    <validation-provider :vid="keyValue+'.'+index+'.'+i" :name="field" v-slot="{ errors }">
                        <div :class="{'has-error':(errors && errors.length>0)}">
                            <input type="text" v-model="item[i]" :disabled="disabled" placeholder="请输入" class="form-control input-sm"/>
                        </div>
                    </validation-provider>
                </slot>
            </td>
            <td class="operation">
                <button class="btn btn-danger btn-xs"
                        :disabled="disabled"
                        @click="delItem(index)"
                >
                    删除
                </button>
            </td>
        </tr>
        <tr v-if="!items_length">
            <td :colspan="fields_count" class="text-center">
                暂无数据
            </td>
        </tr>
        <tr>
            <td :colspan="fields_count" class="text-center">
                <button class="btn btn-block btn-primary btn-xs"
                        @click="addItem"
                        :disabled="disabled">
                    <i class="fa fa-plus"></i>
                    添加
                </button>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</template>

<script>
import {ValidationProvider} from 'vee-validate';
import Sortable from 'sortablejs';
export default {
    name: "many.vue",
    components: {
        ValidationProvider,
    },
    props:{
        value: {
            type:[Array,Object],
            default: function () {
                return [];
            }
        },
        newItem:{
            type:[Object],
            default: function () {
                return {};
            }
        },
        disabled:{
            default: function () {
                return false;
            }
        },
        fields:{
            type:[Object],
            default: function () {
                return {};
            }
        },
        sortKey:{
            type: [String],
            default: function () {
                return '_sort';
            }
        },
        keyValue:{
            type: [String],
            default: function () {
                return '';
            }
        },

    },
    data(){
        return {
            items:this.value
        }
    },
    watch:{
        newItem(){

        },
        value(val){
            if(this.items!=val){
                this.items = val;
            }
        },
        items(val){
            this.$emit('input', val); //修改值
            this.$emit('change',val); //修改值
        }
    },
    methods:{
        addItem(){
            let item = copyObj(this.newItem);
            if(typeof this.items=="undefined"){
                this.items = [];
            }
            let sort = this.items_length?collect(this.items).values().max(this.sortKey):0;
            array_set(item,this.sortKey,sort+1);
            this.items.push(item);
        },
        delItem(index){
            this.items.splice(index, 1);
        },
        //更新排序值
        updateOptionsSortValue(){
            let ids = {};
            let index = 1;
            $(this.$el)
                .find('.tr-item')
                .each(function (){
                    let id = $(this).attr('data-id')-0;
                    ids[id]=index;
                    index++;
                });
            collect(this.items).each((option,index)=>{
                array_set(option,this.sortKey,array_get(ids,index,0));
            });

        }
    },
    computed:{
        items_length(){
            if(!this.items){
                return 0;
            }
            return collect(this.items).values().count();
        },
        fields_count(){
            return collect(this.fields).values().count()+1;
        }
    },
    mounted() {
        let $this = this;
        $(this.$el).find('.tr-items').each(function () {
            new Sortable(this,  {
                animation: 1000,
                draggable: ".tr-item",
                filter: ".ignore-move-item-content",  // 过滤器，不需要进行拖动的元素
                preventOnFilter: false, //  在触发过滤器`filter`的时候调用`event.preventDefault()`
                group: { name: "many_"+$this._uid, pull: false, put: false },
                // 结束拖拽
                onEnd: function (evt) {
                    $this.updateOptionsSortValue();
                },
            });
        });
    },
}
</script>

<style scoped>
.controls{
    width: 50px;
    vertical-align: middle;
}
</style>
