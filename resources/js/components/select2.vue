<template>
    <span class="main-select2" :class="{'placeholder-show':placeholder_show}">
        <select class="form-control" :disabled="disabled" :multiple="multiple" style="width: 100%;">
            <option v-if="has_placeholder" :value="placeholderValue?placeholderValue:placeholderValue+' '" :selected="placeholderValue===value?'selected':null">{{_placeholder}}</option>
            <option v-for="option in options" :value="option['id']?option['id']:option['id']+' '" :selected="selected(option['id'])">
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
    import { mapState } from 'vuex';
    export default {
        data(){
            return {
                intervalTime:null,
                data:this.copyObj(this.value),
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
                type:[String,Function],
                default: function () {
                    return 'Please select';
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
            ...mapState([
                'language'
            ]),
            options(){
                let options = this.defaultOptions;
                if(!options){
                    return [];
                }
                options = this.copyObj(options);
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
                return this.value===this.placeholderValue || this.value===(this.placeholderValue+'');
            },
            _placeholder(){
                if(typeof this.placeholderShow=="function"){
                    return this.placeholderShow();
                }
                return this.$t(this.placeholderShow);
            },
            has_placeholder(){
                if(this.placeholder){
                    return true;
                }
                let flog = false;
                collect(this.options).each((option)=>{
                    if(this.selected(option['id'])){
                        flog = true;
                    }
                });
                return !flog;

            }
        },
        methods:{
            copyObj:function(obj){
                return JSON.parse(JSON.stringify(obj));
            },
            autofocus(){
                //if(!this.placeholder){
                //    $('.select2-container--open').addClass('main-select2-no-placeholder');
                //}
                setTimeout(()=>{
                    let $search = $('.select2-search__field');
                    if($search[0]){
                        $search.css({width:'100%'});
                        $search.attr('placeholder',this.$t('Please enter keywords'));
                        $search.attr('autofocus','autofocus');
                        $search[0].focus();
                    }
                },50);
            },
            initSelect2(){
                let $this = this;
                if(typeof $.fn.select2!="function"){
                    return;
                }
                let $select2 = $(this.$el).find('select');
                if(this.isAjax){
                    $select2.select2({
                        placeholder:this._placeholder,
                        maximumSelectionLength: 10,
                        minimumResultsForSearch:9,
                        language: this.language,
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
                                        'text':$this._placeholder
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
                    $select2.select2({
                        placeholder:this._placeholder,
                        language: this.language,
                        maximumSelectionLength: 10,
                        minimumResultsForSearch:9,
                        templateResult:$this.templateResult ? $this.templateResult : function(state){
                            return state.text;
                        }
                    });
                }
                //打开自动获取焦点
                $select2.on("select2:open",this.autofocus);
                //修改值提交修改
                $select2.on('change',function(){
                    let value = $.trim($(this).val());
                    $this.$emit('input', value); //修改值
                    $this.$emit('change',value); //修改值
                    $this.data = value;
                }).on('select2:close',()=>{
                    $this.$emit('blur');
                });
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
                    let res;
                    if(this.placeholderValue===value){
                        res = value==this.value ? 'selected':null;
                    }else {
                        res = value==this.value && (this.value!==this.placeholderValue) ? 'selected':null;
                    }
                    return res;
                }
            },
            destroy(){
                if($(this.$el).find('select').select2){
                    try {
                        $(this.$el).find('select').select2('destroy');
                    }catch (e) {

                    }
                }
            }
        },
        watch: {
            value(val,old){
                if(this.data!==val){
                    let $select2 = $(this.$el).find('select');
                    if(!val){
                        val = val+' ';
                    }
                    $select2.val(val);
                    this.destroy();
                    this.initSelect2();
                }
            },
            language(val,old){
                let language = val;
                let id = 'select2-js-lan-'+language;
                if(!document.getElementById(id)){
                    let $script = document.createElement('script');
                    $script.id = id;
                    $script.type = 'text/javascript';
                    $script.async = false;
                    $script.src = '/bower_components/select2/dist/js/i18n/'+language+'.js';
                    document.body.appendChild($script);
                }
                setTimeout(()=>{
                    this.destroy();
                    this.initSelect2();
                },50);
            }
        },
        mounted() {
            let $this = this;
            this.intervalTime = setInterval(()=>{
                if(typeof $.fn.select2=="function"){
                    clearInterval(this.intervalTime);
                    this.initSelect2();
                }
            },100);
        },
        updated(){

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
                let language = this.language;
                $script.id = 'select2-js-lan-'+language;
                $script.type = 'text/javascript';
                $script.async = false;
                $script.src = '/bower_components/select2/dist/js/i18n/'+language+'.js';
                document.body.appendChild($script);
            }
        },
        beforeDestroy() {
            this.destroy();
        }
    }
</script>
<style lang="scss">
    @import url('/bower_components/select2/dist/css/select2.min.css');
    //@import "~select2/dist/css/select2.min.css";
    @import "sass/_variables.scss";
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: $brand-primary;
    }
    .select2-container .select2-selection--single{
        height: 34px;
        border-radius:$--input-border-radius;
        border: 1px solid $gray-lte;
    }
    .select2-container .select2-selection--single .select2-selection__rendered{
        padding-left: 0px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        margin-top: 3px;
    }
    .main-select2 .select2-container--default .select2-selection--single .placeholder{
        color: $secondary;
    }
    .main-select2 .select2-dropdown{
        border-radius:0px;
    }
    .placeholder-show .select2-container--default .select2-selection--single .select2-selection__rendered{
        color: $secondary;
    }
    .has-error .select2-container .select2-selection--single{
        border-color: $red;
    }
    body .select2-dropdown {
        border: 1px solid $gray-lte;
        border-radius: 0;
    }
    @each $i in $themes {
        $item:map-get($btns, $i);
        .#{$i} {
            .select2-container--default .select2-results__option--highlighted[aria-selected]{
                background-color: map-get($item,'hover');
            }
            .select2-container--default.select2-container--focus .select2-selection--multiple,
            .select2-container--default .select2-search--dropdown .select2-search__field{
                border-color:map-get($item,'border') !important;
            }
            .select2-container.select2-container--disabled{
                .select2-selection--single{
                    border-color: $gray-lte !important;
                    cursor: not-allowed;
                }
            }
            .select2-container {
                .select2-selection--single{
                    height: 36px;
                    padding-top: 7px;
                    &:hover, &:active, &.hover,&:focus {
                        border-color:map-get($item,'border');
                    }
                }
            }
        }
    }
    .main-select2-no-placeholder .select2-results .select2-results__options .select2-results__option:first-child{
        display: none !important;
    }
</style>
