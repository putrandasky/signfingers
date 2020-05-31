<template>
  <b-card-header header-border-variant="dark" header-bg-variant="dark" class=" p-0 d-flex justify-content-center align-items-center">
    <b-btn-group class="w-100 ">
      <b-btn variant="c-white rounded-0 rounded-top" @click="handleCancelClick">
        <i class="fa fa-close"></i>
        <b>
          Cancel
        </b>
      </b-btn>
      <b-btn variant="c-white" @click="handleResetClick">
        <i class="fa fa-refresh"></i>
        <b>
          Reset
        </b>
      </b-btn>
      <b-btn variant="warning rounded-0" @click="handleApplyClick">
        <i class="fa fa-check"></i>
        <b>
          Apply
        </b>
      </b-btn>
    </b-btn-group>
  </b-card-header>
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
    name: 'PreviewHeaderControlTarget',
    data: function() {
      return {}
    },
    created() {},
    methods: {
      ...mapActions(['setDataPdf', 'setParentPage', 'setStep', 'setFileUploaded', 'setLoading', 'setPdfTotalPage', 'setPdfCurrentPage', 'setPdfLoadedRatio', 'setDragger', 'refreshDraggerInstance', 'setShowSignatureModal']),
      bpValue(lgUpValue, lgDownValue) {
        return ['lg', 'xl'].includes(this.$mq) ? lgUpValue : lgDownValue
      },
      handleCancelClick() {
        // this.$emit('onCancelClick')
        this.setStep(2)
      },
      handleResetClick() {
        // EventBus.$emit('onResetClick')
        let dragger = {
          width: this.bpValue(80, 50),
          height: this.bpValue(40, 25),
          top: 0,
          left: 0,
          elementTop: this.bpValue(40, 25) / 2,
          elementLeft: this.bpValue(80, 50) / 2
        }
        this.setDragger(dragger)
        this.refreshDraggerInstance()

      },
      handleApplyClick() {
        this.setShowSignatureModal(true)
        // EventBus.$emit('onApplyTargetArea')
      },
    },
  }
</script>
<style>
</style>
