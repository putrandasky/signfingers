<template>
  <b-card-header header-border-variant="dark" header-bg-variant="dark" class=" py-0 ">
    <div class="text-white w-100 text-center">
      <small>
        {{fileName}}
      </small>
    </div>
    <div class="d-flex justify-content-end align-items-center">
      <!-- <b-btn size="sm" variant="outline-light" class="mr-2" @click="handleGoClick">
        <b>Go</b>
      </b-btn> -->
      <b-btn variant="secondary" size="sm" @click="handleUndoFileLoaded">
        <!-- <i class="fa fa-1x text-white fa-undo"></i> -->
        <b>
          Back
        </b>
      </b-btn>
      <b-input class="mx-2" size="sm" type="number" :min="1" :max="pageCount" style="max-width:40px" v-model.number="currentPage" @input="handleGoClick"></b-input>
      <span class="text-white ">
        / {{pageCount}}
      </span>

      <b-btn class="pr-1" variant="outline-dark" @click="handlePrevClick">
        <i class="fa fa-2x text-white fa-arrow-circle-o-left"></i>
      </b-btn>
      <b-btn class="pl-1 pr-0" variant="outline-dark" @click="handleNextClick">
        <i class="fa fa-2x text-white fa-arrow-circle-o-right"></i>
      </b-btn>
      <b-btn size="sm" class="ml-2 text-left" variant="warning" @click="handleSelectClick">
        <b>Next</b>

      </b-btn>
    </div>

  </b-card-header>
  <!-- <div class="bg-dark w-100 position-absolute text-right" style="top:0px">
            <div>
              <b-btn size="sm" variant="outline-light">
                <b>Go</b>
              </b-btn>
              <span class="d-inline-block">
                <b-input size="sm" type="number" style="max-width:70px"></b-input>
              </span>
              <span class="text-white">
                /100
              </span>
              <b-btn variant="outline-dark">
                <i class="fa fa-2x text-white fa-arrow-circle-o-up"></i>
              </b-btn>
              <b-btn variant="outline-dark">
                <i class="fa fa-2x text-white fa-arrow-circle-o-down"></i>
              </b-btn>
            </div>
          </div> -->
</template>
<script>
  import {
    EventBus
  } from "@/signerapp/event.js";
  import {
    mapState,
    mapActions
  } from 'vuex'
  export default {
    name: 'PreviewHeaderControlPage',
    // props: ["data"],

    data: function() {
      return {
        oldCurrentPage: 0,
      }
    },
    created() {},
    mounted() {
      // EventBus.$on('FileUploaded', data => {
      //   this.fileName = data.name
      // })
    },
    computed: {
      currentPage: {
        get() {
          return this.$store.state.dataPdf.currentPage
        },
        set(value) {

          this.setPdfCurrentPage(value)
        }
      },
      ...mapState({
        fileName: state => state.dataPdf.fileName,
        pageCount: state => state.dataPdf.pageCount,
      })
    },
    methods: {
      ...mapActions(['setDataPdf', 'setParentPage', 'setStep', 'setFileUploaded', 'setLoading', 'setPdfTotalPage', 'setPdfCurrentPage', 'setPdfLoadedRatio']),
      handleSelectClick() {
        // this.$emit('onSelectClick')
        this.setStep(3)

      },
      handleGoClick() {

        this.currentPage < 1 || this.currentPage > this.pageCount ? '' :
          this.setPdfCurrentPage(this.currentPage)
      },
      handlePrevClick() {
        this.currentPage <= 1 ? '' : this.setPdfCurrentPage(this.currentPage - 1)

      },
      handleNextClick() {
        this.currentPage >= this.pageCount ? '' : this.setPdfCurrentPage(this.currentPage + 1)
      },
      handleUndoFileLoaded() {
        this.setFileUploaded(false)
        let dataPdf = {
          fileName: '',
          src: null,
          raw: null,
        }
        this.setDataPdf(dataPdf)
        this.setPdfTotalPage(null)
        this.setPdfCurrentPage(1)
        this.setPdfLoadedRatio(null)
        this.setStep(1)
        // EventBus.$emit('undoFileLoaded')
      },
    },
  }
</script>
<style>
</style>
