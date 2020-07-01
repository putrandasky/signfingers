<template>
  <div class="text-center">
    <div>
      {{'fileChooser.info1' | trans}}
    </div>
    <b-btn variant="warning shadow my-3" class="" @click="handleClick()">
      <b>
        {{'fileChooser.button' | trans}}
      </b>
    </b-btn>
    <input class="d-none" type="file" ref="fileInput" name="fileInput" id="fileInput" v-on:change="handleFileUpload()" accept="application/pdf" />
    <div>
      {{'fileChooser.info2' | trans}}
    </div>
    <!-- <b-alert v-model="showAlert" class="position-fixed fixed-top m-0 rounded-0" style="z-index: 2000" variant="success" dismissible>
      <div style="display:table">

        <i class="fa fa-2x fa-check-circle-o text-success mr-2"></i>
        <span style="display:table-cell;vertical-align:middle">
          <b class="h3">
            SUCCESS
          </b>
        </span>
      </div>
    </b-alert> -->
  </div>
</template>
<script>
  import {
    EventBus
  } from "@/signerapp/event.js";
  import debounce from './package/debounce'
  import {
    mapState,
    mapActions
  } from 'vuex'
  import pdf from "vue-pdf";
  export default {
    name: 'PreviewFileChooser',
    components: {
      pdf,
    },
    data: function() {
      return {
        showAlert: true
      }
    },
    created() {},
    methods: {
      ...mapActions(['setDataPdf', 'setParentPage', 'setStep', 'setFileUploaded', 'setLoading', 'setPdfTotalPage', 'setPdfCurrentPage', 'setPdfLoadedRatio']),
      handleClick() {
        this.$refs.fileInput.click()
        // this.$bvToast.show('not-pdf-toast')
      },
      handleFileUpload() {
        this.setLoading(true)
        console.log(this.$refs.fileInput.files[0]);
        let file = this.$refs.fileInput.files[0]
        if (!/\.(pdf)$/i.test(file.name)) {
          // this.$bvToast.show('not-pdf-toast')
          EventBus.$emit('showToast', {
            title: this.$filters.trans('fileChooser.toast.notPdf.title'),
            body: this.$filters.trans('fileChooser.toast.notPdf.body'),
            variant: "danger",
            visible: true
          })
          this.setLoading(false)
          return
        }
        let objectUrl = URL.createObjectURL(file);
        var loadingTask = pdf.createLoadingTask(objectUrl);
        let dataPdf = {
          raw: file,
          fileName: file.name,
          src: loadingTask
        }
        this.setDataPdf(dataPdf)
        loadingTask.onProgress = ({
          loaded,
          total
        }) => {
          if (loaded == total) {
            this.setAfterUpload()
          }
        };
      },
      setAfterUpload: debounce(function() {
        this.setFileUploaded(true)
        this.setStep(2)
        this.setPdfCurrentPage(1)

        setTimeout(() => {
          //to prevent miss rotation of pdf after loading (pdf.js bug)

          this.setLoading(false)

        }, 500);
      }, 100)
    },
  }
</script>
<style>
</style>
