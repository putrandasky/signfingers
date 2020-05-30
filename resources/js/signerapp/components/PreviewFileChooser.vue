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

  export default {
    name: 'PreviewFileChooser',
    data: function() {
      return {}
    },
    created() {

    },
    methods: {
      handleClick() {
        this.$refs.fileInput.click()
      },
      handleFileUpload(e) {
        // this.$emit('onChange', this.$refs.fileInput.files[0])
        EventBus.$emit('FileUploaded', this.$refs.fileInput.files[0])
      }
    },
  }
</script>
<style>
</style>
