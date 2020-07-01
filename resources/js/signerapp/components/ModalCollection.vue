<template>
  <div>
    <end-modal />
  </div>
</template>
<script>
  import {
    mapState,
    mapActions
  } from 'vuex'
  import EndModal from './ModalCollectionEndModal'
  import ShareSocialCollection from './ModalCollectionEndModalShare'
  export default {
    name: 'ModalCollection',
    components: {
      ShareSocialCollection,
      EndModal
    },
    data: function() {
      return {}
    },
    created() {},
    computed: {

    },
    methods: {},
  }
</script>
<style>

</style>
