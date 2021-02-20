<template>
  <b-modal id="signerFormModal" header-class="pb-0" :hide-header-close="true" :no-close-on-backdrop="true" centered @ok="submitSignerData" ok-variant="warning" @cancel="handleClickCancel">
    <template v-slot:modal-title>
      <b>
        {{'signerFormModal.title' | trans}}
      </b>
    </template>
    <div>
      <b-form-group :state="states.name">
        <b-form-input id="name" variant="warning" v-model="input.name" :state="states.name" placeholder="signer name"></b-form-input>
        <b-form-invalid-feedback v-if="!$v.input.name.minLength">Please input min 6 Char</b-form-invalid-feedback>
        <b-form-invalid-feedback v-if="!$v.input.name.required">Signer name is required</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group :state="states.email">
        <b-form-input id="email" variant="warning" v-model="input.email" :state="states.email" placeholder="signer email"></b-form-input>
        <b-form-invalid-feedback v-if="!$v.input.email.email">Please input valid email format</b-form-invalid-feedback>
        <b-form-invalid-feedback v-if="!$v.input.email.required">Signer email is required</b-form-invalid-feedback>
      </b-form-group>

    </div>
    <template v-slot:modal-cancel>
      <i class="fa fa-close"></i>
      {{'signerFormModal.button.cancel' | trans}}
    </template>
    <template v-slot:modal-ok>
      <i class="fa fa-check"></i>
      {{'signerFormModal.button.submit' | trans}}
    </template>
  </b-modal>
</template>
<script>
  import {
    EventBus
  } from "@/signrequestapp/event.js";
  import {
    mapState,
    mapActions,
    mapMutations
  } from 'vuex'
  import {
    required,
    email,
    minLength
  } from "vuelidate/lib/validators";
  export default {
    name: 'SignerForm',

    data: function() {
      return {
        input: {
          email: '',
          name: '',
          area: []
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
    validations: {
      input: {
        name: {
          required,
          minLength: minLength(6)
        },
        email: {
          required,
          email
        }
      }
    },
    created() {},
    mounted() {
      EventBus.$on("reset", data => {
        this.handleClickCancel()
      })
    },
    computed: {

    },
    watch: {

      // '$v.input.name.minLength': function(newVal, oldVal) {
      //   this.$v.input.name.minLength && this.$v.input.name.required ? this.states.name = true : this.states.name = false
      // },
      // '$v.input.name.required': function(newVal, oldVal) {
      //   this.$v.input.name.minLength && this.$v.input.name.required ? this.states.name = true : this.states.name = false
      // },
      // '$v.input.email.email': function(newVal, oldVal) {
      //   this.$v.input.email.email && this.$v.input.email.required ? this.states.email = true : this.states.email = false
      // },
      // '$v.input.email.required': function(newVal, oldVal) {
      //   this.$v.input.email.email && this.$v.input.email.required ? this.states.email = true : this.states.email = false
      // },

    },
    methods: {
      ...mapActions(['setStep', 'setShowModal', 'restart']),
      ...mapMutations(['ADDSIGNER', 'REMOVESIGNER']),
      handleClickCancel() {
        setTimeout(() => {
          this.clearData()
        }, 100);
        this.REMOVESIGNER()
      },
      submitSignerData(e) {
        //to be added data validation
        this.$v.input.$touch();
        this.$v.input.name.minLength && this.$v.input.name.required ? this.states.name = true : this.states.name = false
        this.$v.input.email.email && this.$v.input.email.required ? this.states.email = true : this.states.email = false
        if (this.$v.input.$error) {

          e.preventDefault()
          return
        }
        this.$bvModal.hide('signerFormModal')

        this.ADDSIGNER(this.input)
        this.setStep(3)
      },
      clearData() {
        this.input = {
          email: '',
          name: '',
          area: []
        }
        this.errors = {
          email: null,
          name: null,
          messages: null
        }
        this.states = {
          email: null,
          name: null,
          messages: null
        }
      }



    },
  }
</script>
<style>

</style>
