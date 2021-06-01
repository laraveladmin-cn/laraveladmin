<template>
    <div class="file-preview">
        <span class="mailbox-attachment-icon">
            <i class="fa" :class="type_class"></i>
                 <a v-if="file.url"
                    :href="file.url"
                    :title="$t('Download')"
                    :disabled="downloadDisabled"
                    target="_blank"
                    class="btn btn-default btn-xs pull-right file-down">
                    <i class="fa fa-cloud-download"></i>
                </a>
        </span>
        <div class="mailbox-attachment-info">
            <div class="mailbox-attachment-name">
                <a href="javascript:void(0)" :title="file.file">
                    {{file.file}}
                </a>
            </div>
            <div class="mailbox-attachment-size">
                    {{file.size_format}}
                    <span class="pull-right">
                      {{file.updated_at}}
                    </span>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            file:{
                default:function () {
                    return {
                        file:'',
                        size:0,
                        update_at:0
                    };
                }
            },
            downloadDisabled:{
                default:function () {
                    return true;
                }
            }
        },
        computed:{
            //文件类型
            type(){
                let fileExtension = this.file.file.split('.').pop().toLowerCase();
                let types = {
                    image:['jpg','jpeg','png','gif','bmp','tif','tiff','tga','psd'], //图片类型
                    sound:['mp3','mid','ogg','mp4a','wav','wma'], //音频类型
                    movie:['avi','dv','mp4','mpeg','mpg','mov','wm','flv','mkv'],//视频类型
                    excel:['xls','xlsx'],//excel
                    pdf:['pdf'],
                    text:['log'],
                    zip:['zip'],
                    word:['doc']
                };
                let type = 'file';
                collect(types).each((items,key)=>{
                    if(items.indexOf(fileExtension)!=-1){
                        type = key;
                        return false;
                    };
                });
                return type;
            },
            type_class(){
                if(this.type=='file'){
                    return 'fa-file';
                }
                return 'fa-file-'+this.type+'-o';
            }
        }
    };
</script>
<style scoped>
.mailbox-attachment-name{
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}
    .file-down{
        position: relative;
        top:85px;
    }
    .file-preview{
        border: 1px solid #eee;
    }
    .mailbox-attachment-info{
        min-height: 74px;
    }
</style>
