import i18n from '../i18n' //语言插件
let downloadChunk = function(options,url,callback,fail){
    axios.get(url,{params:options}).then(callback).catch(fail);
};
let importChunk = function(datas,url,callback,fail){
    axios.post(url, datas).then(callback).catch(fail);
};
// 字符串转ArrayBuffer
let s2ab = function(s) {
    let buf = new ArrayBuffer(s.length);
    let view = new Uint8Array(buf);
    for (let i = 0; i != s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
    return buf;
};
// 将一个sheet转成最终的excel文件的blob对象，然后利用URL.createObjectURL下载
let sheet2blob = function(sheet, sheetName) {
    sheetName = sheetName || 'sheet1';
    let workbook = {
        SheetNames: [sheetName],
        Sheets: {}
    };
    workbook.Sheets[sheetName] = sheet;
    // 生成excel的配置项
    let wopts = {
        bookType: 'xlsx', // 要生成的文件类型
        bookSST: false, // 是否生成Shared String Table，官方解释是，如果开启生成速度会下降，但在低版本IOS设备上有更好的兼容性
        type: 'binary'
    };
    let wbout = XLSX.write(workbook, wopts);
    return new Blob([s2ab(wbout)], {type: "application/octet-stream"});
};

let exportExcel = function(data,sheet,fileName){
    let sheet1 = XLSX.utils.aoa_to_sheet(data);
    let url = sheet2blob(sheet1,sheet);
    let saveName = fileName+'.xlsx';
    if (typeof url == 'object' && url instanceof Blob) {
        url = URL.createObjectURL(url); // 创建blob地址
    }
    let aLink = document.createElement('a');
    aLink.href = url;
    aLink.download = saveName || ''; // HTML5新增的属性，指定保存文件名，可以不要后缀，注意，file:///模式下不会生效
    let event;
    if (window.MouseEvent) {
        event = new MouseEvent('click');
    }else {
        event = document.createEvent('MouseEvents');
        event.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
    }
    aLink.dispatchEvent(event);
};
let data = []; //excel 所有数据
let options =[];
let url = '';
let callback,importCallback;
let last_page = 1; //最后一页
let sheet = '';
let fileName = '';
let fail,importFail;
let reader,errors;
export default {
    namespaced: true,
    state:{
        downloading:false, //下载状态
        download_progress:0, //进度值
        pauseing:false, //暂停状态
        model:0 //0-下载,2-上传
    },
    mutations:{
        //更新state状态
        set (state,payload) {
            state[payload.key] = payload[payload.key];
        }
    },
    actions:{
        //下载继续
        progressStart({ state, commit, rootState }){
            if(state.pauseing){
                if(state.model==0){
                    options['page']++;
                    downloadChunk(options,url,callback,fail);
                }else {
                    importChunk({datas:data.all()},url,importCallback,importFail);
                }
            }
            commit({
                type: 'set',
                key:'pauseing',
                pauseing: false
            });

        },
        //暂停下载
        progressPause({ state, commit, rootState }){
            commit({
                type: 'set',
                key:'pauseing',
                pauseing: true
            });
        },
        //取消下载
        progressCancel({ state, commit, rootState }){
            commit({
                type: 'set',
                key:'downloading',
                downloading: false
            });
            commit({
                type: 'set',
                key:'download_progress',
                download_progress: 0
            });
            commit({
                type: 'set',
                key:'pauseing',
                pauseing: false
            });
            data = []; //清空已下载数据
            errors = []; //错误数据
        },
        //下载excel数据
        download({ state, commit, rootState,dispatch },parms){
            let options1 = parms.options;
            let url1 = parms.url;
            let sheet1 = parms.sheet;
            let fileName1 = parms.fileName;
            let message = {
                'showClose':true,
                'title':'',
                'message':'',
                'type':'danger',
                'position':'top',
                'iconClass':'fa-warning',
                'customClass':'',
                'duration':3000,
                'show':true
            };
            if(typeof XLSX=="undefined"){
                message.title = i18n.t('The XLSX plug-in has not been loaded yet, please try again later');//'XLSX还未加载成功,请稍后再试!';
            }
            if(state.downloading){
                message.title = i18n.t('The import or export task already exists');//'导入或导出任务已存在!';
            }
            if(!url1){
                message.title = i18n.t('Export link address does not exist');//'导出地址不存在!';
            }
            if(typeof XLSX=="undefined" || state.downloading || !url1){
                dispatch('pushMessage', message, { root: true }); //消息提醒
                return ;
            }
            //下载开始
            commit({
                type: 'set',
                key:'downloading',
                downloading: true
            });
            commit({
                type: 'set',
                key:'download_progress',
                download_progress: 0
            });
            commit({
                type: 'set',
                key:'pauseing',
                pauseing: false
            });
            commit({
                type: 'set',
                key:'model',
                model: 0
            });
            data = []; //excel 所有数据
            //查询数据条数
            options = copyObj(options1); //当前条件下
            options['page'] = 0;
            last_page = 1;
            url = rootState['use_url']+url1;
            sheet = sheet1;
            fileName = fileName1;
            if(!callback){
                callback = (response)=>{
                    if(response.status==200){
                        options['page'] = response.data.current_page || 1; //当前页码
                        options['id'] = response.data.max_id || 0; //最大id
                        if(typeof response.data.last_page!="undefined"){
                            last_page = response.data.last_page || 1; //最后一页
                        }
                        commit({
                            type: 'set',
                            key:'download_progress',
                            download_progress: Math.floor(options['page']/last_page*100)
                        });
                        data = collect(data).merge(response.data.data).all(); //放入数据
                        if(options['page']>=last_page){
                            //导出excel
                            exportExcel(data,sheet,fileName);
                            data = []; //清空数据
                            let message = {
                                'showClose' : true, //显示关闭按钮
                                'title' : i18n.t('Download successfully'),//'下载成功!', //消息内容
                                'message' : '', //消息内容
                                'type' : 'success', //消息类型
                                'position' : 'top',
                                'iconClass' : 'fa-check', //图标
                                'customClass' : '', //自定义样式
                                'duration' : 3000, //显示时间毫秒
                                'show' : true //是否自动弹出
                             };
                            dispatch('pushMessage', message, { root: true }); //消息提醒
                            setTimeout(()=>{
                                commit({
                                    type: 'set',
                                    key:'download_progress',
                                    download_progress: 0
                                });
                                commit({
                                    type: 'set',
                                    key:'downloading',
                                    downloading: false
                                });
                                commit({
                                    type: 'set',
                                    key:'pauseing',
                                    pauseing: false
                                });
                            },1000);
                        }else {
                            if(data.length>=100000){ //最大导出10万条数据
                                exportExcel(data,sheet,fileName);
                                data = []; //清空数据
                            }
                            if(state.downloading){ //下载中
                                if(!state.pauseing){
                                    options['page']++;
                                    downloadChunk(options,url,callback,fail);
                                }
                            }else { //取消下载
                                data = []; //清空数据
                            }
                        }
                    }else {
                        commit({
                            type: 'set',
                            key:'pauseing',
                            pauseing: true
                        });
                        message.title = i18n.t('Download error, download suspended');//'下载出错,已暂停下载!';
                        dispatch('pushMessage', message, { root: true }); //消息提醒
                    }
                };
                fail = (error)=>{
                    commit({
                        type: 'set',
                        key:'pauseing',
                        pauseing: true
                    });
                    message.title = i18n.t('Download error, download suspended');//'下载出错,已暂停下载!';
                    dispatch('pushMessage', message, { root: true }); //消息提醒
                    if(options['page']>0){
                        options['page']--;
                    }
                }
            }
            downloadChunk(options,url,callback,fail);
        },
        //导入excel
        importExcel({ state, commit, rootState,dispatch },parms){
            let message = {
                'showClose':true,
                'title':'',
                'message':'',
                'type':'danger',
                'position':'top',
                'iconClass':'fa-warning',
                'customClass':'',
                'duration':3000,
                'show':true
            };
            if(typeof XLSX=="undefined"){
                message.title = i18n.t('The XLSX plug-in has not been loaded yet, please try again later')//;'XLSX还未加载成功,请稍后再试!';
            }
            if(state.downloading){
                message.title = i18n.t('The import or export task already exists');//'导入或导出任务已存在!';
            }
            if(!parms.url){
                message.title = i18n.t('Export link address does not exist');//'导出地址不存在!';
            }
            if(typeof XLSX=="undefined" || state.downloading || !parms.url){
                dispatch('pushMessage', message, { root: true }); //消息提醒
                return ;
            }
            let url = rootState['use_url']+parms.url;
            errors = []; //错误数据项
            //if(!reader){
            let reader;
            if(true){
                reader = new FileReader();
                reader.onload = function(e) {
                    let workbook = XLSX.read(e.target.result, {type: 'binary'});
                    if(parms.sheet!=workbook.SheetNames[0]){
                        message.title = i18n.t('Import template error, please use the correct import template');//'导入模板错误,请使用正确的导入模板!';
                        dispatch('pushMessage', message, { root: true }); //消息提醒
                        return;
                    }
                    //导入开始
                    commit({
                        type: 'set',
                        key:'downloading',
                        downloading: true
                    });
                    commit({
                        type: 'set',
                        key:'download_progress',
                        download_progress: 0
                    });
                    commit({
                        type: 'set',
                        key:'pauseing',
                        pauseing: false
                    });
                    commit({
                        type: 'set',
                        key:'model',
                        model: 1
                    });
                    let datas = collect(XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]]));
                    let title = collect(datas.shift()); //去掉表头
                    let error_title = collect(JSON.parse(JSON.stringify(title.all())));
                    error_title.put('error',i18n.t('Error message')); //错误信息
                    datas = datas.map( (item) =>{
                        collect(title).each((name,key)=>{
                            if(typeof item[key]=="undefined"){
                                item[key] = '';
                            }else if(typeof(item[key])=='string' && ((item[key].startsWith('{') && item[key].endsWith('}')) || (item[key].startsWith('[') && item[key].endsWith(']')))){
                                try {
                                    let value = JSON.parse(item[key]);
                                    item[key] = value;
                                }catch (e) {
                                }
                            }
                        });
                        return item;
                    });
                    let total = datas.count();
                    datas = datas.chunk(parms.import_per_page || 200);
                    let count = datas.count() || 1; //总请求数
                    data = datas.shift(); //第一组数据
                    if(!importCallback){
                        importFail = (error)=>{
                            commit({
                                type: 'set',
                                key:'pauseing',
                                pauseing: true
                            });
                            message.title = i18n.t('Import error, import has been suspended');//'导入出错,已暂停导入!';
                            dispatch('pushMessage', message, { root: true }); //消息提醒
                            datas.prepend(data);//将导入提交数据还原
                        };
                        importCallback = (response)=>{
                            if(response.status==200){
                                //进度
                                commit({
                                    type: 'set',
                                    key:'download_progress',
                                    download_progress: Math.floor((count-datas.count())/count*100)
                                });
                                if(typeof response.data.errors!="undefined" && response.data.errors.length){
                                    errors = collect(errors).merge(collect(response.data.errors).map(function (row) {
                                        //重新整理排序
                                        let item = [];
                                        error_title.each((val,key)=>{
                                            item[item.length] = row[key];
                                        });
                                        return item;
                                    }).all()).all(); //存放错误数据
                                }
                            }else {
                                importFail();
                                return;
                            }
                            if(!state.downloading || state.pauseing){ //取消上传
                                return ;
                            }
                            data = datas.shift(); //第一组数据
                            if(data && data.count()){
                                importChunk({datas:data.all()},url,importCallback,importFail);
                            }else {
                                if(errors.length) { //错误数据导出
                                    commit('set',{
                                        key:'modal',
                                        modal:{
                                            title:'提示',
                                            type : 'warning', //消息类型
                                            content: i18n.t('Import {success_number} data successfully, import {error_number} data failed! Did you download wrong data',
                                                {
                                                    success_number:total-errors.length,
                                                    error_number:errors.length
                                                }),//'成功导入'+(total-errors.length)+'条数据,导入失败'+errors.length+'数据!是否下载错误数据?',
                                            callback:()=>{
                                                let data = collect(errors)
                                                    .prepend(error_title.values().all())
                                                    .prepend(error_title.keys().all()).all();
                                                exportExcel(data,parms.sheet,i18n.t('Wrong data'));//错误数据
                                                errors = [];
                                                if(typeof parms.callback=="function"){
                                                    parms.callback();
                                                }
                                            },
                                            cancel:()=>{ //取消
                                                errors = [];
                                                if(typeof parms.callback=="function"){
                                                    parms.callback();
                                                }
                                            }
                                        }
                                    }, {root: true});

                                }else { //全部导入成功
                                    let message = {
                                        'showClose' : true, //显示关闭按钮
                                        'title' : i18n.t('All imported successfully'),//'全部导入成功!', //消息内容
                                        'message' : '', //消息内容
                                        'type' : 'success', //消息类型
                                        'position' : 'top',
                                        'iconClass' : 'fa-check', //图标
                                        'customClass' : '', //自定义样式
                                        'duration' : 3000, //显示时间毫秒
                                        'show' : true //是否自动弹出
                                    };
                                    dispatch('pushMessage', message, { root: true }); //消息提醒
                                    if(typeof parms.callback=="function"){
                                        parms.callback();
                                    }
                                }
                                setTimeout(()=>{
                                    commit({
                                        type: 'set',
                                        key:'download_progress',
                                        download_progress: 0
                                    });
                                    commit({
                                        type: 'set',
                                        key:'downloading',
                                        downloading: false
                                    });
                                    commit({
                                        type: 'set',
                                        key:'pauseing',
                                        pauseing: false
                                    });
                                },1000);
                            }
                        };

                    }
                    importChunk({datas:data.all()},url,importCallback,importFail);
                };
            }

            reader.readAsBinaryString(parms.file);
        }
    },
    getters:{}
};
