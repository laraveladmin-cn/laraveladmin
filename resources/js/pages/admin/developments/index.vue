<template>
    <div class="row">
        <section class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs ui-sortable-handle">
                    <li class="active">
                        <a href="#console" data-toggle="tab" @click="switchTag(0)">{{$tp('Console commands')}}</a>
                    </li>
                    <li>
                        <a href="#menus" data-toggle="tab" @click="switchTag(1)">{{$tp('Menu routing')}}</a>
                    </li>
                    <li>
                        <a href="#plug_in" data-toggle="tab" @click="switchTag(2)">{{$tp('Plug-in installation')}}</a>
                    </li>
                    <li>
                        <a href="#docs" data-toggle="tab" @click="switchTag(3)">{{$tp('Relevant documentation')}}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="chart tab-pane active" id="console">
                        <edit :options="options" ref="edit">
                            <template slot="content" slot-scope="props">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <h3 class="text-center">
                                        {{$tp('Command name:')}} {{$tp(props.data.row.name)}}
                                    </h3>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                    <edit-item :key-name="'index'"
                                               :options="{name:$tp('Select the command'),rules:'required',title:$tp('Command that needs to be executed')}"
                                               :datas="props">
                                        <template slot="input-item">
                                            <div class="edit-item-content">
                                                <select2 v-model="props.data.index"
                                                         :default-options="_commands"
                                                         :placeholder-show="$t('Please select')"
                                                         :placeholder-value="0"
                                                         :primary-key="'_id'"
                                                         @change="changeCommand(props.data)"
                                                         :show="['command','_name']" >
                                                </select2>
                                            </div>
                                        </template>
                                    </edit-item>
                                    <div v-if="props.data.row.parameters">
                                        <div v-for="(item,index) in props.data.row.parameters">
                                            <edit-item :key-name="'parameters.'+index+'.value'"
                                                       v-if="item.type=='select2tables'"
                                                       :options="transItem(item)"
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
                                                                 :placeholder-show="item.placeholder || $t('Please select')"
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
                                                       :options="transItem(item)"
                                                       :datas="props"
                                                       :key="index">
                                                <template slot="input-item">
                                                    <div class="edit-item-content">
                                                        <select2 v-model="item.value"
                                                                 :default-options="transMap(props,item)"
                                                                 :placeholder-show="item.placeholder || $t('Please select')"
                                                                 :disabled="!props.url"
                                                                 :placeholder-value="''"
                                                                 @change="clearInput"
                                                                 :is-ajax="false" >
                                                        </select2>
                                                    </div>
                                                </template>
                                            </edit-item>
                                            <edit-item :key-name="'parameters.'+index+'.value'"
                                                       v-else-if="item.type=='checkbox'"
                                                       :options="transItem(item)"
                                                       :datas="props"
                                                       :key="index">
                                                <template slot="input-item">
                                                    <div class="row">
                                                        <div v-for="(item1,index) in (item.map || array_get(props,'data.maps.'+item.map_key,[]))" class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                            <icheck v-model="item.value" :option="index" :disabled="!props.url" :label="$tp(item1)"> {{$tp(item1)}}</icheck>
                                                        </div>
                                                    </div>
                                                </template>
                                            </edit-item>
                                            <edit-item :key-name="'parameters.'+index+'.value'"
                                                       v-else-if="item.type=='switch'"
                                                       :options="transItem(item)"
                                                       :datas="props"
                                                       :key="index">
                                                <template slot="input-item">
                                                    <div class="edit-item-content">
                                                        <el-switch v-model="item.value"
                                                                   :active-text="$t('Yes')"
                                                                   :inactive-text="$t('No')"
                                                                   :active-value="1"
                                                                   :inactive-value="0">
                                                        </el-switch>
                                                    </div>
                                                </template>
                                            </edit-item>
                                            <edit-item :key-name="'parameters.'+index+'.value'"
                                                       v-else
                                                       :options="transItem(item)"
                                                       :datas="props"
                                                       :key="index">
                                            </edit-item>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group" :class="{'has-error':inputError(props)}">
                                        <label>{{$tp('Enter the command manually:')}}</label>
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                v-model.trim="inputCommand"
                                                class="form-control"
                                                :placeholder="$t('Please enter')">
                                            <div class="input-group-addon" v-clipboard:copy="inputCommand"  v-clipboard:success="onCopy" >
                                                <i class="fa fa-copy"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>{{$tp('Command:')}}</label>
                                        <div v-clipboard:copy="command(props.data.row)"  v-clipboard:success="onCopy" class="snippet command">
                                            <button class="btn">
                                                <img class="clippy" width="13" src="https://clipboardjs.com/assets/images/clippy.svg" :alt="$tp('Copy it to the paste board')">
                                                {{$tp('Copy it to the paste board')}}
                                            </button>
                                            <code>
                                                {{command(props.data.row)}}
                                            </code>
                                        </div>
                                    </div>
                                </div>

                            </template>
                        </edit>
                        <div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" v-show="output">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{$tp('Execute results:')}}</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <div class="output-body">{{output}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-hover table-bordered table-striped text-center dataTable">
                                <thead>
                                <tr>
                                    <th>{{$tp('Command')}}</th>
                                    <th>{{$tp('Instructions')}}</th>
                                    <!--     <th>English</th>-->
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in _commands">
                                    <td v-clipboard:copy="'php artisan '+item.command"  v-clipboard:success="onCopy" class="snippet">
                                        <button class="btn" data-clipboard-snippet=""><img class="clippy" width="13" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard"></button>
                                        <code>{{item.command}}</code>
                                    </td>
                                    <td>{{item._name}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="chart tab-pane" id="menus">
                        <menus v-if="tag==1"></menus>
                    </div>
                    <div class="chart tab-pane" id="plug_in">
                        {{$tp('Install the application plug-in')}}
                    </div>
                    <div class="chart tab-pane" id="docs">
                        {{$tp('Relevant documentation')}}
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
            "el-switch": ()=>import(/* webpackChunkName: "element-ui/lib/switch" */ 'element-ui/lib/switch'),
            "menus": ()=>import(/* webpackChunkName: "pages/admin/developments/menus" */ 'pages/admin/developments/menus.vue'),
            "icheck":()=>import(/* webpackChunkName: "common_components/icheck.vue" */ 'common_components/icheck.vue'),

        },
        data() {
            return {
                "{lang_path}":'admin.developments_index',
                options: {
                    id: 'edit', //多个组件同时使用时唯一标识
                    url: '/admin/developments/index', //数据表请求数据地址
                    params: {},
                    fixed: true,
                    no_back:true,
                    callback: (response, row) => { //修改成功
                        this.output = response.data.output || '';
                    },
                    resetCallback(){
                        $this.clearInput();
                    },
                },
                commands:[],
                interval:'',
                inputCommand:'',
                output:'',
                tag:0
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
        destroyed() {
          if(this.interval)  {
              clearInterval(this.interval);
          }
        },
        computed:{
            ...mapState([
                'use_url'
            ]),
            _commands(){
                return collect(this.commands).map((item)=>{
                    item._name = this.$tp(item.name);
                    return item;
                }).all();
            }
        },
        methods:{
            ...mapActions({
                refreshToken: 'refreshToken',
                pushMessage: 'pushMessage',
            }),
            switchTag(val){
                this.tag = val;
            },
            //复制粘贴板成功后执行
            onCopy:  (e)=> {
                $this.pushMessage({
                    'showClose':true,
                    'title':e.text+' '+$this.$t('{action} successfully!',{action:$this.$t('Command copy')}),
                    'message':'',
                    'type':'success',
                    'position':'top',
                    'iconClass':'fa-check',
                    'customClass':'',
                    'duration':3000,
                    'show':true
                });
            },
            //线上组装后的命令
            command(command){
                let parm_str = collect(command.parameters).filter((parameter)=>{
                    return parameter.value;
                }).map((parameter)=>{
                    if(parameter.is_option){
                        if(parameter.is_boolean){
                            return parameter.value?' --'+parameter.key:'';
                        }else {
                            if(Array.isArray(parameter.value) && !parameter.value.length){
                                return ''
                            }
                            return ' --'+parameter.key+'='+parameter.value;
                        }
                    }else {
                        return ' '+parameter.value;
                    }
                }).implode('');
                let _exec = (command.command  || '')+parm_str;
                if(this.$refs['edit'] && this.$refs['edit'].data && this.$refs['edit'].data.row._exec != _exec){
                    this.$refs['edit'].data.row._exec = _exec;
                }
                return 'php artisan '+(_exec || '');
            },
            //连接参数
            connection_value(parms){
                return collect(parms).first((parm)=>{
                    return parm.key=='connection';
                }).value;
            },
            //修改命令清空手动输入
            changeCommand(data){
                data.row = data.commands[data.index-1];
                this.clearInput();
            },
            clearInput(){
                this.inputCommand = '';
            },
            inputError(props){
                if(!this.inputCommand){
                    return false;
                }
                let command = props.data.row;
                let keys_as = collect(command.parameters).filter((parameter)=>{
                    return parameter.key_as;
                }).pluck('key','key_as');
                let inputCommand = this.inputCommand.replace(/  /g,' ').replace(/  /g,' ');
                inputCommand = collect(inputCommand.split(' '))
                    .map((value)=>{
                        if(value.indexOf('--')!=-1){
                            let param = value.replace('--','').split('=');
                            keys_as.each((key,key_as)=>{
                                if(param[0]==key_as){
                                    param[0]=key;
                                }
                            });
                            return  '--'+collect(param).implode('=');
                        }
                       return value;
                    })
                    .sort()
                    .implode(' ');
                let inputCommand1 = this.command(props.data.row);
                inputCommand1 = collect(inputCommand1.split(' ')).sort().implode(' ');
               return inputCommand1!=inputCommand;
            },
            transItem(item){
                let item1 = copyObj(item);
                 collect(['name','title','map']).each((key)=>{
                     let value = item1[key];
                    if(value && typeof value=="object"){
                        item1[key] = collect(value).map((v)=>{
                            if(typeof v=="string"){
                                return this.$tp(v);
                            }else {
                                return v;
                            }
                        }).all();
                    }else if(value && typeof value=="string"){
                        item1[key] = this.$tp(value);
                    }
                });
                 return item1;
            },
            transMap(props,item){
                let map = item.map || array_get(props,'data.maps.'+item.map_key,[]);
                map = collect(map).map((value,key)=>{
                    if(value && typeof value=="string"){
                        return this.$tp(value);
                    }else {
                        return value;
                    }
                }).all();
                return map;
            }
        },
        watch:{
            //手动修改输入命令
            inputCommand(val){
                if(val){
                    let values = collect(val.replace(/  /g,' ')
                        .replace(/  /g,' ') //去除多余空格
                        .replace('php artisan ','') //去除前置命令
                        .split(' '));
                    let command = values.shift(); //命令集
                    let item  = collect(this.commands).keyBy('command').get(command);
                    if(!item || typeof item.command=="undefined"){
                        return ;
                    }
                    //反向修改命令
                    let row = copyObj(item);
                    //参数
                    let parms = values.filter((value)=>{
                        return value && value.indexOf('--')==-1;
                    }).values()
                        .map((value,index)=>{
                        return {
                            key:index+'',
                            value:value
                        }
                    }).pluck('value','key')
                        .all();
                    //选项
                    let options = values.filter((value)=>{
                        return value && value.indexOf('--')!=-1;
                    }).map((value)=>{
                        let param = value.replace('--','').split('=');
                        return {
                            key:param[0],
                            value:param[1] || ''
                        }
                    }).pluck('value','key')
                        .all();
                    let index = 0;
                    collect(row.parameters || []).each((parameter)=>{
                        if(!parameter.is_option){ //参数
                            if(typeof parms[index]=="undefined"){
                                parameter.value = '';
                            }else {
                                parameter.value = parms[index];
                            }
                            index = index+1;
                        }else { //选项
                            if(parameter.is_boolean){
                                if(typeof options[parameter.key]!="undefined"){
                                    parameter.value = 1;
                                }else if(parameter.key_as && typeof options[parameter.key_as]!="undefined"){
                                    parameter.value = 1;
                                }else {
                                    parameter.value = 0;
                                }
                            }else {
                                if(typeof options[parameter.key]!="undefined"){
                                    parameter.value = options[parameter.key];
                                }else if(parameter.key_as && typeof options[parameter.key_as]!="undefined"){
                                    parameter.value = options[parameter.key_as];
                                }else {
                                    parameter.value = parameter._value;
                                }
                            }
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
.output-body {
    white-space: pre-wrap;
    background: #000000;
    color: #00fa4a;
    padding: 10px;
    border-radius: 0;
 /*   max-height: 500px;
    overflow: scroll;*/
}
    .box{
        margin-top: 10px;
    }
</style>
