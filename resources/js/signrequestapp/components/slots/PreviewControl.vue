<template>
  <b-card-header header-border-variant="dark" header-bg-variant="dark" class=" py-0 ">
    <div class="text-white w-100 text-center">
      <small>
        {{fileName}}
      </small>
    </div>
    <div class="d-flex justify-content-end align-items-center">
      <slot name="content">

      </slot>
    </div>

  </b-card-header>
</template>
<script>
  import {
    mapState,
  } from 'vuex'
  export default {
    name: 'PreviewControl',
    data: function() {
      return {}
    },
    created() {},
    computed: mapState({
      fileName: state => state.dataPdf.fileName,
    }),
    methods: {},
  }
</script>
<style>
</style>
