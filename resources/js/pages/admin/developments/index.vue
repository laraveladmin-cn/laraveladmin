<template>
    <div class="row">
        <section class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs ui-sortable-handle">
                    <li class="active">
                        <a href="#console" data-toggle="tab">控制台命令</a>
                    </li>
                    <li>
                        <a href="#menus" data-toggle="tab">菜单路由</a>
                    </li>
                    <li>
                        <a href="#plug_in" data-toggle="tab">插件安装</a>
                    </li>
                    <li>
                        <a href="#docs" data-toggle="tab">相关文档</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="chart tab-pane active" id="console">
                        <edit :options="options" ref="edit">
                            <template slot="content" slot-scope="props">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <h3 class="text-center">
                                        命令名称: {{props.data.row.chinese}}
                                    </h3>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                    <edit-item :key-name="'index'"
                                               :options="{name:'选择命令',rules:'required',title:'需要执行的命令'}"
                                               :datas="props">
                                        <template slot="input-item">
                                            <div class="edit-item-content">
                                                <select2 v-model="props.data.index"
                                                         :default-options="commands"
                                                         :placeholder-show="'请选择'"
                                                         :placeholder-value="0"
                                                         :primary-key="'_id'"
                                                         @change="changeCommand(props.data)"
                                                         :show="['command','chinese']" >
                                                </select2>
                                            </div>
                                        </template>
                                    </edit-item>
                                    <div v-if="props.data.row.parameters">
                                        <div v-for="(item,index) in props.data.row.parameters">
                                            <edit-item :key-name="'parameters.'+index+'.value'"
                                                       v-if="item.type=='select2tables'"
                                                       :options="item"
                                                       :datas="props"
                                                       :key="index">
                                                <template slot="input-item">
                                                    <div class="edit-item-content">
                                                        <select2 v-model="item.value"
                                                                 :default-options="[]"
                                                                 :url="use_url+'/admin/developments/tables'"
                                                                 :keyword-key="'TABLE_NAME'"
                                                                 :show="['TABLE_NAME']"
                                                                 :disabled="!props.url"
                                                                 :primary-key="'TABLE_NAME'"
                                                                 :placeholder-show="'请选择'"
                                                                 :placeholder-value="''"
                                                                 @change="clearInput"
                                                                 :params="{connection:connection_value(props.data.row.parameters)}"
                                                                 :is-ajax="true" >
                                                        </select2>
                                                    </div>
                                                </template>
                                            </edit-item>
                                            <edit-item :key-name="'parameters.'+index+'.value'"
                                                       v-else-if="item.type=='select2'"
                                                       :options="item"
                                                       :datas="props"
                                                       :key="index">
                                                <template slot="input-item">
                                                    <div class="edit-item-content">
                                                        <select2 v-model="item.value"
                                                                 :default-options="array_get(props,'data.maps.'+item.map_key,[])"
                                                                 :placeholder-show="'请选择'"
                                                                 :disabled="!props.url"
                                                                 :placeholder-value="''"
                                                                 @change="clearInput"
                                                                 :is-ajax="false" >
                                                        </select2>
                                                    </div>
                                                </template>
                                            </edit-item>
                                            <edit-item :key-name="'parameters.'+index+'.value'"
                                                       v-else
                                                       :options="item"
                                                       :datas="props"
                                                       :key="index">
                                            </edit-item>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group" :class="{'has-error':inputCommand && command(props.data.row)!=inputCommand}">
                                        <label>手动输入命令:</label>
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                v-model.trim="inputCommand"
                                                class="form-control"
                                                :placeholder="'请输入'">
                                            <div class="input-group-addon" v-clipboard:copy="inputCommand"  v-clipboard:success="onCopy" >
                                                <i class="fa fa-copy"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>命令:</label>
                                        <div v-clipboard:copy="command(props.data.row)"  v-clipboard:success="onCopy" class="snippet command">
                                            <button class="btn">
                                                <img class="clippy" width="13" src="https://clipboardjs.com/assets/images/clippy.svg" alt="复制到粘贴板">
                                                复制到粘贴板
                                            </button>
                                            <code>
                                                {{command(props.data.row)}}
                                            </code>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>执行结果:</label>
                                        <div>

                                        </div>
                                    </div>

                                </div>
                            </template>
                        </edit>
                        <div>
                            <table class="table table-hover table-bordered table-striped text-center dataTable">
                                <thead>
                                <tr>
                                    <th>命令</th>
                                    <th>说明</th>
                               <!--     <th>English</th>-->
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in commands">
                                    <td v-clipboard:copy="'php artisan '+item.command"  v-clipboard:success="onCopy" class="snippet">
                                        <button class="btn" data-clipboard-snippet=""><img class="clippy" width="13" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard"></button>
                                        <code>{{item.command}}</code>
                                    </td>
                                    <td>{{item.chinese}}</td>
                                 <!--   <td>{{item.english}}</td>-->
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="chart tab-pane" id="menus">
                        菜单内容
                    </div>
                    <div class="chart tab-pane" id="plug_in">
                        安装应用插件
                    </div>
                    <div class="chart tab-pane" id="docs">
                        相关文档
                    </div>
                </div>
            </div>

        </section>
    </div>
</template>

<script>
    import {mapActions,mapState} from 'vuex';
    let $this;
    export default {
        components: {
            'edit': () => import(/* webpackChunkName: "common_components/edit.vue" */ 'common_components/edit.vue'),
            "edit-item": () => import(/* webpackChunkName: "common_components/editItem.vue" */ 'common_components/editItem.vue'),
            "select2":()=>import(/* webpackChunkName: "common_components/select2.vue" */ 'common_components/select2.vue'),

        },
        data() {
            return {
                options: {
                    id: 'edit', //多个组件同时使用时唯一标识
                    url: '/admin/developments/index', //数据表请求数据地址
                    params: {},
                    fixed: true,
                    callback: (response, row) => { //修改成功

                    }
                },
                commands:[],
                interval:'',
                inputCommand:''
            }
        },
        mounted() {
            this.interval = setInterval(()=>{
                if(this.$refs['edit'].data.commands){
                    this.commands = this.$refs['edit'].data.commands;
                    clearInterval(this.interval);
                }
            },500);
            $this = this;
        },
        computed:{
            ...mapState([
                'use_url'
            ])
        },
        methods:{
            ...mapActions({
                refreshToken: 'refreshToken',
                pushMessage: 'pushMessage',
            }),
            onCopy:  (e)=> {
                $this.pushMessage({
                    'showClose':true,
                    'title':e.text+' 命令复制成功!',
                    'message':'',
                    'type':'success',
                    'position':'top',
                    'iconClass':'fa-check',
                    'customClass':'',
                    'duration':3000,
                    'show':true
                });
            },
            command(command){
                let parm_str = collect(command.parameters).filter((parameter)=>{
                    return parameter.value;
                }).map((parameter)=>{
                    return ' --'+parameter.key+'='+parameter.value;
                }).implode('');
                return 'php artisan '+command.command+parm_str;
            },
            connection_value(parms){
                return collect(parms).first((parm)=>{
                    return parm.key=='connection';
                }).value;
            },
            changeCommand(data){
                data.row = data.commands[data.index-1];
                this.clearInput();
            },
            clearInput(){
                this.inputCommand = '';
            }
        },
        watch:{
            //手动修改输入命令
            inputCommand(val){
                if(val){
                    let values = collect(val.replace('php artisan ','').split(' '));
                    let command = values.shift();
                    //反向修改命令
                    let row = copyObj(collect(this.commands).keyBy('command').get(command));
                    values = values.filter((value)=>{
                        return value;
                    }).map((value)=>{
                        let param = value.replace('--','').split('=');
                        return {
                            key:param[0],
                            value:param[1] || ''
                        }
                    }).pluck('value','key').all();
                    collect(row.parameters || []).each((parameter)=>{
                        if(typeof values[parameter.key]=="undefined"){
                            parameter.value = parameter._value;
                        }else {
                            parameter.value = values[parameter.key];
                        }
                    });
                    this.$refs['edit'].data.index = row['_id'];
                    this.$refs['edit'].data.row = row;
                }

            }
        }
    }
</script>

<style scoped>
.command{
    margin-bottom: 10px ;
}
</style>
