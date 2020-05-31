<template>
  <div class="text-center">
    <div>
      File must be in PDF Format
    </div>
    <b-btn variant="warning shadow my-3" class="" @click="handleClick()">
      <b>
        Choose File Here
      </b>
    </b-btn>
    <input class="d-none" type="file" ref="fileInput" name="fileInput" id="fileInput" v-on:change="handleFileUpload()" />
    <div>
      Your document will be previewed here
    </div>
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
      return {}
    },
    created() {

    },
    methods: {
      ...mapActions(['setDataPdf', 'setParentPage', 'setStep', 'setFileUploaded', 'setLoading', 'setPdfTotalPage', 'setPdfCurrentPage', 'setPdfLoadedRatio']),
      handleClick() {
        this.$refs.fileInput.click()
      },
      handleFileUpload() {
        // this.$emit('onChange', this.$refs.fileInput.files[0])
        // EventBus.$emit('FileUploaded', this.$refs.fileInput.files[0])
        let file = this.$refs.fileInput.files[0]
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
      }, 100)
    },
  }
</script>
<style>
</style>
