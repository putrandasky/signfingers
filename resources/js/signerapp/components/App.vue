<template>
  <b-container fluid class="h-100 py-3">
    <b-row class="h-100 align-items-start " :class="isFileUploaded?'':'flex-column flex-lg-row' ">
      <b-col lg="6" class="d-flex  justify-content-center pt-lg-5 pt-0 ">
        <stepper />
      </b-col>
      <b-col lg="6" :class="isFileUploaded?bpClass('','h-100'):bpClass('h-100','flex-grow-1 flex-lg-grow-0') ">
        <b-card bg-variant="c-dark" :class="isFileUploaded?'':'h-100' " no-body>
          <mq-layout :mq="['lg', 'xl']">

            <header-control-page mq="lg" v-if="isFileUploaded && step == 2" ref="headerControlPage" />
            <header-control-target v-if="isFileUploaded && step == 3" ref="headerControlTarget" />
            <header-control-download v-if="isFileUploaded && step == 4" ref="headerControlDownload" />
          </mq-layout>
          <b-card-body body-bg-variant="c-grey" class="d-flex align-items-center justify-content-center p-0">
            <div v-if="isFileUploaded" class="position-relative w-100" ref="parent">
              <dragger style="z-index:900" v-if="isFileUploaded && [3,4].includes(step)" />
              <pdf style="border: 1px solid black;height:100%;width:100%;overflow:hidden" :src="dataPdf.src" :page="dataPdf.currentPage" @num-pages="setPdfTotalPage" @page-loaded="setPdfCurrentPage" @progress="setPdfLoadedRatio"></pdf>

            </div>
            <file-chooser v-if="!isFileUploaded" />
          </b-card-body>
        </b-card>
      </b-col>
      <modal-signature-pad v-if="isFileUploaded && [3,4].includes(step)" />
    </b-row>

    <mq-layout :mq="['xs','sm', 'md']" class=" position-fixed w-100" style="bottom:0;left:0;z-index:1000">
      <header-control-page v-if="isFileUploaded && step == 2" ref="headerControlPage" />
      <header-control-target v-if="isFileUploaded && step == 3" ref="headerControlTarget" />
      <header-control-download v-if="isFileUploaded && step == 4" ref="headerControlDownload" />
    </mq-layout>
  </b-container>
</template>
<script>
  import pdf from "vue-pdf";
  import Stepper from "./Stepper"
  import HeaderControlPage from "./PreviewHeaderControlPage"
  import HeaderControlTarget from "./PreviewHeaderControlTarget"
  import FileChooser from "./PreviewFileChooser"
  import HeaderControlDownload from "./PreviewHeaderControlDownload"
  import Dragger from "./PreviewDragger"
  import ModalSignaturePad from "./ModalSignaturePad"
  import debounce from './package/debounce'
  import {
    mapState,
    mapActions
  } from 'vuex'
  import {
    EventBus
  } from "@/signerapp/event.js";
  export default {
    name: 'app',
    components: {
      pdf,
      Stepper,
      HeaderControlPage,
      HeaderControlTarget,
      HeaderControlDownload,
      Dragger,
      ModalSignaturePad,
      FileChooser
    },
    data: function() {
      return {




      }
    },

    created() {
      // console.log(this.$mq);


      // EventBus.$on('onDownloadClick', data => {
      //   let self = this;
      //   let input = {
      //     elementTop: this.dragger.elementTop,
      //     elementLeft: this.dragger.elementLeft,
      //     parentWidth: this.parentPage.width,
      //     parentHeight: this.parentPage.height,
      //     width: this.dragger.width,
      //     height: this.dragger.height,
      //     page: this.dataPdf.currentPage
      //   };
      //   let itemInput = JSON.stringify(input);
      //   var form = new FormData();
      //   form.append("itemInput", itemInput);
      //   form.append("itemSignData", this.srcSignature);
      //   form.append("itemFile", this.dataPdf.raw);
      //   axios
      //     .post("/generate", form, {
      //       responseType: "blob",
      //       headers: {
      //         "Content-Type": "multipart/form-data"
      //         // 'Content-Type': 'multipart/form-data; charset=utf-8; boundary="'+ Math.random().toString().substr(2)+'"'
      //       }
      //     })
      //     .then(response => {
      //       let ContentDisposition = response.headers["content-disposition"];
      //       let splitedContentDisposition = ContentDisposition.split('"');
      //       FileSaver.saveAs(response.data, splitedContentDisposition[1]);
      //       console.log(response.data);
      //     })
      //     .catch(error => {
      //       console.log(error);
      //     });
      // })


      // EventBus.$on('onCancelDownloadClick', data => {
      //   this.step = 3
      // })
      // EventBus.$on('onSaveSigature', data => {
      //   this.srcSignature = data;
      //   this.step = 4
      // })
      // EventBus.$on('FileUploaded', data => {
      // this.showFile(data);
      // })
      // EventBus.$on('undoFileLoaded', data => {
      //   this.isFileUploaded = false,
      //     this.dataPdf.fileName = '',
      //     this.dataPdf.src = null,
      //     this.dataPdf.pageCount = null,
      //     this.dataPdf.currentPage = 1,
      //     this.dataPdf.loadedRatio = null
      //   this.step = 1

      // })

    },
    mounted() {
      this.$nextTick(function() {
        window.addEventListener('resize', this.updateParentPage);
      })
    },
    watch: {
      '$mq': function(newVal, oldVal) {
        console.log("mq newVal", newVal)

      },
      'isFileUploaded': function(newVal, oldVal) {
        this.updateParentPage()

      },
    },
    computed: mapState({
      dataPdf: state => state.dataPdf,
      isFileUploaded: state => state.isFileUploaded,
      step: state => state.step
    }),
    methods: {
      ...mapActions(['setDataPdf', 'setParentPage', 'setStep', 'setFileUploaded', 'setLoading', 'setPdfTotalPage', 'setPdfCurrentPage', 'setPdfLoadedRatio']),
      updateParentPage: debounce(function() {
        if (this.isFileUploaded) {
          // this.parentPage.width = this.$refs.parent.offsetWidth;
          // this.parentPage.height = this.$refs.parent.offsetHeight;
          let parentPage = {
            width: this.$refs.parent.offsetWidth,
            height: this.$refs.parent.offsetHeight
          }
          this.setParentPage(parentPage)
          console.log('from app debounce');

        }


      }, 100),
      bpClass(lgUpClass, lgDownClass) {
        return ['lg', 'xl'].includes(this.$mq) ? lgUpClass : lgDownClass
      },
      handleResizeStopDragger(data) {
        // console.log(this.parentPage.width);
        //to be deleted
        // this.parentPage.width = this.$refs.parent.offsetWidth;
        // this.parentPage.height = this.$refs.parent.offsetHeight;

        // this.dragger = data
        // console.log(this.dragger);

        // console.log(this.$refs.parent.offsetWidth);

      },
      handleOnChangeFileChooser(e) {
        console.log(e);
      },
      // handleSelectPage() {
      //   this.step = 3
      //   this.setStep(3)
      // },


      // handleCancelTarget() {
      //   this.step = 2
      //   this.setStep(2)
      // },
      loadedFileProgress(e) {
        console.log({
          'loadedFile': e
        });

      },
      showFile(e) {
        // this.dataPdf.raw = e
        // this.dataPdf.fileName = e.name
        // let objectUrl = URL.createObjectURL(e);
        // var loadingTask = pdf.createLoadingTask(objectUrl);
        // this.dataPdf.src = loadingTask;
        // let dataPdf = {
        //   raw: e,
        //   fileName: e.name,
        //   src: loadingTask
        // }
        // this.setDataPdf(dataPdf)
        // loadingTask.onProgress = ({
        //   loaded,
        //   total
        // }) => {
        //   console.log({
        //     'loaded': loaded,
        //     'total': total
        //   });
        //   if (loaded == total) {
        //     this.setAfterUpload()
        //   }
        // };


      },
      setAfterUpload: debounce(function() {
        this.isFileUploaded = true
        this.setFileUploaded(true)
        this.step = 2
        this.setStep(2)
      }, 100)
    },
  }
</script>
<style lang="scss">
  @import '../custom.scss';
</style>
