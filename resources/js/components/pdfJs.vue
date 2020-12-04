<template>
    <div ref="pdfJs" class="pdf-js">
    </div>
</template>
<script>
    import PDFJS from 'pdfjs-dist';
    PDFJS.GlobalWorkerOptions.workerSrc = '/bower_components/pdfjs/build/pdf.worker.js';
    import { TextLayerBuilder } from 'pdfjs-dist/web/pdf_viewer';
    import 'pdfjs-dist/web/pdf_viewer.css';
    export default {
        name: "pdfJs",
        props:{
            //绑定值
            value: {
                type:[String],
                default: function () {
                    return '';
                }
            }
        },
        data(){
          return {
              val:this.value,
              intervalTime:null
          };
        },
        methods:{
            renderPDF(num,pdf){
                pdf.getPage(num).then((page) => {
                    let scale = 1.5;
                    let viewport = page.getViewport(scale);
                    let pageDiv = document.createElement('div');
                    pageDiv.setAttribute('id', 'page-' + (page.pageIndex + 1));
                    pageDiv.setAttribute('style', 'position: relative');
                    this.$refs.pdfJs.appendChild(pageDiv);
                    let canvas = document.createElement('canvas');
                    pageDiv.appendChild(canvas);
                    let context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    let renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };

                    page.render(renderContext).then(() => {
                        return page.getTextContent();
                    }).then((textContent) => {
                        // 创建文本图层div
                        let textLayerDiv = document.createElement('div');
                        textLayerDiv.setAttribute('class', 'textLayer');
                        // 将文本图层div添加至每页pdf的div中
                        pageDiv.appendChild(textLayerDiv);

                        // 创建新的TextLayerBuilder实例
                        let textLayer = new TextLayerBuilder({
                            textLayerDiv: textLayerDiv,
                            pageIndex: page.pageIndex,
                            viewport: viewport
                        });

                        textLayer.setTextContent(textContent);

                        textLayer.render();
                    });
                });
            },

            init(){
                if(this.val){
                    PDFJS.getDocument(this.val).then((pdf) => {
                        for (let i = 1; i<= pdf.numPages; i++) {
                            this.renderPDF(i,pdf);
                        }
                    });
                }
            }
        },
        watch:{
            value(val){
              this.val = val;
            },
            val(){
                this.init();
            }
        },
        created() {
            this.init();
        },
        mounted() {
            let $this = this;
        },
    }
</script>

<style scoped>
    .pdf-js{
        overflow: scroll;
    }

</style>
