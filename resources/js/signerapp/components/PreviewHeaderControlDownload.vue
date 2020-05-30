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
  export default {
    name: 'PreviewHeaderControlDownload',
    data: function() {
      return {}
    },
    created() {},
    methods: {
      handleCancelClick() {
        EventBus.$emit('onCancelDownloadClick')
      },

      handleDownloadClick() {
        EventBus.$emit('onDownloadClick')
      },
    },
  }
</script>
<style>
</style>
