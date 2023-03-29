<template>
    <div>
        <div class="nav-tabs-custom" style="cursor: move;">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li :class="active==index?'active':''" v-for="(item1,index) in options">
                    <a @click="active=index">
                        {{item1.name}}
                        <button type="button" class="btn btn-box-tool" @click="removeItem1(index)">
                            <i class="fa fa-times"></i>
                        </button>
                    </a>

                </li>
                <li class="pull-right header">
                    <button type="button"
                            class="btn btn-primary btn-sm"
                            :disabled="disabled"
                            @click="addItem">
                        <i class="fa fa-plus"></i>
                        添加配置
                    </button>
                </li>
            </ul>
            <div class="tab-content no-padding">
                <div class="tab-pane"
                     :class="active==index?'active':''"
                     v-for="(item1,index) in options">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item :key-name="'options.'+index+'.name'"
                                       :options="{name: '标题',type:'text', rules:'required',title:''}"
                                       :datas="datas">
                            </edit-item>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item :key-name="'options.'+index+'.icon'"
                                       :options="{name: '标题图标',type:'text', rules:'required',title:''}"
                                       :datas="datas">
                                <template slot="input-item">
                                    <icon-edit
                                        v-model="datas.data.row['options'][index]['icon']"
                                        :disabled="disabled"
                                        :placeholder="'请输入'">
                                    </icon-edit>
                                </template>
                            </edit-item>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <edit-item :key-name="'options.'+index+'.value'"
                                       :options="{name: '默认选中',type:'text', rules:'required',title:''}"
                                       :datas="datas">
                                <template slot="input-item">
                                    <div class="edit-item-content">
                                        <el-input-number v-model="datas.data.row['options'][index]['value']"
                                                         class="w-100"
                                                         size="medium"
                                                         :min="0"
                                                         :max="datas.data.row['options'][index]['items'].length-1"
                                                         :step="1">
                                        </el-input-number>
                                    </div>
                                </template>
                            </edit-item>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th>选项名称</th>
                                    <th>选项图标</th>
                                    <th>选项值</th>
                                    <th style="width: 40px">
                                        操作
                                    </th>
                                </tr>
                                <tr v-for="(item2,index2) in item1.items">
                                    <td>
                                        <edit-item :key-name="'options.'+index+'.items.'+index2+'.name'"
                                                   :options="{name: '名称'+(index2+1),type:'text', rules:'required',title:''}"
                                                   :datas="datas">
                                        </edit-item>
                                    </td>
                                    <td>
                                        <edit-item :key-name="'options.'+index+'.items.'+index2+'.icon'"
                                                   :options="{name: '图标'+(index2+1),type:'text', rules:'',title:''}"
                                                   :datas="datas">
                                            <template slot="input-item">
                                                <icon-edit
                                                    v-model="datas.data.row['options'][index]['items'][index2]['icon']"
                                                    :disabled="disabled"
                                                    :placeholder="'请输入'">
                                                </icon-edit>
                                            </template>
                                        </edit-item>
                                    </td>
                                    <td>
                                        <edit-item :key-name="'options.'+index+'.items.'+index2+'.value'"
                                                   :options="{name: '值'+(index2+1),type:'text', rules:'required',title:''}"
                                                   :datas="datas">

                                        </edit-item>
                                    </td>
                                    <td>
                                        <span class="badge bg-red" @click="deleteItem2(index2)">删除</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <button type="button"
                                                class="btn btn-primary btn-sm"
                                                :disabled="disabled"
                                                @click="addItem2">
                                            <i class="fa fa-plus"></i>
                                            添加
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "options",
    components: {
        editItem: ()=>import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
        "el-input-number": ()=>import(/* webpackChunkName: "element-ui/lib/input-number" */ 'element-ui/lib/input-number'),
        "iconEdit": () => import(/* webpackChunkName: "common_components/iconEdit.vue" */ 'common_components/iconEdit.vue'),

    },
    props:{
        disabled:{
            default: function () {
                return false;
            }
        },
        datas:{
            type: [Object],
            default: function () {
                return {
                    error:{},
                    data:{
                        row:{},
                        configUrl:{}
                    }
                };
            }
        },
    },
    data(){
        return {
            item:{
                name:'名称',
                icon:'',
                value:0,
                items:[
                    {name:'',value:'',icon:''}
                ],

            },
            active:0
        };
    },
    watch:{
        disabled(){

        },
        'datas.data.row.options'(){

        }
    },
    methods:{
        addItem(){
            this.options.push(copyObj(this.item));
        },
        addItem2(){
            this.options[this.active].items.push(copyObj(this.item.items[0]));
        },
        deleteItem2(index){
            this.options[this.active].items.splice(index,1);
        },
        removeItem1(index){
            this.options.splice(index,1);
        }
    },
    computed:{
        options(){
            return this.datas.data.row.options;
        },

    }
}
</script>

<style scoped>
.tab-pane{
    padding: 10px;
}
</style>
