<template>
  <b-card-header header-border-variant="dark" header-bg-variant="dark" class=" py-0 ">
    <div class="text-white w-100 text-center">
      <small>
        {{data.fileName}}
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
      <b-input class="mx-2" size="sm" type="number" :min="1" :max="data.pageCount" style="max-width:40px" v-model.number="currentPage" @input="handleGoClick"></b-input>
      <span class="text-white ">
        / {{data.pageCount}}
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
  export default {
    name: 'PreviewHeaderControlPage',
    props: ["data"],

    data: function() {
      return {
        fileName: "",
        currentPage: this.data.currentPage,
        oldCurrentPage: 0,
      }
    },
    created() {},
    mounted() {
      // EventBus.$on('FileUploaded', data => {
      //   this.fileName = data.name
      // })
    },
    methods: {
      handleSelectClick() {
        this.$emit('onSelectClick')
      },
      handleGoClick() {

        this.currentPage < 1 || this.currentPage > this.data.pageCount ? '' :
          this.$emit('onGoClick', this.currentPage)
      },
      handlePrevClick() {
        this.currentPage <= 1 ? '' : this.currentPage--
        this.$emit('onPrevClick', this.currentPage)
      },
      handleNextClick() {
        this.currentPage >= this.data.pageCount ? '' : this.currentPage++
        this.$emit('onNextClick', this.currentPage)
      },
      handleUndoFileLoaded() {
        EventBus.$emit('undoFileLoaded')
      },
    },
  }
</script>
<style>
</style>
