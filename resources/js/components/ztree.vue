<template>
    <div @mouseout="$emit('blur')" v-if="refresh_dom">
        <ul class="ztree" :id="'ztree_'+id"></ul>
    </div>
</template>
<script>
    require('ztree/js/jquery.ztree.all.min');
    export default {
        props:{
            //ztree配置
            config:{
                type: Object,
                default: function () {
                    return {
                        enable: true,
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
                            beforeClick:(treeId, treeNode, clickFlag)=>{
                                if(treeNode._disabled){
                                    return false;
                                }
                                return !this.disabled;
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
                val:typeof this.value =="object" ? collect(copyObj(this.value)).sort().all():this.value,
                old_disabled:this.disabled,
                refresh_dom:true
            };
        },
        methods:{
            init(){
                let ul = $(this.$el).find('ul');
                if(this.mainDatas.length){
                    let ztree = $.fn.zTree.init(ul,this.mainConfig,this.mainDatas);
                    this.ztree = ztree;
                    if(this.expandAll){
                        setTimeout(()=>{
                            ztree.expandAll(true); //全部展开
                        },500);
                    }
                    if(!this.multiple && typeof this.val!="object"){
                        this.ztree.selectNode(this.ztree.getNodeByParam("id", this.val));
                    }
                    this.disabledChange(this.disabled);
                }
            },
            disabledChange(value){
                if(this.old_disabled!=value){
                    this.old_disabled = value;
                    setTimeout(()=>{
                        if(this.ztree){
                            collect(this.ztree.transformToArray(this.ztree.getNodes())).map((item)=>{
                                 if(item.tId.indexOf('ztree_'+this.id+'_')==0){
                                     if(item._disabled){
                                         this.ztree.setChkDisabled(item, true);
                                     }else {
                                         this.ztree.setChkDisabled(item, value);
                                     }
                                 }
                            });
                        }
                    },200);
                }
            },
            //重载节点
            reload(){
                this.refresh_dom=false;
                if(this.ztree){
                    this.ztree.destroy();
                    $.fn.zTree.destroy('ztree_'+this.id);
                    this.ztree = null;
                }
                setTimeout(()=>{
                    this.refresh_dom=true;
                    setTimeout(()=>{
                        this.init();
                    },50);
                },10);
            }
        },
        mounted() {
            this.init();
        },
        watch:{
            //重置数据还原
            value(value,oldValue){
                if(!this.multiple){
                    if(value==this.val){ //值未改变
                        return;
                    }
                    if(this.ztree){
                        this.ztree.cancelSelectedNode(this.ztree.getNodeByParam("id", oldValue));
                        this.ztree.selectNode(this.ztree.getNodeByParam("id", value));
                    }
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
                        if(this.ztree){
                            let node = this.ztree.getNodeByParam("id",val);
                            if(node){
                                this.ztree.setChkDisabled(node, false);
                                this.ztree.checkNode(node,true,false);
                                this.disabled && this.ztree.setChkDisabled(node, this.disabled);
                            }
                        }
                    });
                    this.val = valueObj.all();
                }
            },
            disabled(value){
                this.disabledChange(value);
            },
            data(value){
              this.reload();
            },
            chkboxType(value){
                if(this.ztree && this.ztree.setting){
                    this.ztree.setting.check.chkboxType = value;
                }
            },
            '_i18n.locale'(){
                this.reload();
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
                return datas;
            }
        },
        updated(){
        },
        beforeDestroy() {
            if(this.ztree){
                this.ztree.destroy();
                $.fn.zTree.destroy('ztree_'+this.id);
                this.ztree = null;
            }
        }
    }
</script>
<style lang="scss">
    @import "~ztree/css/zTreeStyle/zTreeStyle.css";
</style>
