<template>
  <preview-control>

    <div slot="content" class="py-2 ">
      <!-- to be added "Add signer" button -->
      <b-btn size="sm" variant="warning " @click="handleClickNext">
        <i class="fa fa-check"></i>
        <b>
          {{'controlAddSigner.next' | trans}}

        </b>
      </b-btn>
    </div>
  </preview-control>
</template>
<script>
  import PreviewControl from '../slots/PreviewControl'
  import {
    mapState,
    mapActions
  } from 'vuex'
  export default {
    name: 'HeaderControlAddSigner',
    components: {
      PreviewControl
    },
    data: function() {
      return {}
    },
    created() {},
    computed: {},
    methods: {
      ...mapActions(['setStep']),
      handleClickNext() {
        this.$bvModal.show('requesterFormModal')
        this.setStep(4)
      },
    },
  }
</script>
<style>
</style>
