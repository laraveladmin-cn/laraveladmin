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
                           :data="tree()">
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
                shared: {
                    "{lang_path}": '_shared.menus',
                    '{lang_root}': ''
                },
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
            }),
            tree(){
                let data = collect(array_get(this.$refs,'menuTree.data.tree',[])).each((item)=>{
                    if(typeof item._back_name=="undefined"){
                        item._back_name = item.name;
                    }
                    if(item._language!=this._i18n.locale){
                        item._language = this._i18n.locale;
                        item.name = this.translation(item,'_back_name');
                    }
                    return item;
                }).all();
                return data;
            },
            translation(item,key){
                let value = array_get(item,key,'');
                let resource_id = item['resource_id'];
                let res = this.$tp(value , this.shared);
                if(resource_id && res==value && (this._i18n.locale!='en' || value.indexOf('{')!=-1)){ //没有翻译成功
                    let parent_name = array_get(item,'parent.item_name','') || array_get(item,'parent.name','') || '';
                    let key = value.replace(parent_name,'{name}');
                    let shared = copyObj(this.shared);
                    if(key.indexOf('{name}')==0){
                        shared.name=this.$tp(parent_name,shared);
                    }else {
                        key = value.replace(parent_name.toLowerCase(),'{name}');
                        shared.l_name=this.$tp(parent_name,shared);
                        key = key.replace('{name}','{l_name}');
                    }
                    res = this.$tp(key , shared);
                }
                return res;
            },
            refresh(){
                this.$refs['menuTree'].getData({});
            }
        }

    };
</script>
<style scoped>

</style>
