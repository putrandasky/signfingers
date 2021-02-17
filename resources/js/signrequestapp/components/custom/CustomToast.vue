<template>
  <b-toast :variant="variant" solid :visible="visible">
    <template v-slot:toast-title>
      <div class="d-table">
        <i class="fa fa-2x  mr-2" :class="variantAttribute"></i>
        <span class="d-table-cell align-middle">
          <b class="h4">
            {{title}}
          </b>
        </span>
      </div>
    </template>

    {{body}}
  </b-toast>
</template>
<script>
  import {
    EventBus
  } from "@/signrequestapp/event.js";
  export default {
    name: 'CustomToast',
    data: function() {
      return {
        variant: '',
        title: '',
        body: '',
        visible: false,

      }
    },
    mounted() {
      EventBus.$on("showToast", data => {
        this.variant = data.variant
        this.title = data.title
        this.body = data.body
        this.visible = data.visible
        setTimeout(() => {
          this.visible = false
        }, 3000);
      })
    },
    computed: {
      variantAttribute() {
        return this.variant == 'success' ? 'fa-check-circle-o text-success' :
          this.variant == 'danger' ? 'fa-times-circle-o text-danger' : ''
      }
    },
    methods: {},
  }
</script>
<style>
</style>
