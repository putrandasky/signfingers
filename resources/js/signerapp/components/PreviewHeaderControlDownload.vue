<template>
  <preview-control>
    <div slot="content" class="py-2 ">
      <b-btn size="sm" variant="secondary " @click="handleCancelClick">
        <i class="fa fa-close"></i>
        <b>
          Cancel
        </b>
      </b-btn>
      <b-overlay :show="busy" rounded opacity="0.6" spinner-small spinner-variant="c-dark" class="d-inline-block">
        <b-btn size="sm" variant="warning " @click="handleDownloadClick">
          <i class="fa fa-download"></i>
          <b>
            Download
          </b>
        </b-btn>
      </b-overlay>
    </div>

  </preview-control>
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
  import PreviewControl from './slots/PreviewControl'

  export default {
    name: 'PreviewHeaderControlDownload',
    components: {
      PreviewControl
    },
    data: function() {
      return {
        busy: false,
        isShowEndModal: false

      }
    },
    created() {},
    computed: mapState({
      parentPage: state => state.parentPage,
      dragger: state => state.dragger,
      signature: state => state.signature,
      dataPdf: state => state.dataPdf,
      fileName: state => state.dataPdf.fileName,

    }),
    methods: {
      ...mapActions(['setShowSignatureModal', 'setStep', 'setShowModal', 'setFileSigned']),
      handleCancelClick() {
        // EventBus.$emit('onCancelDownloadClick')
        this.setShowSignatureModal(true)
        this.busy = false

        this.setStep(3)
      },

      handleDownloadClick() {
        // EventBus.$emit('onDownloadClick')
        this.busy = true
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
        form.append("timeZone", Intl.DateTimeFormat().resolvedOptions().timeZone);
        form.append("itemFile", this.dataPdf.raw);
        axios
          .post("/generate", form, {
            responseType: "blob",
            headers: {
              "Content-Type": "multipart/form-data"
            }
          })
          .then(response => {
            console.log({
              'response-header': response.headers,
              'response': response,

            });

            // let ContentDisposition = response.headers["content-disposition"];
            // let splitedContentDisposition = ContentDisposition.split('"');
            // FileSaver.saveAs(response.data, splitedContentDisposition[1]);
            // let d = new Date()
            // let dateTimeFormatted = `${d.getDate()}-${d.getMonth()+1}-${d.getFullYear()} ${d.getHours()}${d.getMinutes()}`
            FileSaver.saveAs(response.data, response.headers.filename);
            // FileSaver.saveAs(response.data, `${this.fileName.substr(0, this.fileName.lastIndexOf("."))} Signed ${dateTimeFormatted}.pdf`);
            this.busy = false
            this.setFileSigned(true)
            this.$bvModal.show('endModal')
            // this.$bvToast.show('download-toast')
            // this.isShowEndModal = true
            // this.setShowModal({
            //   name: 'endModal',
            //   value: true
            // })

          })
          .catch(error => {
            console.log(error);
            this.$bvToast.show('error-toast')
            this.busy = false

          });
      },
      stringToHTML(str) {
        // If DOMParser is supported, use it


        // Otherwise, fallback to old-school method
        var dom = document.createElement('div');
        dom.innerHTML = str;
        return dom;
      }
    },
  }
</script>
<style>
</style>
