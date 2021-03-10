<template>
    <div>
        <edit :options="options" ref="menuTree">
            <template slot="content" slot-scope="props">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ztree :check-enable="false"
                           :multiple="false"
                           :disabled="!props.url || props.data.row['resource_id']>0"
                           :id="'menus_tree'"
                           :config="config"
                           :data="props.data.tree">
                    </ztree>
                </div>
            </template>
        </edit>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    let $this;
    export default {
        props: {
            callback: {
                type: [Function],
                default: function () {
                    return function () {
                    };
                }
            },
        },
        components: {
            "ztree": () => import(/* webpackChunkName: "common_components/ztree.vue" */ 'common_components/ztree.vue'),
            'edit': () => import(/* webpackChunkName: "common_components/edit.vue" */ 'common_components/edit.vue'),
            "edit-item": () => import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
        },
        data:()=>{
            return {
                config:{
                    edit:{
                        drag: {
                            autoExpandTrigger: true,
                            prev: function (treeId, nodes, targetNode) {
                                return true;
                            },
                            inner: function (treeId, nodes, targetNode) {
                                return true;
                            },
                            next: function (treeId, nodes, targetNode) {
                                return true;
                            }
                        },
                        enable: true,
                        showRemoveBtn: false,
                        showRenameBtn: false
                    },
                    enable: true,
                    check: {
                        enable: true,
                        chkboxType: {"Y": "", "N": ""}
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
                        beforeDrag:(treeId, treeNodes)=>{
                            for (let i=0,l=treeNodes.length; i<l; i++) {
                                if (treeNodes[i].drag === false) {
                                    return false;
                                } else if (treeNodes[i].parentTId && treeNodes[i].getParentNode().childDrag === false) {
                                    return false;
                                }
                            }
                            return true;
                        },
                        //完成拖拽
                        onDrop(event, treeId, treeNodes, targetNode, moveType, isCopy){
                            if(!targetNode){
                                return;
                            }
                            collect(treeNodes).map((item)=>{
                                if(moveType=='inner'){
                                    $this.$refs.menuTree.data.row.update_position.push({from:item.id,to:targetNode.id,type:"update"});
                                    item._parent_id = targetNode.id;
                                }else if(item._parent_id!=targetNode._parent_id){
                                    $this.$refs.menuTree.data.row.update_position.push({from:item.id,to:targetNode._parent_id,type:"update"});
                                    item._parent_id = targetNode._parent_id;
                                }
                            });
                            collect(treeNodes).map((item)=>{
                                if(moveType=='next' || moveType=='prev'){
                                    $this.$refs.menuTree.data.row.update_position.push({from:item.id,to:targetNode.id,type:moveType=='next'?"after":"before"});
                                }
                            });
                        },
                         beforeDrop(treeId, treeNodes, targetNode, moveType, isCopy) {
                             if(moveType=='next' || moveType=='prev'){
                                 if(targetNode._level<=1){
                                     return false;
                                 }
                             }
                             if(!targetNode){
                                 return false;
                             }
                            return true;
                        }
                    }
                },
                options: {
                    id: 'editTree', //多个组件同时使用时唯一标识
                    url: '/admin/menus/tree', //数据表请求数据地址
                    params:{},
                    no_back: true,
                    callback:(response,row)=>{ //修改成功
                        $this.getMenus();
                        $this.callback();
                        $this.$refs.menuTree.data.row.update_position = [];
                        $this.$refs.menuTree.getData({});
                    }
                },
            };
        },
        created() {
            $this  = this;
        },
        methods: {
            ...mapActions({
                getMenus:'menu/getMenus', //更新菜单
            })
        }

    };
</script>
<style scoped>

</style>
