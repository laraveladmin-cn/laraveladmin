<template>
    <div @mouseout="$emit('blur')">
        <ul class="ztree" :id="'ztree_'+id"></ul>
    </div>
</template>
<script>
    require('ztree/js/jquery.ztree.all.min');
    let $this;
    export default {
        props:{
            //ztree配置
            config:{
                type: Object,
                default: function () {
                    return {
                        check: {
                            enable: true,
                            chkboxType: {"Y": "ps", "N": "s"}
                        },
                        data: {
                            simpleData: {
                                enable: true,
                                idKey: "id",
                                pIdKey: "parent_id",
                                rootPId: 0
                            }
                        },
                        view: {
                            showIcon: false,
                            dblClickExpand: false
                        },
                        callback: {
                            beforeClick(treeId, treeNode, clickFlag){
                                return !$this.disabled;
                            },
                            onCheck:  (e, id, node)=> {
                                let data;
                                if(this.multiple){
                                    data = collect(this.ztree.getCheckedNodes()).filter().pluck('id').sort().all();
                                }else {
                                    data = node.id;
                                }
                                this.$emit('input', data); //修改值
                                this.$emit('change',data); //修改值
                            }
                        }
                    };
                }
            },
            //绑定值
            value: {
                type:[String, Number,Array,Object],
                default: function () {
                    return [];
                }
            },
            //默认选项
            data:{
                type: [Object,Array],
                default: function () {
                    return [];
                }
            },
            expandAll:{
                type: [Boolean],
                default: function () {
                    return true;
                }
            },
            id:{
                type: [String]
            },
            multiple:{
                type: [Boolean],
                default: function () {
                    return true;
                }
            },
            chkboxType:{
                type: [Object],
                default: function () {
                    return {"Y": "ps", "N": "s"};
                }
            },
            checkEnable:{
                type: [Boolean],
                default: function () {
                    return true;
                }
            },
            disabled:{
                type: [Boolean],
                default: function () {
                    return false;
                }
            }
        },
        data(){
            return {
                ztree:null,
                val:typeof this.value =="object" ? collect(copyObj(this.value)).sort().all():this.value
            };
        },
        methods:{
            init(){
                let $this = this;
                    let ztree = $.fn.zTree.init($(this.$el).find('ul'),this.mainConfig,this.mainDatas);
                    this.ztree = ztree;
                    if(this.expandAll){
                        ztree.expandAll(true); //全部展开
                    }
                if(!this.multiple){
                    this.ztree.selectNode(this.ztree.getNodeByParam("id", this.val));
                }
                this.disabledChange(this.disabled);
            },
            disabledChange(value){
                collect(this.ztree.transformToArray(this.ztree.getNodes())).map((item)=>{
                    this.ztree.setChkDisabled(item, value);
                });
            }
        },
        mounted() {
            $this = this;
            this.init();
        },
        watch:{
            //重置数据还原
            value(value,oldValue){
                if(!this.multiple){
                    if(value==this.val){ //值未改变
                        return;
                    }
                    this.ztree.cancelSelectedNode(this.ztree.getNodeByParam("id", oldValue));
                    this.ztree.selectNode(this.ztree.getNodeByParam("id", value));
                    this.val = value;
                }else {
                    let valueObj = collect(value).sort();
                    if(JSON.stringify(valueObj.all())==JSON.stringify(this.val)){ //值未改变
                        return;
                    }
                    //取消旧勾选
                    collect(oldValue).map((val)=>{
                        if(!valueObj.contains(val)){
                            let node = this.ztree.getNodeByParam("id",val);
                            if(node){
                                this.ztree.setChkDisabled(node, false);
                                this.ztree.checkNode(node,false,false);
                                this.disabled && this.ztree.setChkDisabled(node, this.disabled);
                            }
                        }
                    });
                    valueObj.map((val)=>{
                        let node = this.ztree.getNodeByParam("id",val);
                        if(node){
                            this.ztree.setChkDisabled(node, false);
                            this.ztree.checkNode(node,true,false);
                            this.disabled && this.ztree.setChkDisabled(node, this.disabled);
                        }
                    });
                    this.val = valueObj.all();
                }
            },
            disabled(value){
               this.disabledChange(value);
            },
            data(value){
                this.init();
            }


        },
        computed:{
            mainConfig(){
                let config = this.config;
                config.check.chkboxType = this.chkboxType;
                config.check.enable = this.checkEnable;
                if(!this.checkEnable){
                    config.callback.onClick = config.callback.onCheck;
                }
                return config;
            },
            mainDatas(){
                let val = collect(this.val);
                let datas = collect(copyObj(this.data)).map( (item)=> {
                    if(val.contains(item['id'])){
                        item['checked'] = true;
                    }
                    if(this.disabled){ //是否禁用
                        item['chkDisabled'] = true;
                    }
                    return item;
                }).all();
                //console.log(datas);
                return datas;
            }
        },
        updated(){
        }
    }
</script>
<style lang="scss">
    @import url('https://cdn.bootcss.com/zTree.v3/3.5.40/css/zTreeStyle/zTreeStyle.css');
</style>
