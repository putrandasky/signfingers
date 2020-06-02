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
    computed: mapState({
      parentPage: state => state.parentPage,
    }),
    methods: {
      ...mapActions(['setDataPdf', 'setParentPage', 'setStep', 'setFileUploaded', 'setLoading', 'setPdfTotalPage', 'setPdfCurrentPage', 'setPdfLoadedRatio', 'setDragger', 'refreshDraggerInstance', 'setShowSignatureModal']),
      bpValue(lgUpValue, lgDownValue) {
        return ['lg', 'xl'].includes(this.$mq) ? lgUpValue : lgDownValue
      },
      handleCancelClick() {
        this.setStep(2)
      },
      handleResetClick() {
        let minWidth = this.parentPage.width * 0.2
        let minHeight = this.parentPage.width * 0.2 * 0.5
        let dragger = {
          width: minWidth,
          height: minHeight,
          top: 0,
          left: 0,
          elementTop: minHeight / 2,
          elementLeft: minWidth / 2
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
