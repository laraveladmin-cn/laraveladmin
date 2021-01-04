<template>
    <span class="main-select2" :class="{'placeholder-show':placeholder_show}">
        <select class="form-control" :disabled="disabled" :multiple="multiple" style="width: 100%;">
            <option v-if="!multiple && placeholder" :value="placeholderValue" :selected="placeholderValue===value?'selected':null">{{placeholderShow}}</option>
            <option v-for="option in options" :value="option['id']" :selected="selected(option['id'])">
                {{option['text']}}
            </option>
        </select>
    </span>
</template>
<script>
    if (!Element.prototype.matches) {
        Element.prototype.matches =
            Element.prototype.matchesSelector ||
            Element.prototype.mozMatchesSelector ||
            Element.prototype.msMatchesSelector ||
            Element.prototype.oMatchesSelector ||
            Element.prototype.webkitMatchesSelector ||
            function(s) {
                var matches = (this.document || this.ownerDocument).querySelectorAll(s),
                    i = matches.length;
                while (--i >= 0 && matches.item(i) !== this) {}
                return i > -1;
            };
    }
    export default {
        data(){
            return {
                intervalTime:null
            };
        },
        props:{
            //绑定值
            value: {
                type:[String, Number,Array],
                default: function () {
                    return '';
                }
            },
            //默认选项
            defaultOptions:{
                type: [Object,Array],
                default: function () {
                    return [];
                }
            },
            //请求数据地址
            url:{
                type:[String],
                default: function () {
                    return '';
                }
            },
            //请求参数
            params:{
                type: [Object,Array],
                default: function () {
                    return {where:{},order:{}};
                }
            },
            //搜索关键字KEY
            keywordKey:{
                type:[String],
                default: function () {
                    return 'keyword';
                }
            },
            primaryKey:{
                type:[String],
                default: function () {
                    return 'id';
                }
            },
            isAjax:{
                type:[Boolean],
                default: function () {
                    return false;
                }
            },
            placeholder:{
                default: function () {
                    return true;
                }
            },
            placeholderValue:{
                type:[String,Number],
                default: function () {
                    return '';
                }
            },
            placeholderShow:{
                type:[String],
                default: function () {
                    return '请选择';
                }
            },
            disabled:{
                default: function () {
                    return false;
                }
            },
            multiple:{
                type:[String,Boolean],
                default: function () {
                    return null;
                }
            },
            show:{
                type:[Array],
                default: function () {
                    return ['name'];
                }
            },
            templateResult:{
                //type:[Function],
                default: function () {
                    return '';
                }
            }
        },
        computed: {
            options(){
                let options = this.defaultOptions;
                if(!options){
                    return [];
                }
                //获取第一个值
                if(typeof collect(options).first()!="object"){
                    options = collect(options).map((item,key)=>{
                        return {id:key,text:item};
                    }).values().all();
                };
                let text, i, j,row;
                for(i in options){
                    row = options[i];
                    text = '';
                    if(typeof row['text']=='undefined'){
                        for (j in this.show){
                            if(j==0){
                                text = array_get(row,this.show[j]);
                            }else {
                                text += array_get(row,this.show[j]) ? '（'+array_get(row,this.show[j])+'）':'';
                            }
                        }
                        options[i]['text'] = text;
                    }
                    if(typeof row['id']=='undefined'|| this.primaryKey!='id'){
                        options[i]['id'] = options[i][this.primaryKey];
                    }
                }
                return options;
            },
            placeholder_show(){
                return !this.multiple && this.placeholder && this.value===this.placeholderValue;
            }
        },
        methods:{
            copyObj:function(obj){
                return JSON.parse(JSON.stringify(obj));
            },
            initSelect2(){
                let $this = this;
                if(typeof $.fn.select2!="function"){
                    return;
                }
                if(this.isAjax){
                    $(this.$el).find('select').select2({
                        placeholder:$this.placeholderShow,
                        maximumSelectionLength: 10,
                        minimumResultsForSearch:9,
                        language: "zh-CN",
                        ajax: {
                            url: this.url,
                            dataType: 'json',
                            delay: 250,
                            beforeSend: function(request) {
                                let token = getCookie('Authorization');
                                if(token){
                                    request.setRequestHeader("Authorization",decodeURIComponent(token));
                                }
                            },
                            //搜索参数
                            data: function (params) {
                                let params_data = $this.copyObj($this.params);
                                if(!params_data.where){
                                    params_data.where = {};
                                }
                                params_data.where[$this.keywordKey] = params['term'] || '';
                                if((params['page'] || 1)!=1){
                                    params_data['page'] = params['page'] || 1;
                                }
                                return params_data;
                            },
                            //最后一页
                            processResults: function (data, params) {
                                params.page = params.page || 1;
                                let text, i, j,row;
                                for(i in data.data){
                                    row = data.data[i];
                                    text = '';
                                    if(typeof row['text']=='undefined'){
                                        for (j in $this.show){
                                            if(j==0){
                                                text = array_get(row,$this.show[j]);
                                            }else {
                                                text += array_get(row,$this.show[j]) ? '（'+array_get(row,$this.show[j])+'）':'';
                                            }
                                        }
                                        data.data[i]['text'] = text;
                                    }
                                    if(typeof row['id']=='undefined' || $this.primaryKey!='id'){
                                        data.data[i]['id'] = data.data[i][$this.primaryKey];
                                    }
                                }
                                let more ;
                                if(typeof data['total']!='undefined'){
                                    more = data.current_page < data.last_page;
                                }else {
                                    more = data.data.length!=0;
                                }
                                if(typeof data['current_page']=='undefined' || !data['current_page'] || data.current_page<=1){
                                    data.data.unshift({
                                        'id':$this.placeholderValue,
                                        'text':$this.placeholderShow
                                    });
                                }

                                return {
                                    results: data.data,
                                    pagination: {
                                        more: more
                                    }
                                };
                            },
                            cache: true
                        },
                        templateResult: $this.templateResult ? $this.templateResult : function(state){
                            return state.text;
                        }
                    });
                }else {
                    $(this.$el).find('select').select2({
                        language: "zh-CN",
                        maximumSelectionLength: 10,
                        minimumResultsForSearch:9,
                        templateResult:$this.templateResult ? $this.templateResult : function(state){
                            return state.text;
                        }
                    });
                }

            },
            selected(value){
                if(this.multiple){
                    let flog = false;
                    for (let i in this.value){
                        if(this.value[i]==value){
                            flog = true;
                            break;
                        }
                    }
                    return flog ? 'selected' : null;
                }else {
                    if(this.placeholderValue===value){
                        return value==this.value ? 'selected':null;
                    }else {
                        return value==this.value && (this.value!=='' && value!==0) ? 'selected':null;
                    }

                }
            },
            placeholderStyle(){
                setTimeout(()=>{
                    if(!this.multiple && this.placeholder){
                        if(this.value==this.placeholderValue){
                            $(this.$el).find('.select2-selection__rendered').addClass('placeholder');
                        }else {
                            $(this.$el).find('.select2-selection__rendered').removeClass('placeholder');
                        }
                    }
                },100);
            }
        },
        watch: {
            value(val,old){
                let $select = $(this.$el).find('select');
                let $show = $(this.$el).find('select2-selection__rendered');
                if(!val || (typeof val=="object" && !val.length)){
                    $select.val(this.placeholderValue);
                    setTimeout(()=>{
                        let $input = $(this.$el).find('.select2-selection--multiple .select2-search__field');
                        $input.attr('placeholder',this.placeholderShow);
                        $input.css({
                            "width":"100%"
                        });
                    },100);
                }
                let show = $select.find('option:selected').html();
                $show.attr('title',show);
                $show.attr('html',show);
                this.initSelect2();
                this.placeholderStyle();
            }
        },
        mounted() {
            let $this = this;
            this.intervalTime = setInterval(()=>{
                if(typeof $.fn.select2=="function"){
                    clearInterval(this.intervalTime);
                    this.initSelect2();
                    $(this.$el).find('select').on('change',function(){
                        let value = $(this).val();
                        $this.$emit('input', value); //修改值
                        $this.$emit('change',value); //修改值
                    }).on('select2:close',()=>{
                        $this.$emit('blur');
                    });
                    let $input = $(this.$el).find('.select2-selection--multiple .select2-search__field');
                    $input.attr('placeholder',this.placeholderShow);
                    $input.css({
                        "width":"100%"
                    });
                    $this.placeholderStyle();
                }
            },100);
        },
        updated(){
            this.initSelect2();
            this.placeholderStyle();
        },
        created() {
            //动态加载js文件
            if(!document.getElementById('select2-js')){
                let $script = document.createElement('script');
                $script.id = 'select2-js';
                $script.type = 'text/javascript';
                $script.src = '/bower_components/select2/select2.js';
                $script.async = false;
                document.body.appendChild($script);
                $script = document.createElement('script');
                $script.id = 'select2-js-lan';
                $script.type = 'text/javascript';
                $script.async = false;
                $script.src = 'https://cdn.bootcss.com/select2/4.0.10/js/i18n/zh-CN.js';
                document.body.appendChild($script);

            }
        }
    }
</script>
<style lang="scss">
    @import url('https://cdn.bootcss.com/select2/4.0.10/css/select2.min.css');
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #3c8dbc;
    }
    .select2-container .select2-selection--single{
        height: 34px;
        border-radius:0px;
        border: 1px solid #d2d6de;
    }
    .select2-container .select2-selection--single .select2-selection__rendered{
        padding-left: 0px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        margin-top: 3px;
    }
    .main-select2 .select2-container--default .select2-selection--single .placeholder{
        color: #a4aaae;
    }
    .main-select2 .select2-dropdown{
        border-radius:0px;
    }
    .placeholder-show .select2-container--default .select2-selection--single .select2-selection__rendered{
        color: #a4aaae;
    }
    .has-error .select2-container .select2-selection--single{
        border-color: #dd4b39;
    }
</style>
