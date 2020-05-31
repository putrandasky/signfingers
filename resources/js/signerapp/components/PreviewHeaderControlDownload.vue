<template>
  <b-card-header header-border-variant="dark" header-bg-variant="dark" class=" p-0 d-flex justify-content-center align-items-center">
    <b-btn-group class="w-100 ">
      <b-btn variant="c-white rounded-0 rounded-top" @click="handleCancelClick">
        <i class="fa fa-close"></i>
        <b>
          Cancel
        </b>
      </b-btn>
      <b-btn variant="warning rounded-0" @click="handleDownloadClick">
        <i class="fa fa-download"></i>
        <b>
          Download
        </b>
      </b-btn>
    </b-btn-group>
  </b-card-header>
</template>
<script>
  import {
    EventBus
  } from "@/signerapp/event.js";
  import FileSaver from "file-saver";
  import {
    mapState,
    mapActions
  } from 'vuex'
  export default {
    name: 'PreviewHeaderControlDownload',
    data: function() {
      return {}
    },
    created() {},
    computed: mapState({
      parentPage: state => state.parentPage,
      dragger: state => state.dragger,
      signature: state => state.signature,
      dataPdf: state => state.dataPdf,
    }),
    methods: {
      ...mapActions(['setShowSignatureModal', 'setStep']),
      handleCancelClick() {
        // EventBus.$emit('onCancelDownloadClick')
        this.setShowSignatureModal(true)
        this.setStep(3)
      },

      handleDownloadClick() {
        EventBus.$emit('onDownloadClick')
        let self = this;
        let input = {
          elementTop: this.dragger.elementTop,
          elementLeft: this.dragger.elementLeft,
          parentWidth: this.parentPage.width,
          parentHeight: this.parentPage.height,
          width: this.dragger.width,
          height: this.dragger.height,
          page: this.dataPdf.currentPage
        };
        let itemInput = JSON.stringify(input);
        var form = new FormData();
        form.append("itemInput", itemInput);
        form.append("itemSignData", this.signature.src);
        form.append("itemFile", this.dataPdf.raw);
        axios
          .post("/generate", form, {
            responseType: "blob",
            headers: {
              "Content-Type": "multipart/form-data"
            }
          })
          .then(response => {
            let ContentDisposition = response.headers["content-disposition"];
            let splitedContentDisposition = ContentDisposition.split('"');
            FileSaver.saveAs(response.data, splitedContentDisposition[1]);
            console.log(response.data);
          })
          .catch(error => {
            console.log(error);
          });
      },
    },
  }
</script>
<style>
</style>
