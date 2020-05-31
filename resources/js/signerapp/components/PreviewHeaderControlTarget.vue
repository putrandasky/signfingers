<template>
  <preview-control>

    <div slot="content" class="py-2 ">
      <b-btn size="sm" variant="secondary" @click="handleCancelClick">
        <i class="fa fa-close"></i>
        <b>
          Cancel
        </b>
      </b-btn>
      <b-btn size="sm" variant="c-white" @click="handleResetClick">
        <i class="fa fa-refresh"></i>
        <b>
          Reset
        </b>
      </b-btn>
      <b-btn size="sm" variant="warning " @click="handleApplyClick">
        <i class="fa fa-check"></i>
        <b>
          Apply
        </b>
      </b-btn>
    </div>
  </preview-control>
</template>
<script>
  import {
    EventBus
  } from "@/signerapp/event.js";
  import {
    mapState,
    mapActions
  } from 'vuex'
  import PreviewControl from './slots/PreviewControl'
  export default {
    name: 'PreviewHeaderControlTarget',
    components: {
      PreviewControl
    },
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
        this.setStep(2)
      },
      handleResetClick() {
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
      },
    },
  }
</script>
<style>
</style>
