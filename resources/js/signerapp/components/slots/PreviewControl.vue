<template>
  <b-card-header header-border-variant="dark" header-bg-variant="dark" class=" py-0 ">
    <div class="text-white w-100 text-center">
      <small>
        {{fileName}}
      </small>
    </div>
    <div slot="content" class="d-flex justify-content-end align-items-center">

    </div>

  </b-card-header>
</template>
<script>
  export default {
    name: 'PreviewControl',
    props: ["fileName"],
    data: function() {
      return {}
    },
    created() {},
    methods: {},
  }
</script>
<style>
</style>
