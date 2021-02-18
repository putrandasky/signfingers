<template>
  <b-modal visible id="confirmSubmitModal" :no-close-on-backdrop="true" header-class="pb-0" :hide-header-close="true" centered @cancel="handleClickCancel" @ok="submitData">
    <template v-slot:modal-title>
      <b>
        {{'confirmSubmitModal.title' | trans}}
      </b>
    </template>
    <div class="text-white">
      {{'confirmSubmitModal.body' | trans}}
    </div>
    <template #modal-footer="{ ok, cancel }">
      <b-overlay :show="busy" rounded opacity="0.6" spinner-small spinner-variant="c-dark" class="d-inline-block">
        <b-button size="sm" variant="secondary" @click="cancel()">
          <i class="fa fa-close"></i>
          {{'confirmSubmitModal.button.cancel' | trans}}
        </b-button>
      </b-overlay>
      <b-overlay :show="busy" rounded opacity="0.6" spinner-small spinner-variant="c-dark" class="d-inline-block">

        <b-button size="sm" variant="warning" @click="ok()">
          <i class="fa fa-check"></i>
          {{'confirmSubmitModal.button.submit' | trans}} </b-button>
      </b-overlay>

    </template>

    <template />
  </b-modal>
</template>
<script>
  import {
    mapState,
    mapActions,
    mapMutations
  } from 'vuex'

  export default {
    name: 'ConfirmSubmit',

    data: function() {
      return {
        busy: false,
        input: {
          email: '',
          name: '',
        },
        errors: {
          email: null,
          name: null,
        },
        states: {
          email: null,
          name: null,
        },
      }
    },
    created() {},
    mounted() {

    },
    computed: {

    },
    methods: {
      ...mapActions(['setStep', 'setShowModal', 'restart', 'setLoading']),
      ...mapMutations(['SIGNERTOKEN']),

      handleClickCancel() {
        this.$bvModal.show('requesterFormModal')
      },
      submitData(e) {
        //to be added data validation
        e.preventDefault()
        this.busy = true

        this.$bvModal.hide('confirmSubmitModal')
        let data = {
          'signer': this.$store.state.signer,
          'requester': this.$store.state.requester,
          'fileName': this.$store.state.dataPdf.fileName,

        }
        let itemInput = JSON.stringify(data);
        var form = new FormData();
        form.append("itemInput", itemInput);
        form.append("itemFile", this.$store.state.dataPdf.raw);
        axios.post(`/sign-request`, form, {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          })
          .then((response) => {
            console.log(response.data)
            this.busy = false
            this.$bvModal.hide('confirmSubmitModal')
            this.$bvModal.show('endModal')
            this.SIGNERTOKEN(response.data.signer_token)
          })
          .catch((error) => {
            console.log(error.response.data);
          })
      },
      clearData() {
        //to be added clear all data
      }



    },
  }
</script>
<style>

</style>
