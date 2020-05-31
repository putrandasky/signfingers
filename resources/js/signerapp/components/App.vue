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
          <b-card-body body-bg-variant="c-grey" class="d-flex align-items-center justify-content-center p-0" :style="{marginBottom:cardBody.marginBottom}">

            <b-overlay :show="isLoading" opacity="0.6" no-wrap>
            </b-overlay>
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
    <toaster-collection></toaster-collection>
    <modal-collection></modal-collection>

    <mq-layout :mq="['xs','sm', 'md']" class=" position-fixed w-100" style="bottom:0;left:0;z-index:1000" id="previewControl" ref="previewControl">
      <header-control-page v-if="isFileUploaded && step == 2" ref="headerControlPage" />
      <header-control-target v-if="isFileUploaded && step == 3" ref="headerControlTarget" />
      <header-control-download v-if="isFileUploaded && step == 4" ref="headerControlDownload" />
    </mq-layout>
  </b-container>
</template>
<script>
  import {
    mapState,
    mapActions
  } from 'vuex'
  import {
    EventBus
  } from "@/signerapp/event.js";
  import pdf from "vue-pdf";
  import Stepper from "./Stepper"
  import HeaderControlPage from "./PreviewHeaderControlPage"
  import HeaderControlTarget from "./PreviewHeaderControlTarget"
  import FileChooser from "./PreviewFileChooser"
  import HeaderControlDownload from "./PreviewHeaderControlDownload"
  import Dragger from "./PreviewDragger"
  import ModalSignaturePad from "./ModalSignaturePad"
  import debounce from './package/debounce'
  import ToasterCollection from './ToasterCollection'
  import ModalCollection from './ModalCollection'
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
      FileChooser,
      ToasterCollection,
      ModalCollection
    },
    data: function() {
      return {
        cardBody: {
          marginBottom: 0
        }
      }
    },
    created() {},
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
      'step': function(newVal, oldVal) {
        if (newVal == 1) {
          this.cardBody.marginBottom = 0

        }
      },
    },
    computed: mapState({
      dataPdf: state => state.dataPdf,
      isFileUploaded: state => state.isFileUploaded,
      step: state => state.step,
      isLoading: state => state.isLoading
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
          this.cardBody.marginBottom = this.bpClass('30px', document.getElementById('previewControl').offsetHeight.toString() + "px")
        }
      }, 100),
      bpClass(lgUpClass, lgDownClass) {
        return ['lg', 'xl'].includes(this.$mq) ? lgUpClass : lgDownClass
      },
    },
  }
</script>
<style lang="scss">
  @import '../custom.scss';
</style>
