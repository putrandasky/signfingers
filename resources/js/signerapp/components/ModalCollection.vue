<template>
  <div>
    <b-modal id="endModal" :hide-header-close="true" :no-close-on-backdrop="true" centered ok-variant="warning">
      <template v-slot:modal-title>
        <b>
          Thank You For Using This Apps!
        </b>
      </template>
      <div class="text-white">
        Your file is successfully signed and will be downloaded in shortly.
      </div>
      <template v-slot:modal-footer>
        <b-btn variant="warning" block @click="handleOkEndModal">
          <b>
            Sign another file
          </b>
        </b-btn>
      </template>
    </b-modal>
  </div>
</template>
<script>
  import {
    mapState,
    mapActions
  } from 'vuex'
  export default {
    name: 'ModalCollection',
    data: function() {
      return {}
    },
    created() {},
    computed: {
      isShowEndModal: {
        get() {
          return this.$store.state.isShowEndModal
        },
        set(value) {
          this.setShowModal({
            name: 'endModal',
            value: value
          })
        }
      },
    },
    methods: {
      ...mapActions(['setShowModal', 'restart']),
      handleOkEndModal() {
        this.$bvModal.hide('endModal')

        this.restart()
      }

    },
  }
</script>
<style>
</style>
