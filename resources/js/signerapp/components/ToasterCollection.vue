<template>
  <div>
    <b-toast id="download-toast" variant="success" solid>
      <template v-slot:toast-title>
        <div class="d-table">
          <i class="fa fa-2x fa-check-circle-o text-success mr-2"></i>
          <span class="d-table-cell align-middle">
            <b class="h4">
              SUCCESS
            </b>
          </span>
        </div>
      </template>
      Your file successfully signed
    </b-toast>
    <b-toast id="not-pdf-toast" variant="danger" solid>
      <template v-slot:toast-title>
        <div class="d-table">
          <i class="fa fa-2x fa-times-circle-o text-danger mr-2"></i>
          <span class="d-table-cell align-middle">
            <b class="h4">
              ERROR
            </b>
          </span>
        </div>
      </template>
      You are not attaching right PDF file
    </b-toast>
    <b-toast id="empty-signpad-toast" variant="danger" solid>
      <template v-slot:toast-title>
        <div class="d-table">
          <i class="fa fa-2x fa-times-circle-o text-danger mr-2"></i>
          <span class="d-table-cell align-middle">
            <b class="h4">
              ERROR
            </b>
          </span>
        </div>
      </template>
      You are not drawing any signature
    </b-toast>
  </div>
</template>
<script>
  export default {
    name: 'ToasterCollection',
    data: function() {
      return {}
    },
    created() {},
    methods: {},
  }
</script>
<style>
</style>
